@extends('layouts.admin')

@section('title', 'Journal Analytics - ' . $journal->name)
@section('page-title', 'Journal Analytics')
@section('page-subtitle', $journal->name)

@section('content')
<div class="space-y-6">
    <!-- Journal Info -->
    <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-xl font-bold text-[#0F1B4C]">{{ $journal->name }}</h3>
                <p class="text-gray-600 mt-1">{{ $overallStats['total_articles'] }} published articles</p>
            </div>
            <a href="{{ route('journals.show', $journal) }}" 
               target="_blank"
               class="px-4 py-2 bg-blue-100 text-blue-700 rounded-lg font-semibold hover:bg-blue-200 transition-colors">
                <i class="fas fa-external-link-alt mr-2"></i>View Journal
            </a>
        </div>
    </div>

    <!-- Overall Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <p class="text-blue-100 text-sm font-semibold">Total Views (All Time)</p>
            <p class="text-3xl font-bold mt-2">{{ number_format($overallStats['total_views_all_time']) }}</p>
        </div>
        
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <p class="text-green-100 text-sm font-semibold">Total Downloads (All Time)</p>
            <p class="text-3xl font-bold mt-2">{{ number_format($overallStats['total_downloads_all_time']) }}</p>
        </div>
        
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <p class="text-purple-100 text-sm font-semibold">Published Articles</p>
            <p class="text-3xl font-bold mt-2">{{ number_format($overallStats['total_articles']) }}</p>
        </div>
    </div>

    <!-- Last 30 Days Stats -->
    <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6">
        <h3 class="text-lg font-bold text-[#0F1B4C] mb-6">Last 30 Days Performance</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-blue-50 rounded-lg p-6">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-blue-700 font-semibold">Views</span>
                    <i class="fas fa-eye text-blue-600 text-2xl"></i>
                </div>
                <p class="text-3xl font-bold text-blue-900">{{ number_format($stats['total_views']) }}</p>
            </div>
            <div class="bg-green-50 rounded-lg p-6">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-green-700 font-semibold">Downloads</span>
                    <i class="fas fa-download text-green-600 text-2xl"></i>
                </div>
                <p class="text-3xl font-bold text-green-900">{{ number_format($stats['total_downloads']) }}</p>
            </div>
        </div>
    </div>

    <!-- Top Articles -->
    @if($stats['top_articles']->count() > 0)
    <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6">
        <h3 class="text-lg font-bold text-[#0F1B4C] mb-6">
            <i class="fas fa-trophy mr-2 text-[#0056FF]"></i>Top Articles (Last 30 Days)
        </h3>
        <div class="space-y-3">
            @foreach($stats['top_articles'] as $index => $item)
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-blue-50 transition-colors">
                <div class="flex items-center space-x-4 flex-1">
                    <div class="w-10 h-10 bg-[#0056FF] rounded-lg flex items-center justify-center text-white font-bold">
                        {{ $index + 1 }}
                    </div>
                    <div class="flex-1">
                        <h4 class="font-semibold text-[#0F1B4C]">{{ $item->submission->title ?? 'N/A' }}</h4>
                        <p class="text-sm text-gray-600">
                            @if($item->submission && $item->submission->authors->count() > 0)
                                {{ $item->submission->authors->first()->first_name }} {{ $item->submission->authors->first()->last_name }}
                            @endif
                        </p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="px-4 py-2 bg-blue-100 text-blue-800 rounded-full font-semibold">
                        {{ number_format($item->views) }} views
                    </span>
                    <a href="{{ route('admin.analytics.article', $item->submission) }}" 
                       class="text-[#0056FF] hover:text-[#0044CC]">
                        <i class="fas fa-chart-bar"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

