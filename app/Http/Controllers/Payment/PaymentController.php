<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use App\Models\Payment;
use App\Models\Submission;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
        $this->middleware('auth');
    }

    /**
     * Show payment page
     */
    public function show(Journal $journal, $type, Submission $submission = null)
    {
        // Get payment settings from journal
        $paymentSettings = $journal->payment_settings ?? [];

        $amount = 0;

        // 1. Try to find a PaymentMethod config for this service type (New logic)
        $methodConfig = \App\Models\PaymentMethod::where('journal_id', $journal->id)
            ->where('service_type', $type)
            ->where('is_active', true)
            ->first();

        if ($methodConfig) {
            // Determine amount based on region
            $userCountry = auth()->user()->country ?? 'Unknown';
            $africanCountries = ['Nigeria', 'Kenya', 'South Africa', 'Ghana', 'Egypt', 'Ethiopia', 'Tanzania', 'Uganda', 'Algeria', 'Morocco', 'Angola', 'Mozambique', 'Madagascar', 'Cameroon', 'Ivory Coast', 'Niger', 'Burkina Faso', 'Mali', 'Malawi', 'Zambia', 'Senegal', 'Chad', 'Somalia', 'Zimbabwe', 'Guinea', 'Rwanda', 'Benin', 'Burundi', 'Tunisia', 'South Sudan', 'Togo', 'Sierra Leone', 'Libya', 'Congo', 'Liberia', 'Central African Republic', 'Mauritania', 'Eritrea', 'Namibia', 'Gambia', 'Botswana', 'Gabon', 'Lesotho', 'Guinea-Bissau', 'Equatorial Guinea', 'Mauritius', 'Eswatini', 'Djibouti', 'Comoros', 'Cabo Verde', 'Sao Tome and Principe', 'Seychelles'];

            $isAfrica = in_array($userCountry, $africanCountries);
            $isDeveloping = false; // Add list if needed

            if ($isAfrica && isset($methodConfig->fees['africa']) && $methodConfig->fees['africa'] > 0) {
                $amount = $methodConfig->fees['africa'];
            } elseif ($isDeveloping && isset($methodConfig->fees['developing']) && $methodConfig->fees['developing'] > 0) {
                $amount = $methodConfig->fees['developing'];
            } else {
                $amount = $methodConfig->fixed_amount ?? 0;
            }
        }
        // 2. Fallback to legacy settings
        elseif ($type === 'apc') {
            $amount = $paymentSettings['apc_amount'] ?? 0;
        } elseif ($type === 'submission_fee') {
            $amount = $paymentSettings['submission_fee_amount'] ?? 0;
        }

        // Check if payment already exists
        $existingPayment = Payment::where('journal_id', $journal->id)
            ->where('submission_id', $submission?->id)
            ->where('user_id', auth()->id())
            ->where('type', $type)
            ->where('status', 'completed')
            ->first();

        if ($existingPayment) {
            return redirect()->route('payment.success', $existingPayment)
                ->with('info', 'Payment already completed for this submission.');
        }

        // Create payment record
        $payment = $this->paymentService->createPayment(
            $journal,
            $type,
            $amount,
            $paymentSettings['currency'] ?? 'USD',
            $submission,
            auth()->id()
        );

        return view('payment.show', compact('journal', 'payment', 'type', 'submission'));
    }

    /**
     * Process payment - redirect to gateway
     */
    public function process(Request $request, Payment $payment)
    {
        $request->validate([
            'payment_method' => 'required|in:stripe,paypal',
        ]);

        $successUrl = route('payment.success', $payment);
        $cancelUrl = route('payment.cancel', $payment);

        try {
            if ($request->payment_method === 'stripe') {
                $session = $this->paymentService->createStripeSession($payment, $successUrl, $cancelUrl);
                return redirect($session->url);
            } elseif ($request->payment_method === 'paypal') {
                $paypalData = $this->paymentService->createPayPalPayment($payment, $successUrl, $cancelUrl);
                return redirect($paypalData['approval_url']);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Payment processing failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Payment success callback
     */
    public function success(Request $request, Payment $payment)
    {
        // Verify payment based on method
        if ($request->has('session_id')) {
            // Stripe callback
            $verifiedPayment = $this->paymentService->verifyStripePayment($request->session_id);
        } elseif ($request->has('token') || $request->has('PayerID')) {
            // PayPal callback
            $orderId = $request->get('token') ?? $payment->transaction_id;
            $verifiedPayment = $this->paymentService->verifyPayPalPayment($orderId);
        } else {
            $verifiedPayment = $payment;
        }

        if ($verifiedPayment && $verifiedPayment->status === 'completed') {
            // Trigger payment completed event if needed
            // event(new PaymentCompleted($verifiedPayment));

            return view('payment.success', compact('payment'));
        }

        return redirect()->route('payment.show', [
            $payment->journal,
            $payment->type,
            $payment->submission
        ])->withErrors(['error' => 'Payment verification failed. Please contact support.']);
    }

    /**
     * Payment cancel callback
     */
    public function cancel(Payment $payment)
    {
        return view('payment.cancel', compact('payment'));
    }

    /**
     * Payment webhook (for Stripe/PayPal)
     */
    public function webhook(Request $request, $gateway)
    {
        // Handle webhook based on gateway
        if ($gateway === 'stripe') {
            return $this->handleStripeWebhook($request);
        } elseif ($gateway === 'paypal') {
            return $this->handlePayPalWebhook($request);
        }

        return response()->json(['error' => 'Invalid gateway'], 400);
    }

    private function handleStripeWebhook(Request $request)
    {
        // Stripe webhook handling
        // Verify webhook signature and process events
        return response()->json(['received' => true]);
    }

    private function handlePayPalWebhook(Request $request)
    {
        // PayPal webhook handling
        return response()->json(['received' => true]);
    }
}

