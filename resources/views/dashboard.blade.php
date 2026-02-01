@extends('layouts.app')

@section('title', 'Dashboard | CISA')

@section('content')
    <div class="min-h-screen bg-slate-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Hero Header -->
            <div class="bg-cisa-base rounded-2xl shadow-xl p-8 mb-8 text-white relative overflow-hidden">
                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
                </div>

                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between">
                    <div class="mb-6 md:mb-0 md:mr-6">
                        <div
                            class="inline-flex items-center px-3 py-1 bg-white/10 backdrop-blur-sm rounded-full border border-white/20 mb-4">
                            <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                            <span class="text-white text-xs font-bold uppercase tracking-wider">Active Session</span>
                        </div>

                        <h1 class="text-3xl md:text-4xl font-serif font-bold mb-2 flex items-center">
                            Welcome, {{ auth()->user()->full_name }}
                        </h1>
                        <p class="text-blue-200 text-lg font-light">
                            Manage your research, track submissions, and collaborate.
                        </p>
                    </div>
                    <div class="hidden md:block">
                        <div
                            class="w-20 h-20 bg-cisa-accent/20 rounded-full flex items-center justify-center border-2 border-white/10">
                            <i class="fas fa-user-graduate text-4xl text-cisa-accent"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Active Journals -->
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all group border-l-4 border-l-cisa-base">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">My Journals</p>
                            <p class="text-3xl font-bold text-cisa-base mt-1">{{ $userJournals->count() }}</p>
                        </div>
                        <div
                            class="w-12 h-12 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fas fa-book text-xl"></i>
                        </div>
                    </div>
                    <a href="{{ route('journals.index') }}"
                        class="text-sm font-bold text-cisa-accent hover:text-cisa-base transition-colors flex items-center">
                        Explore More <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>

                <!-- Submissions -->
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all group border-l-4 border-l-cisa-accent">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">My Submissions</p>
                            <p class="text-3xl font-bold text-cisa-base mt-1">{{ $submissions->count() }}</p>
                        </div>
                        <div
                            class="w-12 h-12 bg-orange-50 text-orange-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fas fa-file-alt text-xl"></i>
                        </div>
                    </div>
                    <a href="{{ route('author.submissions.index') }}"
                        class="text-sm font-bold text-cisa-accent hover:text-cisa-base transition-colors flex items-center">
                        View All <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>

                <!-- Published -->
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all group border-l-4 border-l-green-500">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Published Articles</p>
                            <p class="text-3xl font-bold text-cisa-base mt-1">
                                {{ $submissions->where('status', 'published')->count() }}</p>
                        </div>
                        <div
                            class="w-12 h-12 bg-green-50 text-green-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fas fa-certificate text-xl"></i>
                        </div>
                    </div>
                    <span class="text-sm font-bold text-gray-400 cursor-default flex items-center">
                        Research Impact
                    </span>
                </div>
            </div>

            <!-- My Journals Grid -->
            @if($userJournals->count() > 0)
                <div class="mb-10">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-cisa-base font-serif flex items-center">
                            <span class="w-1 h-6 bg-cisa-accent mr-3 rounded-full"></span>
                            My Journals
                        </h2>
                        <a href="{{ route('journals.index') }}" class="btn-cisa-outline py-1 px-4 text-xs">View All</a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($userJournals as $journal)
                            <div
                                class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-lg hover:border-cisa-accent/30 transition-all p-6 group">
                                <div class="flex justify-between items-start mb-4">
                                    <div
                                        class="bg-blue-50 text-blue-700 px-2 py-1 rounded text-xs font-bold uppercase tracking-wide">
                                        {{ ucfirst(str_replace('_', ' ', $journal->pivot->role)) }}
                                    </div>
                                    <a href="{{ route('journals.show', $journal) }}"
                                        class="text-gray-400 hover:text-cisa-accent transition-colors">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                </div>
                                <h3
                                    class="font-bold text-lg text-cisa-base mb-2 group-hover:text-cisa-accent transition-colors line-clamp-2 min-h-[3.5rem]">
                                    {{ $journal->name }}
                                </h3>
                                <p class="text-sm text-gray-500 mb-6 line-clamp-2 min-h-[2.5rem]">
                                    {{ $journal->description ?? 'No description available' }}
                                </p>

                                <a href="{{ route('journals.show', $journal) }}"
                                    class="block w-full text-center py-2 rounded-lg bg-gray-50 text-cisa-base font-bold text-sm hover:bg-cisa-base hover:text-white transition-colors">
                                    Enter Journal
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Recent Submissions Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-xl font-bold text-cisa-base font-serif flex items-center">
                        <span class="w-1 h-6 bg-cisa-accent mr-3 rounded-full"></span>
                        Recent Submissions
                    </h2>
                    <a href="{{ route('author.submissions.index') }}" class="btn-cisa-primary py-2 px-4 text-xs">
                        <i class="fas fa-plus mr-2"></i>New Submission
                    </a>
                </div>

                @if($submissions->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr
                                    class="bg-slate-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-bold">
                                    <th class="px-6 py-4">Article</th>
                                    <th class="px-6 py-4">Journal</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4">Date</th>
                                    <th class="px-6 py-4 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($submissions as $submission)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-gray-800 text-sm mb-1 line-clamp-1"
                                                title="{{ $submission->title }}">
                                                {{ Str::limit($submission->title, 60) }}
                                            </div>
                                            <span class="text-xs text-gray-400 font-mono">ID: #{{ $submission->id }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-600">{{ Str::limit($submission->journal->name, 30) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @php
                                                $statusClasses = [
                                                    'submitted' => 'bg-yellow-100 text-yellow-700',
                                                    'under_review' => 'bg-blue-100 text-blue-700',
                                                    'accepted' => 'bg-green-100 text-green-700',
                                                    'rejected' => 'bg-red-100 text-red-700',
                                                    'published' => 'bg-purple-100 text-purple-700',
                                                    'revision' => 'bg-orange-100 text-orange-700',
                                                ];
                                                $cls = $statusClasses[$submission->status] ?? 'bg-gray-100 text-gray-600';
                                                $label = ucfirst(str_replace('_', ' ', $submission->status));
                                            @endphp
                                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $cls }}">
                                                {{ $label }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($submission->submitted_at ?? $submission->created_at)->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('author.submissions.show', $submission) }}"
                                                class="text-cisa-base hover:text-cisa-accent font-bold text-sm">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-12 text-center">
                        <div
                            class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                            <i class="fas fa-file-signature text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-500 mb-2">No active submissions</h3>
                        <p class="text-gray-400 text-sm mb-6">Start your journey by making a new submission.</p>
                        <a href="{{ route('journals.index') }}" class="btn-cisa-accent">
                            Browse Journals to Submit
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection