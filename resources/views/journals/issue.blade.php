@extends('layouts.app')

@section('title', $journal->name . ' - ' . $issue->display_title)

@section('content')
    <!-- Issue Hero Section -->
    <div class="relative bg-cisa-base text-white overflow-hidden min-h-[350px] flex items-center">
        <!-- Dynamic Background Layer -->
        <div class="absolute inset-0 z-0">
            @if($journal->cover_image)
                <div class="absolute inset-0 bg-cover bg-center blur-3xl opacity-30 transform scale-110"
                    style="background-image: url('{{ asset('storage/' . $journal->cover_image) }}');">
                </div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-r from-cisa-base via-cisa-base/90 to-transparent"></div>
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10">
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full py-16">
            <nav class="flex mb-6 text-sm text-gray-300" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2">
                    <li><a href="{{ route('journals.index') }}" class="hover:text-cisa-accent transition-colors">Home</a>
                    </li>
                    <li><i class="fas fa-chevron-right text-xs opacity-50"></i></li>
                    <li><a href="{{ route('journals.show', $journal) }}"
                            class="hover:text-cisa-accent transition-colors">{{ $journal->name }}</a></li>
                    <li><i class="fas fa-chevron-right text-xs opacity-50"></i></li>
                    <li><a href="{{ route('journals.issues', $journal) }}"
                            class="hover:text-cisa-accent transition-colors">Issues</a></li>
                    <li><i class="fas fa-chevron-right text-xs opacity-50"></i></li>
                    <li class="text-white font-semibold">Volume {{ $issue->volume }}, Issue {{ $issue->issue_number }}</li>
                </ol>
            </nav>

            <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                <div class="flex-grow">
                    <span
                        class="inline-block bg-cisa-accent text-cisa-base px-3 py-1 rounded text-xs font-bold tracking-wider uppercase mb-3">
                        {{ $issue->year }}
                    </span>
                    <h1 class="text-3xl md:text-5xl font-serif font-bold leading-tight mb-2 text-white text-shadow-sm">
                        {{ $issue->display_title }}
                    </h1>
                    <p class="text-blue-200 text-lg font-light">
                        <i class="far fa-calendar-alt mr-2"></i> Published:
                        {{ $issue->getFormattedPublishedDateAttribute('F d, Y') }}
                    </p>
                </div>

                @if($articles->count() > 0)
                    <div class="text-right hidden md:block">
                        <div class="text-4xl font-bold text-white">{{ $articles->count() }}</div>
                        <div class="text-sm text-gray-400 uppercase tracking-widest">Articles</div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Content Layout -->
    <div class="bg-slate-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

                <!-- Left Column (Articles List) -->
                <div class="lg:col-span-2 space-y-8">

                    <!-- Issue Description -->
                    @if($issue->description)
                        <div class="bg-white rounded-xl p-8 shadow-sm border border-gray-100 mb-8">
                            <h2 class="text-xl font-serif font-bold text-cisa-base mb-4 flex items-center">
                                <i class="fas fa-info-circle mr-2 text-cisa-accent"></i> About this Issue
                            </h2>
                            <div class="prose text-gray-600 max-w-none font-sans leading-relaxed">
                                {!! nl2br(e($issue->description)) !!}
                            </div>
                        </div>
                    @endif

                    <div class="flex items-center justify-between mb-2">
                        <h2 class="text-2xl font-serif font-bold text-cisa-base">Table of Contents</h2>
                        <div class="text-sm text-gray-500">
                            Showing all {{ $articles->count() }} articles
                        </div>
                    </div>

                    @if($articles->count() > 0)
                        <div class="space-y-6">
                            @foreach($articles as $index => $article)
                                <div
                                    class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow group p-6 relative overflow-hidden">
                                    <div
                                        class="absolute top-0 left-0 w-1 h-full bg-gray-100 group-hover:bg-cisa-accent transition-colors">
                                    </div>

                                    <div class="flex flex-col md:flex-row gap-6 pl-4">
                                        <!-- Index Number -->
                                        <div class="flex-shrink-0 pt-1">
                                            <span
                                                class="text-3xl font-bold text-gray-100 group-hover:text-cisa-accent/20 transition-colors">
                                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                            </span>
                                        </div>

                                        <div class="flex-grow">
                                            <div
                                                class="flex flex-wrap items-center gap-3 text-xs text-gray-400 mb-2 font-medium uppercase tracking-wide">
                                                <span class="text-cisa-accent">Research Article</span>
                                                @if($article->page_start)
                                                    <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                                    <span>pp. {{ $article->page_start }} - {{ $article->page_end }}</span>
                                                @endif
                                            </div>

                                            <h3
                                                class="text-xl font-bold text-cisa-base mb-2 font-serif group-hover:text-cisa-accent transition-colors">
                                                <a
                                                    href="{{ route('journals.article', [$journal, $article->id]) }}">{{ $article->title }}</a>
                                            </h3>

                                            <div class="text-sm text-gray-600 mb-4 italic">
                                                @foreach($article->authors as $author)
                                                    {{ $author->full_name }}@if(!$loop->last), @endif
                                                @endforeach
                                            </div>

                                            @if($article->abstract)
                                                <p class="text-gray-500 text-sm line-clamp-2 mb-4 leading-relaxed">
                                                    {{ $article->abstract }}
                                                </p>
                                            @endif

                                            <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-50">
                                                <div class="flex items-center gap-4">
                                                    @if($article->doi)
                                                        <span class="text-xs text-gray-400">DOI: {{ $article->doi }}</span>
                                                    @endif
                                                </div>
                                                <div class="flex gap-3">
                                                    <a href="{{ route('journals.article', [$journal, $article->id]) }}"
                                                        class="text-xs font-bold text-cisa-base hover:text-cisa-accent uppercase tracking-wider flex items-center">
                                                        Abstract <i class="fas fa-arrow-right ml-1"></i>
                                                    </a>
                                                    @php
                                                        $pdfFile = $article->files()->where('file_type', 'manuscript')->first();
                                                    @endphp
                                                    @if($pdfFile)
                                                        <a href="{{ route('journals.article.download', ['journal' => $journal->slug, 'submission' => $article->id]) }}"
                                                            class="text-xs font-bold text-red-600 hover:text-red-700 uppercase tracking-wider flex items-center">
                                                            <i class="far fa-file-pdf mr-1"></i> PDF
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-white rounded-xl p-12 text-center border border-gray-100">
                            <div
                                class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                                <i class="fas fa-file-contract text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-500 mb-2">No Articles Published</h3>
                            <p class="text-gray-400 text-sm">Articles assigned to this issue will appear here.</p>
                        </div>
                    @endif
                </div>

                <!-- Right Column (Sidebar) -->
                <div class="lg:col-span-1 space-y-8">
                    <!-- Browse Issues -->
                    <div class="bg-white rounded-xl shadow-glass border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-cisa-base mb-4 font-serif">Browse</h3>
                        <div class="space-y-2">
                            <a href="{{ route('journals.issues', $journal) }}"
                                class="flex items-center justify-between p-3 bg-slate-50 text-gray-700 rounded-lg hover:bg-cisa-base hover:text-white transition-all group">
                                <span class="font-medium text-sm">All Issues</span>
                                <i class="fas fa-layer-group text-gray-400 group-hover:text-white"></i>
                            </a>
                            <a href="{{ route('journals.latest-issue', $journal) }}"
                                class="flex items-center justify-between p-3 bg-slate-50 text-gray-700 rounded-lg hover:bg-cisa-base hover:text-white transition-all group">
                                <span class="font-medium text-sm">Latest Issue</span>
                                <i class="fas fa-star text-gray-400 group-hover:text-white"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Journal Info Small -->
                    <div class="bg-cisa-base rounded-xl p-6 text-white text-center">
                        <p class="text-sm opacity-80 mb-4">You are viewing</p>
                        <h3 class="font-bold font-serif text-lg mb-4">{{ $journal->name }}</h3>
                        <a href="{{ route('journals.show', $journal) }}"
                            class="btn-cisa-outline text-xs py-2 px-4 w-full">Back to Journal Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection