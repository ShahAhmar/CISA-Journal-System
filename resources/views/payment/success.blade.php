@extends('layouts.app')

@section('title', 'Payment Successful')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8 flex items-center justify-center">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-xl shadow-2xl border-2 border-green-200 p-8 text-center">
            <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-check text-white text-4xl"></i>
            </div>
            
            <h1 class="text-3xl font-bold text-[#0F1B4C] mb-3">Payment Successful!</h1>
            <p class="text-gray-600 mb-6">Your payment has been processed successfully.</p>
            
            <div class="bg-gray-50 rounded-lg p-4 mb-6 text-left">
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Transaction ID:</span>
                        <span class="font-semibold text-[#0F1B4C]">{{ $payment->transaction_id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Amount:</span>
                        <span class="font-semibold text-[#0056FF]">{{ $payment->currency }} {{ number_format($payment->amount, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Payment Method:</span>
                        <span class="font-semibold text-[#0F1B4C]">{{ ucfirst($payment->payment_method) }}</span>
                    </div>
                </div>
            </div>
            
            <div class="space-y-3">
                @if($payment->submission)
                <a href="{{ route('author.submissions.show', $payment->submission) }}" 
                   class="block w-full bg-[#0056FF] hover:bg-[#0044CC] text-white font-bold py-3 px-6 rounded-xl transition-colors">
                    <i class="fas fa-file-alt mr-2"></i>View Submission
                </a>
                @endif
                
                <a href="{{ route('journals.show', $payment->journal) }}" 
                   class="block w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 px-6 rounded-xl transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Journal
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

