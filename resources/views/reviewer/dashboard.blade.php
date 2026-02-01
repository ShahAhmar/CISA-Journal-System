@extends('layouts.app')

@section('title', 'Reviewer Dashboard | CISA')

@section('content')
<div class="min-h-screen bg-slate-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Hero Header -->
        <div class="bg-cisa-base rounded-2xl shadow-xl p-8 mb-8 text-white relative overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
            </div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between">
                <div>
                     <div class="inline-flex items-center px-3 py-1 bg-white/10 backdrop-blur-sm rounded-full border border-white/20 mb-4">
                        <span class="w-2 h-2 bg-yellow-400 rounded-full mr-2 animate-pulse"></span>
                        <span class="text-white text-xs font-bold uppercase tracking-wider">Reviewer Portal</span>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-serif font-bold mb-2 flex items-center">
                        My Review Assignments
                    </h1>
                    <p class="text-blue-200 text-lg font-light">
                        Manage your double-blind peer review tasks appropriately.
                    </p>
                </div>
                <div class="hidden md:block">
                     <div class="w-24 h-24 bg-white/10 rounded-full flex items-center justify-center border-2 border-white/20">
                        <i class="fas fa-clipboard-check text-5xl text-cisa-accent"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4 mb-8">
            <!-- Pending -->
            <a href="{{ route('reviewer.dashboard', ['status' => 'pending']) }}"
               class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-lg hover:border-cisa-accent transition-all group {{ ($statusFilter ?? 'all') === 'pending' ? 'ring-2 ring-cisa-accent border-cisa-accent' : '' }}">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 bg-yellow-50 text-yellow-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-clock text-lg"></i>
                    </div>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-gray-100 text-gray-500 uppercase">New</span>
                </div>
                <p class="text-3xl font-serif font-bold text-cisa-base group-hover:text-cisa-accent transition-colors">{{ $stats['pending'] ?? 0 }}</p>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Pending</p>
            </a>
            
            <!-- In Progress -->
            <a href="{{ route('reviewer.dashboard', ['status' => 'in_progress']) }}"
               class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-lg hover:border-cisa-accent transition-all group {{ ($statusFilter ?? 'all') === 'in_progress' ? 'ring-2 ring-cisa-accent border-cisa-accent' : '' }}">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-spinner text-lg"></i>
                    </div>
                </div>
                <p class="text-3xl font-serif font-bold text-cisa-base group-hover:text-cisa-accent transition-colors">{{ $stats['in_progress'] ?? 0 }}</p>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Ongoing</p>
            </a>
            
            <!-- Completed -->
            <a href="{{ route('reviewer.dashboard', ['status' => 'completed']) }}"
               class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-lg hover:border-cisa-accent transition-all group {{ ($statusFilter ?? 'all') === 'completed' ? 'ring-2 ring-cisa-accent border-cisa-accent' : '' }}">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 bg-green-50 text-green-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-check-circle text-lg"></i>
                    </div>
                </div>
                <p class="text-3xl font-serif font-bold text-cisa-base group-hover:text-cisa-accent transition-colors">{{ $stats['completed'] ?? 0 }}</p>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Done</p>
            </a>
            
            <!-- Declined -->
            <a href="{{ route('reviewer.dashboard', ['status' => 'declined']) }}"
               class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-lg hover:border-cisa-accent transition-all group {{ ($statusFilter ?? 'all') === 'declined' ? 'ring-2 ring-cisa-accent border-cisa-accent' : '' }}">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 bg-red-50 text-red-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-times-circle text-lg"></i>
                    </div>
                </div>
                <p class="text-3xl font-serif font-bold text-cisa-base group-hover:text-cisa-accent transition-colors">{{ $stats['declined'] ?? 0 }}</p>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Declined</p>
            </a>
            
            <!-- Overdue -->
            <a href="{{ route('reviewer.dashboard', ['status' => 'overdue']) }}"
               class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-lg hover:border-cisa-accent transition-all group {{ ($statusFilter ?? 'all') === 'overdue' ? 'ring-2 ring-cisa-accent border-cisa-accent' : '' }}">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 bg-orange-50 text-orange-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-exclamation-triangle text-lg"></i>
                    </div>
                </div>
                <p class="text-3xl font-serif font-bold text-cisa-base group-hover:text-cisa-accent transition-colors">{{ $stats['overdue'] ?? 0 }}</p>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Overdue</p>
            </a>
            
            <!-- Total (All) -->
            <a href="{{ route('reviewer.dashboard', ['status' => 'all']) }}"
               class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-lg hover:border-cisa-accent transition-all group {{ ($statusFilter ?? 'all') === 'all' ? 'ring-2 ring-cisa-accent border-cisa-accent' : '' }}">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 bg-purple-50 text-purple-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-file-alt text-lg"></i>
                    </div>
                </div>
                <p class="text-3xl font-serif font-bold text-cisa-base group-hover:text-cisa-accent transition-colors">{{ $stats['total'] ?? 0 }}</p>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Total</p>
            </a>
        </div>

        <!-- Reviews Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-xl font-bold text-cisa-base font-serif flex items-center">
                    <span class="w-1 h-6 bg-cisa-accent mr-3 rounded-full"></span>
                    Assignments List
                </h2>
                @if(($statusFilter ?? 'all') !== 'all')
                <a href="{{ route('reviewer.dashboard', ['status' => 'all']) }}" class="text-xs font-bold text-gray-400 hover:text-cisa-base transition-colors">
                    <i class="fas fa-times mr-1"></i> CLEAR FILTER: {{ strtoupper(str_replace('_', ' ', $statusFilter)) }}
                </a>
                @endif
            </div>
            
            @if($reviews->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-bold">
                                <th class="px-6 py-4">Article Details</th>
                                <th class="px-6 py-4">Journal</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Timelines</th>
                                <th class="px-6 py-4 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($reviews as $review)
                                @php
                                    $submission = $review->submission;
                                    $journal = $submission ? $submission->journal : null;
                                    
                                    // Safely check if overdue
                                    $isOverdue = false;
                                    if ($review->due_date && in_array($review->status, ['pending', 'in_progress'])) {
                                        try {
                                            $dueDate = $review->due_date instanceof \Carbon\Carbon
                                                ? $review->due_date
                                                : \Carbon\Carbon::parse($review->due_date);
                                            $isOverdue = $dueDate->isPast();
                                        } catch (\Throwable $e) { $isOverdue = false; }
                                    }
                                @endphp
                                <tr class="hover:bg-slate-50/50 transition-colors {{ $isOverdue ? 'bg-red-50/30' : '' }}">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-800 text-sm mb-1 line-clamp-1" title="{{ $submission->title ?? 'N/A' }}">
                                            {{ Str::limit($submission->title ?? 'N/A', 60) }}
                                        </div>
                                        <div class="flex items-center text-xs text-gray-400 font-mono gap-2">
                                            <span>ID: #{{ $review->submission_id ?? ($submission->id ?? 'N/A') }}</span>
                                            @if($review->revision_round > 1)
                                                <span class="px-1.5 py-0.5 bg-orange-100 text-orange-700 rounded text-[10px] font-bold uppercase">
                                                    Round {{ $review->revision_round }}
                                                </span>
                                            @endif
                                            @if($review->previous_review_id)
                                                <span class="text-cisa-accent font-bold">Re-Review</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-600 font-medium">{{ Str::limit($journal->name ?? 'N/A', 25) }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-700',
                                                'in_progress' => 'bg-blue-100 text-blue-700',
                                                'completed' => 'bg-green-100 text-green-700',
                                                'declined' => 'bg-red-100 text-red-700',
                                            ];
                                            $statusColor = $statusColors[$review->status] ?? 'bg-gray-100 text-gray-600';
                                        @endphp
                                        <div class="flex flex-col items-start gap-1">
                                            <span class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider {{ $statusColor }}">
                                                {{ str_replace('_', ' ', $review->status) }}
                                            </span>
                                            @if($isOverdue)
                                                <span class="text-[10px] font-bold text-red-600 flex items-center">
                                                    <i class="fas fa-exclamation-circle mr-1"></i> Overdue
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-xs text-gray-500">
                                        <div class="flex flex-col gap-1">
                                            <div><span class="text-gray-400 w-12 inline-block">Assigned:</span> {{ $review->assigned_date ? \Carbon\Carbon::parse($review->assigned_date)->format('M d') : '-' }}</div>
                                            <div class="{{ $isOverdue ? 'text-red-600 font-bold' : '' }}"><span class="text-gray-400 w-12 inline-block">Due:</span> {{ $review->due_date ? \Carbon\Carbon::parse($review->due_date)->format('M d') : '-' }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        @if($review->status === 'pending')
                                            <a href="{{ route('reviewer.initial-review.show', $review) }}" 
                                               class="btn-cisa-primary py-1.5 px-3 text-xs inline-flex items-center">
                                                Respond <i class="fas fa-arrow-right ml-1"></i>
                                            </a>
                                        @elseif($review->status === 'in_progress')
                                            <a href="{{ route('reviewer.review.show', $review) }}" 
                                               class="btn-cisa-accent py-1.5 px-3 text-xs inline-flex items-center">
                                                Review <i class="fas fa-pen ml-1"></i>
                                            </a>
                                        @elseif($review->status === 'completed')
                                            <a href="{{ route('reviewer.review.show', $review) }}" 
                                               class="text-gray-400 hover:text-cisa-base font-bold text-xs inline-flex items-center transition-colors">
                                                View <i class="fas fa-eye ml-1"></i>
                                            </a>
                                        @else
                                            <span class="text-gray-300 text-xs">–</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-16 text-center">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                        <i class="fas fa-clipboard-check text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-500 mb-2">No assignments found</h3>
                    <p class="text-gray-400 text-sm">Review requests will appear here when assigned to you.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
