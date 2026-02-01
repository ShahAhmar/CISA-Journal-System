@extends('layouts.admin')

@section('title', 'Reviews Management - CISA')
@section('page-title', 'Peer Reviews')
@section('page-subtitle', 'Monitor and manage the peer review process')

@section('content')
    <div class="space-y-6">
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Total Assigned</p>
                    <p class="text-3xl font-bold text-cisa-base">{{ number_format($stats['total']) }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                    <i class="fas fa-clipboard-list"></i>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Pending</p>
                    <p class="text-3xl font-bold text-amber-500">{{ number_format($stats['pending']) }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                    <i class="fas fa-clock"></i>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Submitted</p>
                    <p class="text-3xl font-bold text-emerald-600">{{ number_format($stats['submitted']) }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Avg Turnaround</p>
                    <p class="text-3xl font-bold text-indigo-600">
                        {{ $stats['average_time'] ? round($stats['average_time']) : '-' }} <span
                            class="text-sm font-medium text-gray-400">days</span></p>
                </div>
                <div class="w-12 h-12 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl">
                    <i class="fas fa-stopwatch"></i>
                </div>
            </div>
        </div>

        <!-- Filters & Actions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <form method="GET" action="{{ route('admin.reviews.index') }}" class="grid grid-cols-1 md:grid-cols-6 gap-4">
                <div class="md:col-span-1">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Status</label>
                    <select name="status"
                        class="w-full px-3 py-2 bg-slate-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-cisa-accent">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="submitted" {{ request('status') === 'submitted' ? 'selected' : '' }}>Submitted</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="declined" {{ request('status') === 'declined' ? 'selected' : '' }}>Declined</option>
                    </select>
                </div>

                <div class="md:col-span-1">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Journal</label>
                    <select name="journal_id"
                        class="w-full px-3 py-2 bg-slate-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-cisa-accent">
                        <option value="">All Journals</option>
                        @foreach($journals as $journal)
                            <option value="{{ $journal->id }}" {{ request('journal_id') == $journal->id ? 'selected' : '' }}>
                                {{ $journal->journal_initials ?? Str::limit($journal->name, 10) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-1">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Reviewer</label>
                    <select name="reviewer_id"
                        class="w-full px-3 py-2 bg-slate-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-cisa-accent">
                        <option value="">Any Reviewer</option>
                        @foreach($reviewers ?? [] as $reviewer)
                            <option value="{{ $reviewer->id }}" {{ request('reviewer_id') == $reviewer->id ? 'selected' : '' }}>
                                {{ $reviewer->full_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-1">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Date (From)</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                        class="w-full px-3 py-2 bg-slate-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-cisa-accent">
                </div>
                <div class="md:col-span-1">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Date (To)</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}"
                        class="w-full px-3 py-2 bg-slate-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-cisa-accent">
                </div>

                <div class="md:col-span-1 flex items-end">
                    <button type="submit"
                        class="w-full py-2 bg-cisa-base hover:bg-slate-800 text-white rounded-lg text-sm font-bold transition-all shadow-md">
                        Filter Reviews
                    </button>
                </div>
            </form>
        </div>

        <!-- Reviews Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 border-b border-gray-100">
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Review ID</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Submission /
                                Journal</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Reviewer</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status & Rec.
                            </th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Timeline</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($reviews as $review)
                            <tr class="hover:bg-slate-50 transition-colors group">
                                <td class="px-6 py-4">
                                    <span class="font-mono text-xs text-gray-400">#{{ $review->id }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        @if($review->submission)
                                            <span class="text-sm font-bold text-cisa-base line-clamp-1"
                                                title="{{ $review->submission->title }}">{{ $review->submission->title }}</span>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span
                                                    class="text-[10px] bg-slate-100 px-1.5 py-0.5 rounded text-gray-500 font-mono">ID:
                                                    {{ $review->submission->id }}</span>
                                                @if($review->submission->journal)
                                                    <span class="text-[10px] text-gray-400 flex items-center gap-1">
                                                        <i class="fas fa-book"></i>
                                                        {{ $review->submission->journal->journal_initials ?? Str::limit($review->submission->journal->name, 15) }}
                                                    </span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-sm text-gray-400 italic">Submission Deleted</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($review->reviewer)
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-6 h-6 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs font-bold">
                                                {{ substr($review->reviewer->first_name, 0, 1) }}
                                            </div>
                                            <div class="flex flex-col">
                                                <span
                                                    class="text-sm font-medium text-gray-700">{{ $review->reviewer->full_name }}</span>
                                                <span class="text-[10px] text-gray-400">{{ $review->reviewer->email }}</span>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-400 italic">Reviewer Unknown</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-1.5 items-start">
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                                                'submitted' => 'bg-blue-50 text-blue-600 border-blue-100',
                                                'completed' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                                'declined' => 'bg-red-50 text-red-600 border-red-100',
                                                'long_overdue' => 'bg-red-50 text-red-600 border-red-100 font-bold'
                                            ];
                                            $isOverdue = $review->status === 'pending' && $review->due_date < now();
                                            $statusKey = $isOverdue ? 'long_overdue' : $review->status;
                                            $statusClass = $statusColors[$statusKey] ?? 'bg-gray-100 text-gray-600 border-gray-200';
                                            $statusLabel = $isOverdue ? 'Overdue' : ucfirst($review->status);
                                        @endphp
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $statusClass }}">
                                            {{ $statusLabel }}
                                        </span>

                                        @if($review->recommendation)
                                            @php
                                                $recColors = [
                                                    'accept' => 'text-emerald-600',
                                                    'minor_revision' => 'text-blue-600',
                                                    'major_revision' => 'text-amber-600',
                                                    'reject' => 'text-red-600'
                                                ];
                                                $recClass = $recColors[$review->recommendation] ?? 'text-gray-500';
                                            @endphp
                                            <span class="text-[10px] font-bold uppercase {{ $recClass }}">
                                                {{ str_replace('_', ' ', $review->recommendation) }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-1 text-xs text-gray-500">
                                        <span title="Assigned Date"><i class="fas fa-calendar-plus w-4 text-center"></i>
                                            {{ $review->assigned_date->format('M d') }}</span>
                                        <span title="Due Date"
                                            class="{{ $review->due_date < now() && $review->status === 'pending' ? 'text-red-500 font-bold' : '' }}">
                                            <i class="fas fa-hourglass-end w-4 text-center"></i>
                                            {{ $review->due_date->format('M d') }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.reviews.show', $review) }}"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-50 text-gray-400 hover:text-cisa-base hover:bg-white border border-transparent hover:border-gray-200 shadow-sm transition-all"
                                        title="View Review Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div
                                        class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                                        <i class="fas fa-search text-2xl"></i>
                                    </div>
                                    <h3 class="text-sm font-bold text-gray-900 mb-1">No reviews found</h3>
                                    <p class="text-xs text-gray-500">Try adjusting your filters.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($reviews->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-slate-50">
                    {{ $reviews->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection