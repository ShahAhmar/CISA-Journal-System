@extends('layouts.admin')

@section('title', 'Advanced Statistics' . ($journal ? ' - ' . $journal->name : ''))
@section('page-title', 'Advanced Statistics')
@section('page-subtitle', $journal ? $journal->name : 'All Journals')

@section('content')
<div class="space-y-6">
    <!-- Review Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-semibold">Average Review Time</p>
                    <p class="text-3xl font-bold mt-2">
                        {{ $reviewStats['average_review_time'] ? round($reviewStats['average_review_time']) : 0 }} days
                    </p>
                </div>
                <i class="fas fa-clock text-4xl opacity-50"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-semibold">Total Reviews</p>
                    <p class="text-3xl font-bold mt-2">{{ number_format($reviewStats['total_reviews']) }}</p>
                </div>
                <i class="fas fa-clipboard-check text-4xl opacity-50"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-semibold">Completed Reviews</p>
                    <p class="text-3xl font-bold mt-2">{{ number_format($reviewStats['completed_reviews']) }}</p>
                </div>
                <i class="fas fa-check-circle text-4xl opacity-50"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-semibold">Pending Reviews</p>
                    <p class="text-3xl font-bold mt-2">{{ number_format($reviewStats['pending_reviews']) }}</p>
                </div>
                <i class="fas fa-hourglass-half text-4xl opacity-50"></i>
            </div>
        </div>
    </div>

    <!-- Acceptance Rate -->
    <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6">
        <h3 class="text-xl font-bold text-[#0F1B4C] mb-4">Acceptance Rate</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center">
                <p class="text-4xl font-bold text-[#0056FF]">{{ $acceptanceRate }}%</p>
                <p class="text-gray-600 mt-2">Acceptance Rate</p>
            </div>
            <div class="text-center">
                <p class="text-4xl font-bold text-green-600">{{ number_format($publishedSubmissions) }}</p>
                <p class="text-gray-600 mt-2">Published</p>
            </div>
            <div class="text-center">
                <p class="text-4xl font-bold text-red-600">{{ number_format($rejectedSubmissions) }}</p>
                <p class="text-gray-600 mt-2">Rejected</p>
            </div>
        </div>
        <div class="mt-4">
            <p class="text-sm text-gray-600">Total Submissions: <strong>{{ number_format($totalSubmissions) }}</strong></p>
        </div>
    </div>

    <!-- Reviewer Performance -->
    <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6">
        <h3 class="text-xl font-bold text-[#0F1B4C] mb-4">Top Reviewers</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-[#0056FF] to-[#1D72B8]">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Reviewer</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Total Reviews</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Avg Rating</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Avg Time (Days)</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($reviewerPerformance as $perf)
                    <tr class="hover:bg-blue-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="text-sm font-semibold text-gray-900">{{ $perf->reviewer->full_name }}</div>
                            <div class="text-xs text-gray-500">{{ $perf->reviewer->email }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                                {{ $perf->total_reviews }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($perf->avg_rating)
                            <div class="flex items-center">
                                <span class="text-sm font-semibold text-gray-900">{{ number_format($perf->avg_rating, 1) }}</span>
                                <div class="ml-2 flex">
                                    @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $perf->avg_rating ? 'text-yellow-400' : 'text-gray-300' }} text-xs"></i>
                                    @endfor
                                </div>
                            </div>
                            @else
                            <span class="text-gray-400">N/A</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-700">
                                {{ $perf->avg_time ? round($perf->avg_time) : 'N/A' }} days
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                            No reviewer data available
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Status Breakdown -->
    <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6">
        <h3 class="text-xl font-bold text-[#0F1B4C] mb-4">Submission Status Breakdown</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($statusBreakdown as $status => $count)
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <p class="text-2xl font-bold text-[#0056FF]">{{ number_format($count) }}</p>
                <p class="text-sm text-gray-600 mt-1 capitalize">{{ str_replace('_', ' ', $status) }}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

