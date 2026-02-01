@extends('layouts.admin')

@section('title', 'Edit Issue - CISA')
@section('page-title', 'Edit Issue Details')
@section('page-subtitle', 'Manage issue settings and assigned content')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Issue Settings Column -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-slate-50 border-b border-gray-100 px-8 py-5 flex justify-between items-center">
                    <h2 class="font-bold text-cisa-base flex items-center gap-2">
                        <i class="fas fa-edit text-cisa-accent"></i> Edit Issue Metadata
                    </h2>
                    @if($issue->is_published)
                        <span
                            class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Published
                        </span>
                    @else
                        <span
                            class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-600 border border-amber-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Draft
                        </span>
                    @endif
                </div>

                <div class="p-8">
                    <form method="POST" action="{{ route('admin.issues.update', $issue) }}">
                        @csrf
                        @method('PUT')

                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Volume & Numbering</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Volume <span
                                        class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-3 top-3 text-gray-400 text-sm font-bold">Vol</span>
                                    <input type="number" name="volume" required value="{{ old('volume', $issue->volume) }}"
                                        min="1"
                                        class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all text-center font-semibold">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Issue No. <span
                                        class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-3 top-3 text-gray-400 text-sm font-bold">No</span>
                                    <input type="number" name="issue_number" required
                                        value="{{ old('issue_number', $issue->issue_number) }}" min="1"
                                        class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all text-center font-semibold">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Year <span
                                        class="text-red-500">*</span></label>
                                <div class="relative">
                                    <i class="fas fa-calendar absolute left-3 top-3.5 text-gray-300"></i>
                                    <input type="number" name="year" required value="{{ old('year', $issue->year) }}"
                                        min="1900" max="2100"
                                        class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all text-center font-semibold">
                                </div>
                            </div>
                        </div>

                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Issue Content</h3>
                        <div class="space-y-6 mb-8">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Display Title <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="display_title" required
                                    value="{{ old('display_title', $issue->display_title) }}"
                                    class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Description / Editorial
                                    Note</label>
                                <textarea name="description" rows="4"
                                    class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all placeholder-gray-400">{{ old('description', $issue->description) }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Published Date</label>
                                    <div class="relative">
                                        <i class="fas fa-calendar-day absolute left-3 top-3.5 text-gray-300"></i>
                                        <input type="date" name="published_date"
                                            value="{{ old('published_date', $issue->published_date ? (is_string($issue->published_date) ? $issue->published_date : $issue->published_date->format('Y-m-d')) : '') }}"
                                            class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all">
                                    </div>
                                </div>
                                <div class="flex items-center pt-8">
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <div class="relative">
                                            <input type="checkbox" name="is_published" value="1" class="sr-only peer" {{ old('is_published', $issue->is_published) ? 'checked' : '' }}>
                                            <div
                                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-cisa-accent/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-cisa-accent">
                                            </div>
                                        </div>
                                        <span
                                            class="text-sm font-bold text-gray-700 group-hover:text-cisa-accent transition-colors">Publish
                                            Issue</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end gap-4 pt-6 border-t border-gray-100">
                            <a href="{{ route('admin.issues.index') }}"
                                class="px-6 py-2.5 font-bold text-gray-600 hover:text-cisa-base hover:bg-gray-100 rounded-lg transition-colors">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-8 py-2.5 bg-cisa-accent hover:bg-amber-600 text-white font-bold rounded-lg shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all">
                                <i class="fas fa-save mr-2"></i>Update Issue
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Articles Assignment Column -->
        <div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden sticky top-6">
                <div class="bg-slate-800 border-b border-gray-700 px-6 py-4">
                    <h3 class="text-white font-bold text-sm uppercase tracking-wider flex items-center gap-2">
                        <i class="fas fa-list-ul text-cisa-accent"></i> Assigned Articles
                    </h3>
                </div>

                <div class="p-6">
                    @if($articles->count() > 0)
                        <div class="space-y-4">
                            @foreach($articles as $article)
                                <div
                                    class="group relative bg-[#F7F9FC] hover:bg-white rounded-xl border border-gray-200 hover:border-cisa-accent/30 p-4 transition-all shadow-sm">
                                    <h4 class="font-bold text-cisa-base text-sm leading-snug mb-1 pr-6">{{ $article->title }}</h4>
                                    <div class="flex items-center gap-2 text-xs text-gray-500">
                                        <i class="fas fa-user-pen"></i> {{ $article->author->full_name ?? 'Unknown' }}
                                    </div>

                                    <form method="POST" action="{{ route('admin.issues.remove-article', [$issue, $article]) }}"
                                        class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity"
                                        onsubmit="return confirm('Remove article from issue?');">
                                        @csrf
                                        <button type="submit"
                                            class="w-6 h-6 flex items-center justify-center rounded-full bg-red-100 text-red-600 hover:bg-red-500 hover:text-white transition-colors"
                                            title="Remove from Issue">
                                            <i class="fas fa-times text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                        <p class="text-xs text-gray-400 mt-4 text-center">To add articles, go to the Submissions page and assign
                            directly or drag and drop here (future feature).</p>
                    @else
                        <div class="text-center py-8">
                            <div
                                class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-300">
                                <i class="fas fa-file-invoice text-xl"></i>
                            </div>
                            <p class="text-sm font-bold text-gray-700">No articles assigned</p>
                            <p class="text-xs text-gray-500 mt-1">Assign published articles to this issue via the
                                Article/Submission management.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection