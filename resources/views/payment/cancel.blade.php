@extends('layouts.app')

@section('title', 'Payment Cancelled')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8 flex items-center justify-center">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-xl shadow-2xl border-2 border-orange-200 p-8 text-center">
            <div class="w-20 h-20 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-times text-white text-4xl"></i>
            </div>
            
            <h1 class="text-3xl font-bold text-[#0F1B4C] mb-3">Payment Cancelled</h1>
            <p class="text-gray-600 mb-6">Your payment was cancelled. No charges were made.</p>
            
            <div class="space-y-3">
                <a href="{{ route('payment.show', [$payment->journal, $payment->type, $payment->submission]) }}" 
                   class="block w-full bg-[#0056FF] hover:bg-[#0044CC] text-white font-bold py-3 px-6 rounded-xl transition-colors">
                    <i class="fas fa-redo mr-2"></i>Try Again
                </a>
                
                <a href="{{ route('journals.show', $payment->journal) }}" 
                   class="block w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 px-6 rounded-xl transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Journal
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

