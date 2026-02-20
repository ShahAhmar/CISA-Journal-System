@extends('layouts.admin')

@section('title', 'Reviews Management - EMANP')
@section('page-title', 'Reviews Management')
@section('page-subtitle', 'View and manage all peer reviews')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-semibold">Total Reviews</p>
                    <p class="text-3xl font-bold mt-2">{{ number_format($stats['total']) }}</p>
                </div>
                <i class="fas fa-clipboard-check text-4xl opacity-50"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-semibold">Pending</p>
                    <p class="text-3xl font-bold mt-2">{{ number_format($stats['pending']) }}</p>
                </div>
                <i class="fas fa-clock text-4xl opacity-50"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-semibold">Submitted</p>
                    <p class="text-3xl font-bold mt-2">{{ number_format($stats['submitted']) }}</p>
                </div>
                <i class="fas fa-check-circle text-4xl opacity-50"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-semibold">Avg Review Time</p>
                    <p class="text-3xl font-bold mt-2">
                        {{ $stats['average_time'] ? round($stats['average_time']) : 'N/A' }} days
                    </p>
                </div>
                <i class="fas fa-hourglass-half text-4xl opacity-50"></i>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6">
        <form method="GET" action="{{ route('admin.reviews.index') }}" class="grid grid-cols-1 md:grid-cols-6 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF]">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="submitted" {{ request('status') === 'submitted' ? 'selected' : '' }}>Submitted</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="declined" {{ request('status') === 'declined' ? 'selected' : '' }}>Declined</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Journal</label>
                <select name="journal_id" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF]">
                    <option value="">All Journals</option>
                    @foreach($journals as $journal)
                    <option value="{{ $journal->id }}" {{ request('journal_id') == $journal->id ? 'selected' : '' }}>
                        {{ $journal->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Reviewer</label>
                <select name="reviewer_id" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF]">
                    <option value="">All Reviewers</option>
                    @foreach($reviewers ?? [] as $reviewer)
                    <option value="{{ $reviewer->id }}" {{ request('reviewer_id') == $reviewer->id ? 'selected' : '' }}>
                        {{ $reviewer->full_name }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Date From</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" 
                       class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF]">
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Date To</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" 
                       class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF]">
            </div>
            
            <div class="flex items-end">
                <button type="submit" class="w-full px-6 py-2 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors">
                    <i class="fas fa-filter mr-2"></i>Apply Filters
                </button>
            </div>
        </form>
    </div>

    <!-- Reviews Table -->
    <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-[#0F1B4C]">
                <i class="fas fa-list mr-2 text-[#0056FF]"></i>All Reviews
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-[#0056FF] to-[#1D72B8]">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Submission</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Journal</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Reviewer</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Recommendation</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Assigned</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Due Date</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-white uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($reviews as $review)
                    <tr class="hover:bg-blue-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900">#{{ $review->id }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @if($review->submission)
                            <div class="text-sm font-semibold text-gray-900">{{ Str::limit($review->submission->title ?? 'N/A', 40) }}</div>
                            <div class="text-xs text-gray-500">#{{ $review->submission->id }}</div>
                            @else
                            <span class="text-gray-400">Submission deleted</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($review->submission && $review->submission->journal)
                            <div class="text-sm text-gray-700">{{ $review->submission->journal->name }}</div>
                            @else
                            <span class="text-gray-400">N/A</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($review->reviewer)
                            <div class="text-sm text-gray-700">{{ $review->reviewer->full_name }}</div>
                            <div class="text-xs text-gray-500">{{ $review->reviewer->email }}</div>
                            @else
                            <span class="text-gray-400">Reviewer deleted</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                {{ in_array($review->status, ['submitted', 'completed']) ? 'bg-green-100 text-green-800' : 
                                   ($review->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($review->status === 'declined' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                                {{ ucfirst($review->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($review->recommendation)
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                {{ $review->recommendation === 'accept' ? 'bg-green-100 text-green-800' : 
                                   ($review->recommendation === 'minor_revision' ? 'bg-blue-100 text-blue-800' : 
                                   ($review->recommendation === 'major_revision' ? 'bg-orange-100 text-orange-800' : 'bg-red-100 text-red-800')) }}">
                                {{ ucfirst(str_replace('_', ' ', $review->recommendation)) }}
                            </span>
                            @else
                            <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-700">{{ $review->assigned_date->format('M d, Y') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-700 
                                {{ $review->due_date < now() && $review->status === 'pending' ? 'text-red-600 font-semibold' : '' }}">
                                {{ $review->due_date->format('M d, Y') }}
                            </div>
                            @if($review->due_date < now() && $review->status === 'pending')
                            <div class="text-xs text-red-500">Overdue</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right text-sm font-medium">
                            <a href="{{ route('admin.reviews.show', $review) }}" 
                               class="text-[#0056FF] hover:text-[#0044CC] font-semibold">
                                <i class="fas fa-eye mr-1"></i>View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-12 text-center">
                            <i class="fas fa-clipboard-check text-6xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500 text-lg font-semibold">No reviews found</p>
                            <p class="text-gray-400">Reviews will appear here when assigned</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($reviews->hasPages())
        <div class="p-6 border-t border-gray-200">
            {{ $reviews->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

