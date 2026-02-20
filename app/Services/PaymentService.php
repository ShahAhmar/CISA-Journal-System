<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Journal;
use App\Models\Submission;
use Illuminate\Support\Facades\Http;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;

class PaymentService
{
    public function __construct()
    {
        // Initialize Stripe
        if (config('services.stripe.key')) {
            Stripe::setApiKey(config('services.stripe.secret'));
        }
    }

    /**
     * Create Stripe payment session
     */
    public function createStripeSession(Payment $payment, $successUrl, $cancelUrl)
    {
        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => strtolower($payment->currency),
                        'product_data' => [
                            'name' => $this->getPaymentDescription($payment),
                            'description' => $this->getPaymentDetails($payment),
                        ],
                        'unit_amount' => $payment->amount * 100, // Convert to cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => $successUrl . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => $cancelUrl,
                'metadata' => [
                    'payment_id' => $payment->id,
                    'journal_id' => $payment->journal_id,
                    'submission_id' => $payment->submission_id ?? null,
                ],
            ]);

            // Update payment with session ID
            $payment->update([
                'transaction_id' => $session->id,
                'payment_details' => ['stripe_session_id' => $session->id],
            ]);

            return $session;
        } catch (ApiErrorException $e) {
            \Log::error('Stripe payment error: ' . $e->getMessage());
            throw new \Exception('Failed to create payment session: ' . $e->getMessage());
        }
    }

    /**
     * Verify Stripe payment
     */
    public function verifyStripePayment($sessionId)
    {
        try {
            $session = Session::retrieve($sessionId);
            
            if ($session->payment_status === 'paid') {
                $payment = Payment::where('transaction_id', $sessionId)->first();
                
                if ($payment) {
                    $payment->update([
                        'status' => 'completed',
                        'payment_method' => 'stripe',
                        'payment_details' => array_merge($payment->payment_details ?? [], [
                            'stripe_payment_intent' => $session->payment_intent,
                            'customer_email' => $session->customer_details->email ?? null,
                        ]),
                    ]);

                    return $payment;
                }
            }

            return null;
        } catch (ApiErrorException $e) {
            \Log::error('Stripe verification error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Create PayPal payment
     */
    public function createPayPalPayment(Payment $payment, $successUrl, $cancelUrl)
    {
        $clientId = config('services.paypal.client_id');
        $clientSecret = config('services.paypal.client_secret');
        $mode = config('services.paypal.mode', 'sandbox');
        
        $baseUrl = $mode === 'sandbox' 
            ? 'https://api.sandbox.paypal.com'
            : 'https://api.paypal.com';

        // Get access token
        $tokenResponse = Http::asForm()->withBasicAuth($clientId, $clientSecret)
            ->post("{$baseUrl}/v1/oauth2/token", [
                'grant_type' => 'client_credentials',
            ]);

        if (!$tokenResponse->successful()) {
            throw new \Exception('Failed to get PayPal access token');
        }

        $accessToken = $tokenResponse->json()['access_token'];

        // Create payment order
        $orderResponse = Http::withToken($accessToken)
            ->post("{$baseUrl}/v2/checkout/orders", [
                'intent' => 'CAPTURE',
                'purchase_units' => [[
                    'reference_id' => 'payment_' . $payment->id,
                    'description' => $this->getPaymentDescription($payment),
                    'amount' => [
                        'currency_code' => $payment->currency,
                        'value' => number_format($payment->amount, 2, '.', ''),
                    ],
                ]],
                'application_context' => [
                    'brand_name' => $payment->journal->name,
                    'landing_page' => 'BILLING',
                    'user_action' => 'PAY_NOW',
                    'return_url' => $successUrl,
                    'cancel_url' => $cancelUrl,
                ],
            ]);

        if (!$orderResponse->successful()) {
            throw new \Exception('Failed to create PayPal order');
        }

        $order = $orderResponse->json();
        
        // Update payment with order ID
        $payment->update([
            'transaction_id' => $order['id'],
            'payment_details' => [
                'paypal_order_id' => $order['id'],
                'paypal_status' => $order['status'],
            ],
        ]);

        // Get approval URL
        $approvalUrl = collect($order['links'])->firstWhere('rel', 'approve')['href'] ?? null;

        return [
            'order_id' => $order['id'],
            'approval_url' => $approvalUrl,
        ];
    }

    /**
     * Verify PayPal payment
     */
    public function verifyPayPalPayment($orderId)
    {
        $clientId = config('services.paypal.client_id');
        $clientSecret = config('services.paypal.client_secret');
        $mode = config('services.paypal.mode', 'sandbox');
        
        $baseUrl = $mode === 'sandbox' 
            ? 'https://api.sandbox.paypal.com'
            : 'https://api.paypal.com';

        // Get access token
        $tokenResponse = Http::asForm()->withBasicAuth($clientId, $clientSecret)
            ->post("{$baseUrl}/v1/oauth2/token", [
                'grant_type' => 'client_credentials',
            ]);

        if (!$tokenResponse->successful()) {
            return null;
        }

        $accessToken = $tokenResponse->json()['access_token'];

        // Get order details
        $orderResponse = Http::withToken($accessToken)
            ->get("{$baseUrl}/v2/checkout/orders/{$orderId}");

        if (!$orderResponse->successful()) {
            return null;
        }

        $order = $orderResponse->json();

        if ($order['status'] === 'COMPLETED') {
            // Capture payment if not already captured
            if (isset($order['purchase_units'][0]['payments']['captures'][0])) {
                $payment = Payment::where('transaction_id', $orderId)->first();
                
                if ($payment && $payment->status === 'pending') {
                    $payment->update([
                        'status' => 'completed',
                        'payment_method' => 'paypal',
                        'payment_details' => array_merge($payment->payment_details ?? [], [
                            'paypal_capture_id' => $order['purchase_units'][0]['payments']['captures'][0]['id'],
                            'payer_email' => $order['payer']['email_address'] ?? null,
                        ]),
                    ]);

                    return $payment;
                }
            }
        }

        return null;
    }

    /**
     * Create payment record
     */
    public function createPayment(Journal $journal, $type, $amount, $currency = 'USD', Submission $submission = null, $userId = null)
    {
        return Payment::create([
            'journal_id' => $journal->id,
            'submission_id' => $submission?->id,
            'user_id' => $userId ?? auth()->id(),
            'type' => $type, // 'apc' or 'submission_fee'
            'amount' => $amount,
            'currency' => $currency,
            'status' => 'pending',
        ]);
    }

    /**
     * Get payment description
     */
    private function getPaymentDescription(Payment $payment)
    {
        if ($payment->type === 'apc') {
            return 'Article Processing Charge - ' . $payment->journal->name;
        } elseif ($payment->type === 'submission_fee') {
            return 'Submission Fee - ' . $payment->journal->name;
        }
        return 'Payment - ' . $payment->journal->name;
    }

    /**
     * Get payment details
     */
    private function getPaymentDetails(Payment $payment)
    {
        $details = [];
        
        if ($payment->submission) {
            $details[] = 'Article: ' . $payment->submission->title;
        }
        
        $details[] = 'Journal: ' . $payment->journal->name;
        $details[] = 'Amount: ' . $payment->currency . ' ' . number_format($payment->amount, 2);
        
        return implode(' | ', $details);
    }
}

