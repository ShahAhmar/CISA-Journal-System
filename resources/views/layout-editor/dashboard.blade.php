@extends('layouts.app')

@section('title', 'Layout Editor Dashboard | CISA')

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
                        <div
                            class="inline-flex items-center px-3 py-1 bg-white/10 backdrop-blur-sm rounded-full border border-white/20 mb-4">
                            <span class="w-2 h-2 bg-indigo-400 rounded-full mr-2 animate-pulse"></span>
                            <span class="text-white text-xs font-bold uppercase tracking-wider">Production</span>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-serif font-bold mb-2 flex items-center">
                            Layout Editor Dashboard
                        </h1>
                        <p class="text-blue-200 text-lg font-light">
                            Format and prepare articles for final publication.
                        </p>
                    </div>
                    <div class="hidden md:block">
                        <div
                            class="w-20 h-20 bg-white/10 rounded-full flex items-center justify-center border-2 border-white/20">
                            <i class="fas fa-paint-brush text-4xl text-cisa-accent"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Pending Proofreading (Ready for layout) -->
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-lg hover:border-cisa-accent transition-all group">
                    <div class="flex items-center justify-between mb-3">
                        <div
                            class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fas fa-clock text-xl"></i>
                        </div>
                    </div>
                    <div class="text-3xl font-serif font-bold text-cisa-base mb-1">{{ $stats['pending'] ?? 0 }}</div>
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pending (From Proofreading)</div>
                </div>

                <!-- In Layout -->
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-lg hover:border-cisa-accent transition-all group">
                    <div class="flex items-center justify-between mb-3">
                        <div
                            class="w-12 h-12 bg-green-50 text-green-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fas fa-layer-group text-xl"></i>
                        </div>
                    </div>
                    <div class="text-3xl font-serif font-bold text-cisa-base mb-1">{{ $stats['in_layout'] ?? 0 }}</div>
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">In Layout Process</div>
                </div>

                <!-- Total -->
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-lg hover:border-cisa-accent transition-all group">
                    <div class="flex items-center justify-between mb-3">
                        <div
                            class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fas fa-file-alt text-xl"></i>
                        </div>
                    </div>
                    <div class="text-3xl font-serif font-bold text-cisa-base mb-1">{{ $totalCount ?? 0 }}</div>
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Assigned</div>
                </div>
            </div>

            <!-- Submissions Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-xl font-bold text-cisa-base font-serif flex items-center">
                        <span class="w-1 h-6 bg-cisa-accent mr-3 rounded-full"></span>
                        Layout Assignments
                    </h2>
                </div>

                @if(!empty($submissions) && count($submissions) > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr
                                    class="bg-slate-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-bold">
                                    <th class="px-6 py-4">Submission</th>
                                    <th class="px-6 py-4">Journal</th>
                                    <th class="px-6 py-4">Author</th>
                                    <th class="px-6 py-4">Stage</th>
                                    <th class="px-6 py-4">Galleys</th>
                                    <th class="px-6 py-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($submissions as $submission)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-cisa-base text-sm mb-1 line-clamp-1"
                                                title="{{ $submission->title }}">
                                                {{ Str::limit($submission->title, 50) }}
                                            </div>
                                            <div class="text-xs text-gray-400 font-mono">ID: #{{ $submission->id }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-600 font-medium">{{ $submission->journal->name }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-600">{{ $submission->author->full_name }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider
                                                    {{ $submission->current_stage === 'layout' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                                {{ ucfirst(str_replace('_', ' ', $submission->current_stage)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-xs text-gray-500 font-mono">
                                            <i class="fas fa-file-pdf mr-1 text-red-500"></i> {{ $submission->galleys->count() }}
                                            file(s)
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('layout-editor.submissions.show', $submission) }}"
                                                class="btn-cisa-primary py-1.5 px-3 text-xs inline-flex items-center">
                                                View <i class="fas fa-arrow-right ml-1"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-16 text-center">
                        <div
                            class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                            <i class="fas fa-inbox text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-500 mb-2">No assigned submissions</h3>
                        <p class="text-gray-400 text-sm">You haven't been assigned any layout tasks yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection