@extends('layouts.admin')

@section('title', 'Article Analytics - ' . $submission->title)
@section('page-title', 'Article Analytics')
@section('page-subtitle', $submission->title)

@section('content')
<div class="space-y-6">
    <!-- Article Info -->
    <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-xl font-bold text-[#0F1B4C]">{{ $submission->title }}</h3>
                <p class="text-gray-600 mt-1">{{ $submission->journal->name }}</p>
            </div>
            <a href="{{ route('journals.article', [$submission->journal, $submission->id]) }}" 
               target="_blank"
               class="px-4 py-2 bg-blue-100 text-blue-700 rounded-lg font-semibold hover:bg-blue-200 transition-colors">
                <i class="fas fa-external-link-alt mr-2"></i>View Article
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <p class="text-blue-100 text-sm font-semibold">Total Views</p>
            <p class="text-3xl font-bold mt-2">{{ number_format($stats['total_views']) }}</p>
        </div>
        
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <p class="text-green-100 text-sm font-semibold">Total Downloads</p>
            <p class="text-3xl font-bold mt-2">{{ number_format($stats['total_downloads']) }}</p>
        </div>
        
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <p class="text-purple-100 text-sm font-semibold">Unique Views</p>
            <p class="text-3xl font-bold mt-2">{{ number_format($stats['unique_views']) }}</p>
        </div>
        
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white">
            <p class="text-orange-100 text-sm font-semibold">Views (30 Days)</p>
            <p class="text-3xl font-bold mt-2">{{ number_format($stats['views_last_30_days']) }}</p>
        </div>
        
        <div class="bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl shadow-lg p-6 text-white">
            <p class="text-pink-100 text-sm font-semibold">Downloads (30 Days)</p>
            <p class="text-3xl font-bold mt-2">{{ number_format($stats['downloads_last_30_days']) }}</p>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Views Chart -->
        <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6">
            <h3 class="text-lg font-bold text-[#0F1B4C] mb-4">
                <i class="fas fa-chart-line mr-2 text-[#0056FF]"></i>Views Trend (Last 30 Days)
            </h3>
            <div class="h-64 flex items-end justify-between space-x-2">
                @foreach($dailyViews as $day)
                <div class="flex-1 flex flex-col items-center">
                    <div class="w-full bg-blue-500 rounded-t" style="height: {{ ($day->count / max($dailyViews->max('count') ?: 1, 1)) * 100 }}%"></div>
                    <span class="text-xs text-gray-500 mt-2">{{ \Carbon\Carbon::parse($day->date)->format('M d') }}</span>
                    <span class="text-xs font-semibold text-[#0056FF] mt-1">{{ $day->count }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Downloads Chart -->
        <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6">
            <h3 class="text-lg font-bold text-[#0F1B4C] mb-4">
                <i class="fas fa-download mr-2 text-[#0056FF]"></i>Downloads Trend (Last 30 Days)
            </h3>
            <div class="h-64 flex items-end justify-between space-x-2">
                @foreach($dailyDownloads as $day)
                <div class="flex-1 flex flex-col items-center">
                    <div class="w-full bg-green-500 rounded-t" style="height: {{ ($day->count / max($dailyDownloads->max('count') ?: 1, 1)) * 100 }}%"></div>
                    <span class="text-xs text-gray-500 mt-2">{{ \Carbon\Carbon::parse($day->date)->format('M d') }}</span>
                    <span class="text-xs font-semibold text-green-600 mt-1">{{ $day->count }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Referrers -->
    @if($referrers->count() > 0)
    <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6">
        <h3 class="text-lg font-bold text-[#0F1B4C] mb-4">
            <i class="fas fa-link mr-2 text-[#0056FF]"></i>Top Referrers
        </h3>
        <div class="space-y-3">
            @foreach($referrers as $referrer)
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-external-link-alt text-gray-400"></i>
                    <span class="text-sm text-gray-700 break-all">{{ $referrer->referrer }}</span>
                </div>
                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                    {{ $referrer->count }} views
                </span>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

