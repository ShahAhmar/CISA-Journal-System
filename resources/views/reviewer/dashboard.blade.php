@extends('layouts.app')

@section('title', 'Reviewer Dashboard - EMANP')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Hero Header -->
        <div class="bg-gradient-to-r from-[#0056FF] to-[#1D72B8] rounded-2xl shadow-2xl p-8 mb-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold mb-2 flex items-center">
                        <i class="fas fa-user-check mr-3"></i>My Assigned Reviews
                    </h1>
                    <p class="text-blue-100 text-lg">Welcome back, {{ auth()->user()->full_name }}</p>
                    <p class="text-blue-200 text-sm mt-1">Manage your review assignments (Double-blind review)</p>
                </div>
                <div class="hidden md:block">
                    <i class="fas fa-clipboard-check text-8xl opacity-20"></i>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
            <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-5 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-clock text-xl text-yellow-600"></i>
                    </div>
                </div>
                <p class="text-gray-600 text-xs font-semibold mb-1">Pending</p>
                <p class="text-3xl font-bold text-yellow-600">{{ $stats['pending'] ?? 0 }}</p>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-5 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-spinner text-xl text-blue-600"></i>
                    </div>
                </div>
                <p class="text-gray-600 text-xs font-semibold mb-1">In Progress</p>
                <p class="text-3xl font-bold text-blue-600">{{ $stats['in_progress'] ?? 0 }}</p>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-5 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-circle text-xl text-green-600"></i>
                    </div>
                </div>
                <p class="text-gray-600 text-xs font-semibold mb-1">Completed</p>
                <p class="text-3xl font-bold text-green-600">{{ $stats['completed'] ?? 0 }}</p>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-5 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-times-circle text-xl text-red-600"></i>
                    </div>
                </div>
                <p class="text-gray-600 text-xs font-semibold mb-1">Declined</p>
                <p class="text-3xl font-bold text-red-600">{{ $stats['declined'] ?? 0 }}</p>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-5 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-xl text-orange-600"></i>
                    </div>
                </div>
                <p class="text-gray-600 text-xs font-semibold mb-1">Overdue</p>
                <p class="text-3xl font-bold text-orange-600">{{ $stats['overdue'] ?? 0 }}</p>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-5 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-file-alt text-xl text-purple-600"></i>
                    </div>
                </div>
                <p class="text-gray-600 text-xs font-semibold mb-1">Total</p>
                <p class="text-3xl font-bold text-purple-600">{{ $stats['total'] ?? 0 }}</p>
            </div>
        </div>

        <!-- Reviews Table -->
        <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-[#0056FF] to-[#1D72B8] p-6">
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <i class="fas fa-list mr-3"></i>My Review Assignments
                </h2>
            </div>
            
            @if($reviews->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Article Title</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Journal</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Assigned</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Due Date</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($reviews as $review)
                                @php
                                    $isOverdue = $review->due_date && $review->due_date->isPast() && 
                                                !in_array($review->status, ['completed', 'declined']);
                                @endphp
                                <tr class="hover:bg-blue-50 transition-colors {{ $isOverdue ? 'bg-red-50' : '' }}">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-semibold text-gray-900">
                                            {{ Str::limit($review->submission->title ?? 'N/A', 50) }}
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">Submission ID: #{{ $review->submission_id }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700 font-medium">
                                        {{ $review->submission->journal->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'in_progress' => 'bg-blue-100 text-blue-800',
                                                'completed' => 'bg-green-100 text-green-800',
                                                'declined' => 'bg-red-100 text-red-800',
                                            ];
                                            $statusColor = $statusColors[$review->status] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                                            {{ ucfirst(str_replace('_', ' ', $review->status)) }}
                                        </span>
                                        @if($isOverdue)
                                            <span class="ml-2 px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">
                                                Overdue
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $review->assigned_date ? $review->assigned_date->format('M d, Y') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm {{ $isOverdue ? 'text-red-600 font-semibold' : 'text-gray-600' }}">
                                        {{ $review->due_date ? $review->due_date->format('M d, Y') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @if($review->status === 'pending')
                                            <a href="{{ route('reviewer.initial-review.show', $review) }}" 
                                               class="text-[#0056FF] hover:text-[#0044CC] font-semibold inline-flex items-center mr-3">
                                                <i class="fas fa-check-circle mr-1"></i>Respond
                                            </a>
                                        @elseif($review->status === 'in_progress')
                                            <a href="{{ route('reviewer.review.show', $review) }}" 
                                               class="text-[#0056FF] hover:text-[#0044CC] font-semibold inline-flex items-center">
                                                <i class="fas fa-edit mr-1"></i>Review
                                            </a>
                                        @elseif($review->status === 'completed')
                                            <a href="{{ route('reviewer.review.show', $review) }}" 
                                               class="text-green-600 hover:text-green-700 font-semibold inline-flex items-center">
                                                <i class="fas fa-eye mr-1"></i>View
                                            </a>
                                        @else
                                            <span class="text-gray-400">N/A</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-16">
                    <i class="fas fa-clipboard-list text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 text-lg font-semibold mb-2">No review assignments yet</p>
                    <p class="text-gray-400 text-sm">You'll see review requests here when editors assign them to you</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
