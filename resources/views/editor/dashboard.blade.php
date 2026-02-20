@extends('layouts.app')

@section('title', $journal->name . ' - Editor Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Hero Header -->
        <div class="bg-gradient-to-r from-[#0056FF] to-[#1D72B8] rounded-2xl shadow-2xl p-8 mb-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold mb-2 flex items-center">
                        <i class="fas fa-user-edit mr-3"></i>{{ $journal->name }}
                    </h1>
                    <p class="text-blue-100 text-lg">Editor Dashboard</p>
                    <p class="text-blue-200 text-sm mt-1">Manage submissions and oversee the editorial process</p>
                </div>
                <div class="hidden md:block">
                    <i class="fas fa-clipboard-list text-8xl opacity-20"></i>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-7 gap-4 mb-8">
            <a href="{{ route('editor.submissions.index', ['journal' => $journal, 'status' => 'submitted']) }}" class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6 hover:shadow-xl transition-shadow cursor-pointer">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-clock text-2xl text-yellow-600"></i>
                    </div>
                </div>
                <h3 class="text-gray-600 text-sm font-semibold mb-1">Pending</h3>
                <p class="text-4xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
                <p class="text-xs text-gray-500 mt-2">Awaiting review</p>
            </a>
            
            <a href="{{ route('editor.submissions.index', ['journal' => $journal, 'status' => 'under_review']) }}" class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6 hover:shadow-xl transition-shadow cursor-pointer">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-search text-2xl text-blue-600"></i>
                    </div>
                </div>
                <h3 class="text-gray-600 text-sm font-semibold mb-1">Under Review</h3>
                <p class="text-4xl font-bold text-blue-600">{{ $stats['under_review'] }}</p>
                <p class="text-xs text-gray-500 mt-2">In review process</p>
            </a>
            
            <a href="{{ route('editor.submissions.index', ['journal' => $journal, 'status' => 'revision_requested']) }}" class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6 hover:shadow-xl transition-shadow cursor-pointer">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-edit text-2xl text-orange-600"></i>
                    </div>
                </div>
                <h3 class="text-gray-600 text-sm font-semibold mb-1">Revision</h3>
                <p class="text-4xl font-bold text-orange-600">{{ $stats['revision_requested'] ?? 0 }}</p>
                <p class="text-xs text-gray-500 mt-2">Revision requested</p>
            </a>
            
            <a href="{{ route('editor.submissions.index', ['journal' => $journal, 'status' => 'accepted']) }}" class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6 hover:shadow-xl transition-shadow cursor-pointer">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-circle text-2xl text-green-600"></i>
                    </div>
                </div>
                <h3 class="text-gray-600 text-sm font-semibold mb-1">Accepted</h3>
                <p class="text-4xl font-bold text-green-600">{{ $stats['accepted'] }}</p>
                <p class="text-xs text-gray-500 mt-2">Approved submissions</p>
            </a>
            
            <a href="{{ route('editor.submissions.index', ['journal' => $journal, 'status' => 'rejected']) }}" class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6 hover:shadow-xl transition-shadow cursor-pointer">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-times-circle text-2xl text-red-600"></i>
                    </div>
                </div>
                <h3 class="text-gray-600 text-sm font-semibold mb-1">Rejected</h3>
                <p class="text-4xl font-bold text-red-600">{{ $stats['rejected'] ?? 0 }}</p>
                <p class="text-xs text-gray-500 mt-2">Rejected submissions</p>
            </a>
            
            <a href="{{ route('editor.submissions.index', ['journal' => $journal, 'status' => 'withdrawn']) }}" class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6 hover:shadow-xl transition-shadow cursor-pointer">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-undo text-2xl text-gray-600"></i>
                    </div>
                </div>
                <h3 class="text-gray-600 text-sm font-semibold mb-1">Withdrawn</h3>
                <p class="text-4xl font-bold text-gray-600">{{ $stats['withdrawn'] ?? 0 }}</p>
                <p class="text-xs text-gray-500 mt-2">Withdrawn submissions</p>
            </a>
            
            <a href="{{ route('editor.submissions.index', ['journal' => $journal, 'status' => 'published']) }}" class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6 hover:shadow-xl transition-shadow cursor-pointer">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-book text-2xl text-purple-600"></i>
                    </div>
                </div>
                <h3 class="text-gray-600 text-sm font-semibold mb-1">Published</h3>
                <p class="text-4xl font-bold text-purple-600">{{ $stats['published'] }}</p>
                <p class="text-xs text-gray-500 mt-2">Published articles</p>
            </a>
        </div>

        <!-- Recent Submissions Section -->
        <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-[#0056FF] to-[#1D72B8] p-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <i class="fas fa-list mr-3"></i>Recent Submissions
                    </h2>
                    <a href="{{ route('editor.submissions.index', $journal) }}" class="text-white hover:text-blue-100 font-semibold text-sm">
                        View All <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            
            @if($recentSubmissions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Author</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Submitted</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($recentSubmissions as $submission)
                                <tr class="hover:bg-blue-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-semibold text-gray-900">{{ Str::limit($submission->title, 50) }}</div>
                                        <div class="text-xs text-gray-500 mt-1">ID: #{{ $submission->id }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-700 font-medium">{{ $submission->author->full_name }}</div>
                                        <div class="text-xs text-gray-500">{{ $submission->author->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'submitted' => 'bg-yellow-100 text-yellow-800',
                                                'under_review' => 'bg-blue-100 text-blue-800',
                                                'accepted' => 'bg-green-100 text-green-800',
                                                'rejected' => 'bg-red-100 text-red-800',
                                                'published' => 'bg-purple-100 text-purple-800',
                                                'revision' => 'bg-orange-100 text-orange-800',
                                            ];
                                            $statusColor = $statusColors[$submission->status] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                                            {{ ucfirst(str_replace('_', ' ', $submission->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ \Carbon\Carbon::parse($submission->submitted_at ?? $submission->created_at)->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('editor.submissions.show', [$journal, $submission]) }}" 
                                               class="text-[#0056FF] hover:text-[#0044CC] font-semibold inline-flex items-center">
                                                <i class="fas fa-eye mr-1"></i>View
                                            </a>
                                            @if(in_array($submission->status, ['submitted', 'under_review']))
                                                <a href="{{ route('editor.submissions.show', [$journal, $submission]) }}#actions" 
                                                   class="text-green-600 hover:text-green-700 font-semibold inline-flex items-center">
                                                    <i class="fas fa-check mr-1"></i>Review
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-16">
                    <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 text-lg font-semibold mb-2">No submissions yet</p>
                    <p class="text-gray-400 text-sm">Submissions will appear here when authors submit articles</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
