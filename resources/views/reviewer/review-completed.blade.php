@extends('layouts.app')

@section('title', 'Review Completed - EMANP')

@section('content')
    <div class="min-h-screen bg-slate-50 pb-12">
        <!-- Hero Section -->
        <div class="bg-cisa-base text-white py-20 mb-12 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 right-0 w-64 h-64 bg-cisa-accent rounded-full -mr-32 -mt-32 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-600 rounded-full -ml-48 -mb-48 blur-3xl"></div>
            </div>

            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <div
                    class="w-24 h-24 bg-cisa-accent/20 border-2 border-cisa-accent/30 rounded-full flex items-center justify-center mx-auto mb-8 animate-bounce-slow">
                    <i class="fas fa-check text-4xl text-cisa-accent shadow-glow"></i>
                </div>
                <h1 class="text-4xl md:text-6xl font-black font-serif mb-4 leading-tight tracking-tight">
                    Thank You!
                </h1>
                <p class="text-slate-400 font-medium text-xl italic max-w-2xl mx-auto">
                    Your scholarly contribution through this peer review has been recorded successfully.
                </p>
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Review Summary -->
            <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-200 overflow-hidden mb-8">
                <div class="bg-slate-50 border-b border-slate-100 px-8 py-4">
                    <h2 class="text-sm font-black text-slate-900 uppercase tracking-widest flex items-center gap-2">
                        <i class="fas fa-clipboard-check text-cisa-accent"></i>
                        Review Summary
                    </h2>
                </div>

                <div class="p-8 space-y-8">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Manuscript
                            Title</label>
                        <p class="text-xl font-bold text-slate-900 leading-tight">{{ $review->submission->title }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Final
                                Recommendation</label>
                            <span
                                class="px-4 py-1.5 bg-cisa-base text-white rounded-full text-[10px] font-black uppercase tracking-widest">
                                {{ str_replace('_', ' ', $review->recommendation) }}
                            </span>
                        </div>
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100">
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Submission
                                Date</label>
                            <p class="text-slate-900 font-bold">
                                @php
                                    $reviewedAt = null;
                                    if ($review->reviewed_at) {
                                        try {
                                            $reviewedAt = $review->reviewed_at instanceof \Carbon\Carbon
                                                ? $review->reviewed_at
                                                : \Carbon\Carbon::parse($review->reviewed_at);
                                        } catch (\Exception $e) {
                                            $reviewedAt = null;
                                        }
                                    }
                                @endphp
                                {{ $reviewedAt ? $reviewedAt->format('M d, Y • h:i A') : ($review->submitted_date ? (\Carbon\Carbon::parse($review->submitted_date)->format('M d, Y • h:i A')) : 'N/A') }}
                            </p>
                        </div>
                    </div>

                    @if($review->comments_for_author)
                        <div class="p-6 rounded-2xl border-2 border-slate-100 bg-slate-50/50 italic">
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 non-italic">Confidential
                                Comments for Author</label>
                            <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-line">
                                {{ $review->comments_for_author }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="text-center">
                <a href="{{ route('reviewer.dashboard') }}"
                    class="inline-flex items-center gap-2 bg-slate-900 hover:bg-cisa-base text-white font-black text-xs uppercase tracking-widest py-4 px-8 rounded-2xl shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <i class="fas fa-th-large"></i> Return to Dashboard
                </a>
            </div>
        </div>
    </div>
@endsection