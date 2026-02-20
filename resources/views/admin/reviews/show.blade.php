@extends('layouts.admin')

@section('title', 'Review Details - #' . $review->id)
@section('page-title', 'Review Details')
@section('page-subtitle', 'Review #' . $review->id)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Review Info Card -->
    <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-[#0F1B4C]">Review Information</h3>
            <span class="px-4 py-2 rounded-full text-sm font-semibold
                {{ $review->status === 'submitted' ? 'bg-green-100 text-green-800' : 
                   ($review->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                {{ ucfirst($review->status) }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Review ID</label>
                <p class="text-lg font-bold text-[#0F1B4C]">#{{ $review->id }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Submission</label>
                @if($review->submission)
                <p class="text-lg text-[#0F1B4C]">{{ $review->submission->title }}</p>
                <a href="{{ route('admin.submissions.show', $review->submission) }}" 
                   class="text-[#0056FF] hover:text-[#0044CC] text-sm font-semibold">
                    <i class="fas fa-external-link-alt mr-1"></i>View Submission
                </a>
                @else
                <p class="text-lg text-red-600">Submission deleted</p>
                @endif
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Journal</label>
                @if($review->submission && $review->submission->journal)
                <p class="text-lg text-[#0F1B4C]">{{ $review->submission->journal->name }}</p>
                @else
                <p class="text-lg text-gray-400">N/A</p>
                @endif
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Reviewer</label>
                @if($review->reviewer)
                <p class="text-lg text-[#0F1B4C]">{{ $review->reviewer->full_name }}</p>
                <p class="text-sm text-gray-500">{{ $review->reviewer->email }}</p>
                @else
                <p class="text-lg text-red-600">Reviewer deleted</p>
                @endif
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Assigned Date</label>
                <p class="text-lg text-[#0F1B4C]">{{ $review->assigned_date->format('F d, Y') }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Due Date</label>
                <p class="text-lg text-[#0F1B4C] 
                    {{ $review->due_date < now() && $review->status === 'pending' ? 'text-red-600' : '' }}">
                    {{ $review->due_date->format('F d, Y') }}
                </p>
                @if($review->due_date < now() && $review->status === 'pending')
                <p class="text-sm text-red-500">Overdue</p>
                @endif
            </div>
            
            @if($review->submitted_date)
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Submitted Date</label>
                <p class="text-lg text-[#0F1B4C]">{{ $review->submitted_date->format('F d, Y') }}</p>
            </div>
            @endif
            
            @if($review->review_time_days)
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Review Time</label>
                <p class="text-lg text-[#0F1B4C]">{{ $review->review_time_days }} days</p>
            </div>
            @endif
            
            @if($review->recommendation)
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Recommendation</label>
                <span class="px-3 py-1 rounded-full text-sm font-semibold
                    {{ $review->recommendation === 'accept' ? 'bg-green-100 text-green-800' : 
                       ($review->recommendation === 'minor_revision' ? 'bg-blue-100 text-blue-800' : 
                       ($review->recommendation === 'major_revision' ? 'bg-orange-100 text-orange-800' : 'bg-red-100 text-red-800')) }}">
                    {{ ucfirst(str_replace('_', ' ', $review->recommendation)) }}
                </span>
            </div>
            @endif
            
            @if($review->reviewer_rating)
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Reviewer Rating</label>
                <div class="flex items-center">
                    <span class="text-lg font-bold text-[#0F1B4C] mr-2">{{ $review->reviewer_rating }}/5</span>
                    <div class="flex">
                        @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star {{ $i <= $review->reviewer_rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                        @endfor
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Comments -->
    @if($review->comments_for_editor || $review->comments_for_author || $review->comments_for_editors || $review->comments_for_authors)
    <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6">
        <h3 class="text-lg font-bold text-[#0F1B4C] mb-4">Review Comments</h3>
        
        @if($review->comments_for_editors)
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Comments for Editors (Separate)</label>
            <div class="bg-gray-50 rounded-lg p-4 text-gray-700">
                {!! nl2br(e($review->comments_for_editors)) !!}
            </div>
        </div>
        @endif
        
        @if($review->comments_for_editor)
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Comments for Editor</label>
            <div class="bg-gray-50 rounded-lg p-4 text-gray-700">
                {!! nl2br(e($review->comments_for_editor)) !!}
            </div>
        </div>
        @endif
        
        @if($review->comments_for_authors)
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Comments for Authors (Separate)</label>
            <div class="bg-gray-50 rounded-lg p-4 text-gray-700">
                {!! nl2br(e($review->comments_for_authors)) !!}
            </div>
        </div>
        @endif
        
        @if($review->comments_for_author)
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Comments for Author</label>
            <div class="bg-gray-50 rounded-lg p-4 text-gray-700">
                {!! nl2br(e($review->comments_for_author)) !!}
            </div>
        </div>
        @endif
    </div>
    @endif

    <!-- Expertise -->
    @if($review->reviewer_expertise)
    <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6">
        <h3 class="text-lg font-bold text-[#0F1B4C] mb-4">Reviewer Expertise</h3>
        <div class="flex flex-wrap gap-2">
            @foreach($review->reviewer_expertise as $expertise)
            <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-semibold">
                {{ $expertise }}
            </span>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Actions -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.reviews.index') }}" 
           class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-semibold transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Back to Reviews
        </a>
    </div>
</div>
@endsection

