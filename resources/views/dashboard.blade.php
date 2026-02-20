@extends('layouts.app')

@section('title', 'Dashboard - CISA Interdisciplinary Journal')

@section('content')
<div class="min-h-screen bg-white py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Ultra Professional Hero Header -->
        <div class="bg-gradient-to-br from-purple-600 via-purple-700 to-purple-800 rounded-3xl shadow-2xl p-8 md:p-10 mb-10 text-white relative overflow-hidden">
            <!-- Decorative Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
            </div>
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between relative z-10">
                <div class="flex-1">
                    <div class="inline-flex items-center px-3 py-1.5 bg-white/20 backdrop-blur-sm rounded-full mb-4 border border-white/30">
                        <i class="fas fa-tachometer-alt mr-2 text-sm"></i>
                        <span class="text-xs font-semibold uppercase tracking-wider">Dashboard</span>
                    </div>
                    <h1 class="text-4xl md:text-5xl font-bold mb-3 flex items-center" style="font-family: 'Playfair Display', serif; letter-spacing: -0.02em;">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4 backdrop-blur-sm">
                            <i class="fas fa-user-circle text-2xl"></i>
                        </div>
                        Research Dashboard
                    </h1>
                    <p class="text-purple-100 text-lg md:text-xl font-medium mb-1">Welcome back, {{ auth()->user()->full_name }}</p>
                    <p class="text-purple-200 text-sm md:text-base">Manage your interdisciplinary research submissions and publications</p>
                </div>
                <div class="hidden lg:block mt-6 md:mt-0">
                    <div class="w-32 h-32 bg-white/10 rounded-3xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-book-open text-5xl opacity-30"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ultra Professional Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:border-purple-200 transition-all duration-200 group">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 mb-2">
                            <i class="fas fa-book text-purple-600"></i>
                            <p class="text-gray-600 text-sm font-semibold uppercase tracking-wider">My Journals</p>
                        </div>
                        <p class="text-5xl font-bold bg-gradient-to-r from-purple-600 to-purple-800 bg-clip-text text-transparent mb-1">{{ $userJournals->count() }}</p>
                        <p class="text-xs text-gray-500 font-medium">Journals you're part of</p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-100 to-purple-200 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200 shadow-md">
                        <i class="fas fa-book text-2xl text-purple-700"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:border-green-200 transition-all duration-200 group">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 mb-2">
                            <i class="fas fa-file-alt text-green-600"></i>
                            <p class="text-gray-600 text-sm font-semibold uppercase tracking-wider">My Submissions</p>
                        </div>
                        <p class="text-5xl font-bold bg-gradient-to-r from-green-600 to-green-700 bg-clip-text text-transparent mb-1">{{ $submissions->count() }}</p>
                        <p class="text-xs text-gray-500 font-medium">Total submissions</p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-green-100 to-green-200 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200 shadow-md">
                        <i class="fas fa-file-alt text-2xl text-green-700"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:border-purple-200 transition-all duration-200 group">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 mb-2">
                            <i class="fas fa-check-circle text-purple-600"></i>
                            <p class="text-gray-600 text-sm font-semibold uppercase tracking-wider">Published</p>
                        </div>
                        <p class="text-5xl font-bold bg-gradient-to-r from-purple-600 to-purple-800 bg-clip-text text-transparent mb-1">{{ $submissions->where('status', 'published')->count() }}</p>
                        <p class="text-xs text-gray-500 font-medium">Successfully published</p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-100 to-purple-200 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200 shadow-md">
                        <i class="fas fa-check-circle text-2xl text-purple-700"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- My Journals Section -->
        @if($userJournals->count() > 0)
        <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-purple-900 flex items-center">
                    <i class="fas fa-book mr-3 text-purple-600"></i>My Journals
                </h2>
                <a href="{{ route('journals.index') }}" class="text-purple-600 hover:text-purple-700 font-semibold text-sm">
                    View All <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($userJournals as $journal)
                    <div class="border-2 border-gray-200 rounded-lg p-5 hover:border-[#0056FF] hover:shadow-lg transition-all cursor-pointer group">
                        <div class="flex items-start justify-between mb-3">
                            <h3 class="font-bold text-purple-900 text-lg group-hover:text-purple-600 transition-colors">{{ $journal->name }}</h3>
                            <i class="fas fa-arrow-right text-gray-400 group-hover:text-purple-600 transition-colors"></i>
                        </div>
                        <p class="text-sm text-gray-600 mb-3">{{ Str::limit($journal->description ?? 'No description available', 80) }}</p>
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                                {{ ucfirst(str_replace('_', ' ', $journal->pivot->role)) }}
                            </span>
                            <a href="{{ route('journals.show', $journal) }}" class="text-purple-600 hover:text-purple-700 font-semibold text-sm">
                                View Journal <i class="fas fa-external-link-alt ml-1"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Ultra Professional Recent Submissions Section -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 via-purple-700 to-purple-800 p-6 md:p-8">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between">
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold text-white flex items-center mb-2" style="font-family: 'Playfair Display', serif;">
                            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mr-3 backdrop-blur-sm">
                                <i class="fas fa-list text-white"></i>
                            </div>
                            Recent Submissions
                        </h2>
                        <p class="text-purple-100 text-sm ml-13">Your latest research submissions</p>
                    </div>
                    <a href="{{ route('author.submissions.index') }}" class="mt-4 md:mt-0 flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm text-white rounded-xl font-semibold text-sm hover:bg-white/30 transition-all duration-200 border border-white/30">
                        View All <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
            
            @if($submissions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Journal</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($submissions as $submission)
                                <tr class="hover:bg-purple-50/50 transition-colors duration-150">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-semibold text-gray-900">{{ Str::limit($submission->title, 50) }}</div>
                                        <div class="text-xs text-gray-500 mt-1 font-mono">ID: #{{ $submission->id }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-2">
                                                <i class="fas fa-book text-purple-600 text-xs"></i>
                                            </div>
                                            <div class="text-sm text-gray-700 font-medium">{{ $submission->journal->name }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'submitted' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                'under_review' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                'accepted' => 'bg-green-100 text-green-800 border-green-200',
                                                'rejected' => 'bg-red-100 text-red-800 border-red-200',
                                                'published' => 'bg-purple-100 text-purple-800 border-purple-200',
                                                'revision' => 'bg-orange-100 text-orange-800 border-orange-200',
                                            ];
                                            $statusColor = $statusColors[$submission->status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                                        @endphp
                                        <span class="px-3 py-1.5 rounded-lg text-xs font-semibold border {{ $statusColor }}">
                                            {{ ucfirst(str_replace('_', ' ', $submission->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center text-sm text-gray-600">
                                            <i class="fas fa-calendar text-purple-600 mr-2 text-xs"></i>
                                            {{ \Carbon\Carbon::parse($submission->submitted_at ?? $submission->created_at)->format('M d, Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('author.submissions.show', $submission) }}" 
                                           class="inline-flex items-center px-3 py-1.5 bg-purple-50 text-purple-700 rounded-lg font-semibold hover:bg-purple-100 transition-all duration-200">
                                            <i class="fas fa-eye mr-1.5 text-xs"></i>View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-20">
                    <div class="w-24 h-24 bg-gradient-to-br from-purple-100 to-purple-200 rounded-3xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-file-alt text-purple-600 text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">No submissions yet</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">Start your research journey by submitting your first interdisciplinary article</p>
                    <a href="{{ route('journals.index') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white rounded-xl font-bold shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                        <i class="fas fa-plus mr-2"></i>Submit Research
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
