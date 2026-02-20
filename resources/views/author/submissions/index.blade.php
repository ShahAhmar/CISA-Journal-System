@extends('layouts.app')

@section('title', 'My Submissions | EMANP')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-br from-[#0F1B4C] to-[#1a2d6b] text-white py-12 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 20px 20px;"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl md:text-5xl font-bold mb-3" style="font-family: 'Playfair Display', serif;">My Submissions</h1>
                <p class="text-lg text-blue-200">Track and manage your article submissions</p>
            </div>
            <div>
                <a href="{{ route('journals.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-white bg-opacity-20 hover:bg-opacity-30 text-white rounded-lg font-semibold transition-all backdrop-blur-sm border-2 border-white border-opacity-30">
                    <i class="fas fa-plus mr-2"></i>New Submission
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Stats Cards -->
@if($submissions->count() > 0)
<section class="bg-white border-b border-gray-200 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-blue-50 rounded-xl p-4 border-2 border-blue-100">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-file-alt text-white"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-[#0F1B4C]">{{ $submissions->total() }}</p>
                        <p class="text-xs text-gray-600">Total Submissions</p>
                    </div>
                </div>
            </div>
            
            @php
                $underReview = $submissions->where('status', 'under_review')->count();
                $accepted = $submissions->where('status', 'accepted')->count();
                $published = $submissions->where('status', 'published')->count();
            @endphp
            
            <div class="bg-yellow-50 rounded-xl p-4 border-2 border-yellow-100">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-search text-white"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-[#0F1B4C]">{{ $underReview }}</p>
                        <p class="text-xs text-gray-600">Under Review</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-green-50 rounded-xl p-4 border-2 border-green-100">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-check-circle text-white"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-[#0F1B4C]">{{ $accepted }}</p>
                        <p class="text-xs text-gray-600">Accepted</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-purple-50 rounded-xl p-4 border-2 border-purple-100">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-book text-white"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-[#0F1B4C]">{{ $published }}</p>
                        <p class="text-xs text-gray-600">Published</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Submissions List -->
<section class="bg-[#F7F9FC] py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($submissions->count() > 0)
            <div class="bg-white rounded-2xl shadow-xl border-2 border-gray-100 overflow-hidden">
                <!-- Table Header -->
                <div class="bg-gradient-to-r from-[#0F1B4C] to-[#1a2d6b] px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-list mr-3"></i>Your Submissions
                    </h2>
                </div>
                
                <!-- Desktop Table -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-[#0F1B4C] uppercase tracking-wider">Title</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-[#0F1B4C] uppercase tracking-wider">Journal</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-[#0F1B4C] uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-[#0F1B4C] uppercase tracking-wider">Stage</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-[#0F1B4C] uppercase tracking-wider">Submitted</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-[#0F1B4C] uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($submissions as $submission)
                                <tr class="hover:bg-[#F7F9FC] transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                                <i class="fas fa-file-alt text-blue-600"></i>
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-[#0F1B4C]">{{ Str::limit($submission->title, 60) }}</div>
                                                @if($submission->journalSection)
                                                    <div class="text-xs text-gray-500 mt-1">
                                                        <i class="fas fa-tag mr-1"></i>{{ $submission->journalSection->title }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-700">{{ Str::limit($submission->journal->name, 40) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusConfig = [
                                                'submitted' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'border' => 'border-blue-200', 'icon' => 'fa-paper-plane'],
                                                'under_review' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'border' => 'border-yellow-200', 'icon' => 'fa-search'],
                                                'revision_requested' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-800', 'border' => 'border-orange-200', 'icon' => 'fa-edit'],
                                                'accepted' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'border' => 'border-green-200', 'icon' => 'fa-check-circle'],
                                                'rejected' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'border' => 'border-red-200', 'icon' => 'fa-times-circle'],
                                                'published' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-800', 'border' => 'border-purple-200', 'icon' => 'fa-book'],
                                            ];
                                            $status = $statusConfig[$submission->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'border' => 'border-gray-200', 'icon' => 'fa-circle'];
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold {{ $status['bg'] }} {{ $status['text'] }} border-2 {{ $status['border'] }}">
                                            <i class="fas {{ $status['icon'] }} mr-1"></i>
                                            {{ ucfirst(str_replace('_', ' ', $submission->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $stageConfig = [
                                                'submission' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-200'],
                                                'review' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-700', 'border' => 'border-yellow-200'],
                                                'revision' => ['bg' => 'bg-orange-50', 'text' => 'text-orange-700', 'border' => 'border-orange-200'],
                                                'copyediting' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-700', 'border' => 'border-purple-200'],
                                                'proofreading' => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-700', 'border' => 'border-indigo-200'],
                                                'published' => ['bg' => 'bg-green-50', 'text' => 'text-green-700', 'border' => 'border-green-200'],
                                            ];
                                            $stage = $stageConfig[$submission->current_stage] ?? ['bg' => 'bg-gray-50', 'text' => 'text-gray-700', 'border' => 'border-gray-200'];
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold {{ $stage['bg'] }} {{ $stage['text'] }} border {{ $stage['border'] }}">
                                            {{ ucfirst(str_replace('_', ' ', $submission->current_stage)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-600">
                                            <i class="fas fa-calendar-alt mr-1 text-gray-400"></i>
                                            @if($submission->submitted_at)
                                                {{ \Carbon\Carbon::parse($submission->submitted_at)->format('M d, Y') }}
                                            @else
                                                {{ \Carbon\Carbon::parse($submission->created_at)->format('M d, Y') }}
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('author.submissions.show', $submission) }}" 
                                           class="inline-flex items-center px-4 py-2 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors shadow-md hover:shadow-lg">
                                            <i class="fas fa-eye mr-2"></i>View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Mobile Cards -->
                <div class="md:hidden divide-y divide-gray-200">
                    @foreach($submissions as $submission)
                        <div class="p-6 hover:bg-[#F7F9FC] transition-colors">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <div class="flex items-center mb-2">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-file-alt text-blue-600"></i>
                                        </div>
                                        <h3 class="font-bold text-[#0F1B4C]">{{ Str::limit($submission->title, 50) }}</h3>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-3">
                                        <i class="fas fa-book mr-1"></i>{{ Str::limit($submission->journal->name, 40) }}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-3 mb-4">
                                @php
                                    $statusConfig = [
                                        'submitted' => ['color' => 'blue', 'icon' => 'fa-paper-plane'],
                                        'under_review' => ['color' => 'yellow', 'icon' => 'fa-search'],
                                        'revision_requested' => ['color' => 'orange', 'icon' => 'fa-edit'],
                                        'accepted' => ['color' => 'green', 'icon' => 'fa-check-circle'],
                                        'rejected' => ['color' => 'red', 'icon' => 'fa-times-circle'],
                                        'published' => ['color' => 'purple', 'icon' => 'fa-book'],
                                    ];
                                    $status = $statusConfig[$submission->status] ?? ['color' => 'gray', 'icon' => 'fa-circle'];
                                @endphp
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Status</p>
                                    @php
                                        $statusConfig = [
                                            'submitted' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'icon' => 'fa-paper-plane'],
                                            'under_review' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'icon' => 'fa-search'],
                                            'revision_requested' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-800', 'icon' => 'fa-edit'],
                                            'accepted' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'icon' => 'fa-check-circle'],
                                            'rejected' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'icon' => 'fa-times-circle'],
                                            'published' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-800', 'icon' => 'fa-book'],
                                        ];
                                        $status = $statusConfig[$submission->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'icon' => 'fa-circle'];
                                    @endphp
                                    <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-semibold {{ $status['bg'] }} {{ $status['text'] }}">
                                        <i class="fas {{ $status['icon'] }} mr-1"></i>
                                        {{ ucfirst(str_replace('_', ' ', $submission->status)) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Submitted</p>
                                    <p class="text-sm text-gray-700">
                                        <i class="fas fa-calendar-alt mr-1 text-gray-400"></i>
                                        @if($submission->submitted_at)
                                            {{ \Carbon\Carbon::parse($submission->submitted_at)->format('M d, Y') }}
                                        @else
                                            {{ \Carbon\Carbon::parse($submission->created_at)->format('M d, Y') }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                            <a href="{{ route('author.submissions.show', $submission) }}" 
                               class="block w-full text-center px-4 py-2 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors">
                                <i class="fas fa-eye mr-2"></i>View Details
                            </a>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                @if($submissions->hasPages())
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    {{ $submissions->links() }}
                </div>
                @endif
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-2xl shadow-xl border-2 border-gray-100 p-12 text-center">
                <div class="max-w-md mx-auto">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-file-alt text-4xl text-gray-400"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-[#0F1B4C] mb-3">No Submissions Yet</h2>
                    <p class="text-gray-600 mb-6">Start your publishing journey by submitting your first article to a journal.</p>
                    <a href="{{ route('journals.index') }}" 
                       class="inline-flex items-center px-8 py-3 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors shadow-lg hover:shadow-xl">
                        <i class="fas fa-plus mr-2"></i>Browse Journals & Submit
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
