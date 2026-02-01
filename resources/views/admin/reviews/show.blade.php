@extends('layouts.admin')

@section('title', 'Review Details - CISA')
@section('page-title', 'Review Audit')
@section('page-subtitle', 'Detailed view of review #' . $review->id)

@section('content')
    <div class="max-w-5xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Left Column: Review Overview -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Review Info Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-slate-50 border-b border-gray-100 px-6 py-4 flex justify-between items-center">
                    <h3 class="font-bold text-cisa-base flex items-center gap-2">
                        <i class="fas fa-clipboard-check text-cisa-accent"></i> Review Metadata
                    </h3>
                    @php
                        $statusColors = [
                            'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                            'submitted' => 'bg-blue-50 text-blue-600 border-blue-100',
                            'completed' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                            'declined' => 'bg-red-50 text-red-600 border-red-100'
                        ];
                        $statusClass = $statusColors[$review->status] ?? 'bg-gray-50 text-gray-600 border-gray-100';
                    @endphp
                    <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $statusClass }}">
                        {{ ucfirst($review->status) }}
                    </span>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Assigned
                            Context</label>
                        @if($review->submission)
                            <div class="font-bold text-cisa-base">{{ $review->submission->title }}</div>
                            @if($review->submission->journal)
                                <div class="text-xs text-gray-500 mt-0.5">
                                    <i class="fas fa-book mr-1"></i> {{ $review->submission->journal->name }}
                                </div>
                            @endif
                            <a href="{{ route('admin.submissions.show', $review->submission) }}"
                                class="inline-flex items-center gap-1 text-xs text-cisa-accent hover:underline mt-2 font-bold">
                                View Submission <i class="fas fa-arrow-right"></i>
                            </a>
                        @else
                            <span class="text-red-500 italic">Submission Deleted</span>
                        @endif
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Reviewer</label>
                        @if($review->reviewer)
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-8 h-8 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center text-xs font-bold">
                                    {{ substr($review->reviewer->first_name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-bold text-gray-800">{{ $review->reviewer->full_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $review->reviewer->email }}</div>
                                </div>
                            </div>
                        @else
                            <span class="text-red-500 italic">Reviewer User Deleted</span>
                        @endif
                    </div>

                    <div class="col-span-1 md:col-span-2 border-t border-gray-100 pt-4 flex justify-between">
                        <div>
                            <label
                                class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Timeline</label>
                            <div class="flex gap-6 text-sm">
                                <div>
                                    <span class="text-gray-400 text-xs block">Assigned</span>
                                    <span
                                        class="font-medium text-gray-700">{{ $review->assigned_date->format('M d, Y') }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-400 text-xs block">Due</span>
                                    <span
                                        class="font-medium {{ $review->due_date < now() && $review->status === 'pending' ? 'text-red-500 font-bold' : 'text-gray-700' }}">
                                        {{ $review->due_date->format('M d, Y') }}
                                    </span>
                                </div>
                                @if($review->submitted_date)
                                    <div>
                                        <span class="text-gray-400 text-xs block">Submitted</span>
                                        <span
                                            class="font-medium text-emerald-600">{{ $review->submitted_date->format('M d, Y') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @if($review->review_time_days)
                            <div class="text-right">
                                <label
                                    class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Turnaround</label>
                                <span class="text-2xl font-bold text-cisa-base">{{ $review->review_time_days }}</span> <span
                                    class="text-xs text-gray-400">days</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Review Result Card -->
            @if($review->status === 'completed' || $review->status === 'submitted')
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-slate-50 border-b border-gray-100 px-6 py-4">
                        <h3 class="font-bold text-cisa-base flex items-center gap-2">
                            <i class="fas fa-poll text-cisa-accent"></i> Review Outcome
                        </h3>
                    </div>
                    <div class="p-6 space-y-6">
                        @if($review->recommendation)
                            <div class="flex items-center justify-between bg-slate-50 p-4 rounded-lg border border-gray-200">
                                <span class="font-bold text-gray-600">Final Recommendation</span>
                                @php
                                    $recColors = [
                                        'accept' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                        'minor_revision' => 'bg-blue-100 text-blue-700 border-blue-200',
                                        'major_revision' => 'bg-amber-100 text-amber-700 border-amber-200',
                                        'reject' => 'bg-red-100 text-red-700 border-red-200'
                                    ];
                                    $recClass = $recColors[$review->recommendation] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span
                                    class="px-4 py-1.5 rounded-lg text-sm font-bold border {{ $recClass }} uppercase tracking-wide">
                                    {{ str_replace('_', ' ', $review->recommendation) }}
                                </span>
                            </div>
                        @endif

                        @if($review->reviewer_rating)
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Quality
                                    Rating</label>
                                <div class="flex items-center gap-2">
                                    <div class="flex text-amber-400 text-lg">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $review->reviewer_rating ? '' : 'text-gray-200' }}"></i>
                                        @endfor
                                    </div>
                                    <span class="text-sm font-bold text-gray-700 ml-2">{{ $review->reviewer_rating }}/5</span>
                                </div>
                            </div>
                        @endif

                        <!-- Comments Section -->
                        @if($review->comments_for_editor || $review->comments_for_author)
                            <div class="space-y-4 pt-4 border-t border-gray-100">
                                @if($review->comments_for_editor)
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2"><i
                                                class="fas fa-lock text-xs mr-1"></i> Private Comments (Editor Only)</label>
                                        <div
                                            class="bg-yellow-50 rounded-lg p-4 text-sm text-gray-700 border border-yellow-100 leading-relaxed font-serif">
                                            {!! nl2br(e($review->comments_for_editor)) !!}
                                        </div>
                                    </div>
                                @endif

                                @if($review->comments_for_author)
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2"><i
                                                class="fas fa-eye text-xs mr-1"></i> Author Comments</label>
                                        <div
                                            class="bg-slate-50 rounded-lg p-4 text-sm text-gray-700 border border-gray-200 leading-relaxed font-serif">
                                            {!! nl2br(e($review->comments_for_author)) !!}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Right Column: Actions & Expertise -->
        <div class="space-y-6">
            <!-- Actions Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-cisa-base mb-4 text-sm uppercase tracking-wider">Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.reviews.index') }}"
                        class="block w-full py-2 px-4 bg-gray-100 hover:bg-gray-200 text-gray-700 text-center rounded-lg font-bold text-sm transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i> Back to List
                    </a>
                    @if($review->status !== 'completed' && $review->status !== 'declined')
                        <button type="button"
                            class="block w-full py-2 px-4 bg-red-50 hover:bg-red-100 text-red-600 text-center rounded-lg font-bold text-sm transition-colors border border-red-100">
                            <i class="fas fa-times mr-2"></i> Cancel Review
                        </button>
                        <!-- Note: Implementation for cancel logic would go here -->
                    @endif
                </div>
            </div>

            @if($review->reviewer_expertise)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-cisa-base mb-4 text-sm uppercase tracking-wider">Reviewer Expertise</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($review->reviewer_expertise as $expertise)
                            <span
                                class="px-2.5 py-1 bg-purple-50 text-purple-700 rounded-md text-xs font-bold border border-purple-100">
                                {{ $expertise }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection