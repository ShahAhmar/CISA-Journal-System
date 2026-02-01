@extends('layouts.admin')

@section('title', 'Enhanced Statistics - EMANP')
@section('page-title', 'Enhanced Statistics')
@section('page-subtitle', 'Detailed analytics and reporting')

@section('content')
<div class="space-y-6">
    <!-- Filters -->
    <div class="bg-white rounded-xl border-2 border-gray-200 p-6">
        <form method="GET" action="{{ route('admin.statistics.enhanced') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Journal</label>
                <select name="journal_id" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                    <option value="">All Journals</option>
                    @foreach($journals as $journal)
                        <option value="{{ $journal->id }}" {{ $selectedJournal == $journal->id ? 'selected' : '' }}>
                            {{ $journal->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Date From</label>
                <input type="date" name="date_from" value="{{ $dateFrom }}" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Date To</label>
                <input type="date" name="date_to" value="{{ $dateTo }}" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full px-6 py-2 bg-[#0056FF] text-white rounded-lg hover:bg-[#0044CC] transition-colors font-semibold">
                    <i class="fas fa-filter mr-2"></i>Apply Filters
                </button>
            </div>
        </form>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-semibold">Total Articles</p>
                    <p class="text-3xl font-bold mt-2">{{ number_format($stats['total_articles']) }}</p>
                </div>
                <i class="fas fa-file-alt text-4xl opacity-50"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-semibold">Total Views</p>
                    <p class="text-3xl font-bold mt-2">{{ number_format($stats['total_views']) }}</p>
                </div>
                <i class="fas fa-eye text-4xl opacity-50"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-semibold">Total Downloads</p>
                    <p class="text-3xl font-bold mt-2">{{ number_format($stats['total_downloads']) }}</p>
                </div>
                <i class="fas fa-download text-4xl opacity-50"></i>
            </div>
        </div>
    </div>

    <!-- Export Options -->
    <div class="bg-white rounded-xl border-2 border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <h3 class="text-xl font-bold text-[#0F1B4C]">
                <i class="fas fa-download mr-2 text-[#0056FF]"></i>Export Reports
            </h3>
            <div class="flex space-x-3">
                <a href="{{ route('admin.statistics.export.pdf', request()->all()) }}" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors font-semibold">
                    <i class="fas fa-file-pdf mr-2"></i>Export PDF
                </a>
                <a href="{{ route('admin.statistics.export.excel', request()->all()) }}" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors font-semibold">
                    <i class="fas fa-file-excel mr-2"></i>Export Excel
                </a>
            </div>
        </div>
    </div>

    <!-- Articles by Month -->
    <div class="bg-white rounded-xl border-2 border-gray-200 p-6">
        <h3 class="text-xl font-bold text-[#0F1B4C] mb-6">
            <i class="fas fa-chart-line mr-2 text-[#0056FF]"></i>Articles Published by Month
        </h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-[#0056FF] to-[#1D72B8]">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Month</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Articles Count</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($stats['articles_by_month'] as $item)
                    <tr class="hover:bg-blue-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                            {{ \Carbon\Carbon::createFromFormat('Y-m', $item->month)->format('F Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                                {{ $item->count }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="px-6 py-12 text-center text-gray-500">
                            No data available for selected period
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Top Articles -->
    <div class="bg-white rounded-xl border-2 border-gray-200 p-6">
        <h3 class="text-xl font-bold text-[#0F1B4C] mb-6">
            <i class="fas fa-trophy mr-2 text-[#0056FF]"></i>Top Articles
        </h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-[#0056FF] to-[#1D72B8]">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Rank</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Article Title</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Views</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($stats['top_articles'] as $index => $item)
                    <tr class="hover:bg-blue-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="w-8 h-8 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-full flex items-center justify-center text-white font-bold inline-flex">
                                {{ $index + 1 }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-semibold text-gray-900">
                                {{ $item->submission->title ?? 'N/A' }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                                {{ number_format($item->view_count ?? 0) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center text-gray-500">
                            No articles found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Articles by Journal -->
    <div class="bg-white rounded-xl border-2 border-gray-200 p-6">
        <h3 class="text-xl font-bold text-[#0F1B4C] mb-6">
            <i class="fas fa-book mr-2 text-[#0056FF]"></i>Articles by Journal
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($stats['articles_by_journal'] as $item)
            <div class="bg-gradient-to-br from-white to-gray-50 rounded-xl border-2 border-gray-200 p-6 hover:border-[#0056FF] transition-all">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center text-white">
                        <i class="fas fa-book text-xl"></i>
                    </div>
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                        {{ $item->count }} articles
                    </span>
                </div>
                <h4 class="font-bold text-[#0F1B4C]">{{ $item->journal->name ?? 'N/A' }}</h4>
            </div>
            @empty
            <div class="col-span-3 text-center py-8 text-gray-500">
                No data available
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

