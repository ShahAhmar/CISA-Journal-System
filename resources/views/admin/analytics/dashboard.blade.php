@extends('layouts.admin')

@section('title', 'Analytics Dashboard - EMANP')
@section('page-title', 'Analytics Dashboard')
@section('page-subtitle', 'Track views, downloads, and engagement metrics')

@section('content')
<div class="space-y-6">
    <!-- Global Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-semibold">Total Views</p>
                    <p class="text-3xl font-bold mt-2">{{ number_format($globalStats['total_views']) }}</p>
                </div>
                <i class="fas fa-eye text-4xl opacity-50"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-semibold">Total Downloads</p>
                    <p class="text-3xl font-bold mt-2">{{ number_format($globalStats['total_downloads']) }}</p>
                </div>
                <i class="fas fa-download text-4xl opacity-50"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-semibold">Views Today</p>
                    <p class="text-3xl font-bold mt-2">{{ number_format($globalStats['views_today']) }}</p>
                </div>
                <i class="fas fa-chart-line text-4xl opacity-50"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-semibold">Downloads Today</p>
                    <p class="text-3xl font-bold mt-2">{{ number_format($globalStats['downloads_today']) }}</p>
                </div>
                <i class="fas fa-file-download text-4xl opacity-50"></i>
            </div>
        </div>
    </div>

    <!-- Top Articles -->
    <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6">
        <h3 class="text-xl font-bold text-[#0F1B4C] mb-6">
            <i class="fas fa-trophy mr-2 text-[#0056FF]"></i>Top Articles (Last 30 Days)
        </h3>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-[#0056FF] to-[#1D72B8]">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Rank</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Article</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Journal</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Views</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-white uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($topArticles as $index => $item)
                    <tr class="hover:bg-blue-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($index < 3)
                                <span class="w-8 h-8 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-full flex items-center justify-center text-white font-bold">
                                    {{ $index + 1 }}
                                </span>
                                @else
                                <span class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-gray-700 font-bold">
                                    {{ $index + 1 }}
                                </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-semibold text-gray-900">{{ $item->submission->title ?? 'N/A' }}</div>
                            <div class="text-xs text-gray-500">ID: {{ $item->submission_id }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $item->submission->journal->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                                {{ number_format($item->views) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.analytics.article', $item->submission) }}" 
                               class="text-[#0056FF] hover:text-[#0044CC] font-semibold">
                                <i class="fas fa-chart-bar mr-1"></i>View Details
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            No analytics data available yet
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Top Journals -->
    <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6">
        <h3 class="text-xl font-bold text-[#0F1B4C] mb-6">
            <i class="fas fa-book mr-2 text-[#0056FF]"></i>Top Journals (Last 30 Days)
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($topJournals as $item)
            <div class="bg-gradient-to-br from-white to-gray-50 rounded-xl border-2 border-gray-200 p-6 hover:border-[#0056FF] transition-all">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center text-white">
                        <i class="fas fa-book text-xl"></i>
                    </div>
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                        {{ number_format($item->views) }} views
                    </span>
                </div>
                <h4 class="font-bold text-[#0F1B4C] mb-2">{{ $item->journal->name ?? 'N/A' }}</h4>
                <a href="{{ route('admin.analytics.journal', $item->journal) }}" 
                   class="text-[#0056FF] hover:text-[#0044CC] font-semibold text-sm">
                    View Analytics <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            @empty
            <div class="col-span-3 text-center py-8 text-gray-500">
                No analytics data available yet
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

