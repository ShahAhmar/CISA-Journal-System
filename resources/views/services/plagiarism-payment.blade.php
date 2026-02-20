@extends('layouts.app')

@section('title', 'Payment - Plagiarism Check Service')

@section('content')
    <div class="min-h-screen bg-gray-50 py-20">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-12 text-center">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-8">
                    <i class="fas fa-credit-card text-green-600 text-3xl"></i>
                </div>

                <h1 class="text-3xl font-bold text-[#0F1B4C] mb-4">Complete Your Payment</h1>
                <p class="text-gray-600 mb-10">
                    You are paying <strong>$20</strong> for a professional plagiarism check service.
                    Once payment is confirmed, our team will begin the analysis.
                </p>

                <div class="space-y-4 mb-10">
                    <div class="flex items-center justify-between p-4 bg-[#F7F9FC] rounded-xl border border-gray-100">
                        <span class="text-gray-600 font-medium">Service Fee</span>
                        <span class="font-bold text-[#0F1B4C]">$20.00</span>
                    </div>
                    <div
                        class="flex items-center justify-between p-4 bg-[#F7F9FC] rounded-xl border border-gray-100 font-bold">
                        <span class="text-[#0F1B4C]">Total</span>
                        <span class="text-[#0056FF]">$20.00</span>
                    </div>
                </div>

                <!-- Dummy Payment Button -->
                <form action="{{ route('journals.index') }}" method="GET">
                    <button type="submit"
                        class="w-full bg-[#0056FF] hover:bg-[#0044CC] text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-[1.01] transition-all mb-6">
                        Pay with Flutterwave / Stripe
                    </button>
                </form>

                <p class="text-xs text-gray-400">
                    <i class="fas fa-lock mr-1"></i> Secure encounter. Your payment information is encrypted and never
                    stored on our servers.
                </p>

                <a href="{{ route('plagiarism.index') }}"
                    class="inline-block mt-8 text-sm text-gray-500 hover:text-[#0056FF] transition-colors underline">
                    Go back and change file
                </a>
            </div>
        </div>
    </div>
@endsection