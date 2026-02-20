@extends('layouts.app')

@section('title', 'Review Completed - EMANP')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Success Message -->
        <div class="bg-white rounded-2xl shadow-xl border-2 border-green-200 p-8 mb-6 text-center">
            <div class="mb-4">
                <i class="fas fa-check-circle text-6xl text-green-600"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Thank You!</h1>
            <p class="text-gray-600 text-lg">Your review has been submitted successfully.</p>
        </div>

        <!-- Review Summary -->
        <div class="bg-white rounded-2xl shadow-xl border-2 border-gray-200 p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Review Summary</h2>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Article Title</label>
                    <p class="text-gray-900">{{ $review->submission->title }}</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Recommendation</label>
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                            {{ ucfirst(str_replace('_', ' ', $review->recommendation)) }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Submitted Date</label>
                        <p class="text-gray-700">{{ $review->reviewed_at->format('F d, Y h:i A') }}</p>
                    </div>
                </div>

                @if($review->comments_for_author)
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Comments for Author</label>
                        <p class="text-gray-700 text-sm">{{ $review->comments_for_author }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Actions -->
        <div class="text-center">
            <a href="{{ route('reviewer.dashboard') }}" 
               class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection





