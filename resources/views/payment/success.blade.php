@extends('layouts.app')

@section('title', 'Payment Successful')

@section('content')
    <div class="min-h-screen bg-slate-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <div
                class="bg-white rounded-[2rem] shadow-2xl shadow-slate-200/50 border border-slate-200 overflow-hidden text-center animate-fade-in">
                <!-- Header/Status -->
                <div class="bg-cisa-base py-12 relative overflow-hidden">
                    <div class="absolute inset-0 opacity-10">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-cisa-accent rounded-full -mr-16 -mt-16 blur-2xl">
                        </div>
                    </div>
                    <div class="relative z-10">
                        <div
                            class="w-16 h-16 bg-cisa-accent/20 border border-cisa-accent/30 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-check text-2xl text-cisa-accent"></i>
                        </div>
                        <h1 class="text-2xl font-black text-white uppercase tracking-widest">Payment Successful</h1>
                    </div>
                </div>

                <div class="p-8">
                    <p class="text-slate-500 font-medium mb-8">Your transaction has been processed and recorded successfully
                        into our archives.</p>

                    <!-- Transaction Details -->
                    <div class="bg-slate-50 rounded-2xl border border-slate-100 p-6 mb-8 text-left">
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Transaction
                                    ID</span>
                                <span
                                    class="text-xs font-bold text-slate-900 font-mono">{{ $payment->transaction_id }}</span>
                            </div>
                            <div class="h-px bg-slate-200/50 w-full"></div>
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total
                                    Amount</span>
                                <span class="text-sm font-black text-cisa-base">{{ $payment->currency }}
                                    {{ number_format($payment->amount, 2) }}</span>
                            </div>
                            <div class="h-px bg-slate-200/50 w-full"></div>
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Payment
                                    Method</span>
                                <span
                                    class="text-xs font-bold text-slate-700 capitalize">{{ $payment->payment_method }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-3">
                        @if($payment->submission)
                            <a href="{{ route('author.submissions.show', $payment->submission) }}"
                                class="flex items-center justify-center gap-2 w-full bg-slate-900 hover:bg-cisa-base text-white font-black text-[10px] uppercase tracking-widest py-4 px-6 rounded-xl shadow-lg transition-all hover:-translate-y-0.5">
                                <i class="fas fa-file-invoice text-cisa-accent"></i> View Submission
                            </a>
                        @endif

                        <a href="{{ route('journals.show', $payment->journal) }}"
                            class="flex items-center justify-center gap-2 w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-black text-[10px] uppercase tracking-widest py-4 px-6 rounded-xl transition-all">
                            <i class="fas fa-university"></i> Back to Journal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection