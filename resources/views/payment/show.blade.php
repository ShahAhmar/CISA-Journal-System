@extends('layouts.app')

@section('title', 'Payment - ' . $journal->name)

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-8 mb-6">
            <div class="text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-credit-card text-white text-3xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-[#0F1B4C] mb-2">Complete Payment</h1>
                <p class="text-gray-600">{{ $journal->name }}</p>
            </div>
        </div>

        <!-- Payment Details -->
        <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-8 mb-6">
            <h2 class="text-xl font-bold text-[#0F1B4C] mb-6">Payment Details</h2>
            
            <div class="space-y-4 mb-6">
                <div class="flex justify-between items-center py-3 border-b border-gray-200">
                    <span class="text-gray-600 font-semibold">Payment Type:</span>
                    <span class="text-[#0F1B4C] font-bold">
                        @if($payment->type === 'apc')
                            Article Processing Charge (APC)
                        @else
                            Submission Fee
                        @endif
                    </span>
                </div>
                
                @if($submission)
                <div class="flex justify-between items-center py-3 border-b border-gray-200">
                    <span class="text-gray-600 font-semibold">Article:</span>
                    <span class="text-[#0F1B4C] font-bold">{{ $submission->title }}</span>
                </div>
                @endif
                
                <div class="flex justify-between items-center py-3 border-b border-gray-200">
                    <span class="text-gray-600 font-semibold">Journal:</span>
                    <span class="text-[#0F1B4C] font-bold">{{ $journal->name }}</span>
                </div>
                
                <div class="flex justify-between items-center py-4 bg-blue-50 rounded-lg px-4">
                    <span class="text-lg font-bold text-[#0F1B4C]">Total Amount:</span>
                    <span class="text-2xl font-bold text-[#0056FF]">
                        {{ $payment->currency }} {{ number_format($payment->amount, 2) }}
                    </span>
                </div>
            </div>

            <!-- Payment Methods -->
            <form method="POST" action="{{ route('payment.process', $payment) }}" id="paymentForm">
                @csrf
                
                <h3 class="text-lg font-bold text-[#0F1B4C] mb-4">Select Payment Method</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <!-- Stripe -->
                    <label class="relative">
                        <input type="radio" name="payment_method" value="stripe" required class="peer hidden">
                        <div class="border-2 border-gray-300 rounded-xl p-6 cursor-pointer hover:border-[#0056FF] transition-all peer-checked:border-[#0056FF] peer-checked:bg-blue-50">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-[#635BFF] rounded-lg flex items-center justify-center">
                                        <i class="fab fa-stripe text-white text-2xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-[#0F1B4C]">Stripe</h4>
                                        <p class="text-sm text-gray-600">Credit/Debit Card</p>
                                    </div>
                                </div>
                                <i class="fas fa-check-circle text-[#0056FF] text-xl hidden peer-checked:block"></i>
                            </div>
                        </div>
                    </label>

                    <!-- PayPal -->
                    <label class="relative">
                        <input type="radio" name="payment_method" value="paypal" required class="peer hidden">
                        <div class="border-2 border-gray-300 rounded-xl p-6 cursor-pointer hover:border-[#0056FF] transition-all peer-checked:border-[#0056FF] peer-checked:bg-blue-50">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-[#0070BA] rounded-lg flex items-center justify-center">
                                        <i class="fab fa-paypal text-white text-2xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-[#0F1B4C]">PayPal</h4>
                                        <p class="text-sm text-gray-600">PayPal Account</p>
                                    </div>
                                </div>
                                <i class="fas fa-check-circle text-[#0056FF] text-xl hidden peer-checked:block"></i>
                            </div>
                        </div>
                    </label>
                </div>

                <!-- Security Notice -->
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg mb-6">
                    <div class="flex items-start">
                        <i class="fas fa-shield-alt text-green-600 text-xl mr-3 mt-1"></i>
                        <div>
                            <h4 class="font-bold text-green-900 mb-1">Secure Payment</h4>
                            <p class="text-sm text-green-800">Your payment information is encrypted and secure. We never store your card details.</p>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-[#0056FF] to-indigo-600 hover:from-[#0044CC] hover:to-indigo-700 text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-300">
                    <i class="fas fa-lock mr-2"></i>Proceed to Payment
                </button>
            </form>
        </div>

        <!-- Help Section -->
        <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6">
            <h3 class="text-lg font-bold text-[#0F1B4C] mb-4">
                <i class="fas fa-question-circle text-[#0056FF] mr-2"></i>Need Help?
            </h3>
            <div class="space-y-2 text-sm text-gray-600">
                <p><i class="fas fa-envelope mr-2 text-[#0056FF]"></i>Email: {{ $journal->primary_contact_email ?? 'support@journal.com' }}</p>
                <p><i class="fas fa-phone mr-2 text-[#0056FF]"></i>Phone: {{ $journal->contact_phone ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

