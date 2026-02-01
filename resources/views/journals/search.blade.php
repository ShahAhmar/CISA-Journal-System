@extends('layouts.app')

@section('title', 'Search - ' . $journal->name . ' | EMANP')

@section('content')
<!-- Hero Section -->
<section class="bg-[#0F1B4C] text-white py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 20px 20px;"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center">
            <div class="inline-block mb-6">
                @if($journal->logo)
                    <img src="{{ asset('storage/' . $journal->logo) }}" 
                         alt="{{ $journal->name }}" 
                         class="h-20 w-20 object-contain mx-auto bg-white p-3 rounded-xl shadow-xl"
                         onerror="this.style.display='none';">
                @endif
            </div>
            <h1 class="text-3xl md:text-4xl font-bold mb-4" style="font-family: 'Playfair Display', serif; font-weight: 700;">
                Search Results in {{ $journal->name }}
            </h1>
            <p class="text-lg text-blue-200 mb-6">
                Found {{ $articles->total() }} article(s) for "{{ $query }}"
            </p>
            
            <!-- Search Bar -->
            <form action="{{ route('journals.search', $journal) }}" method="GET" class="max-w-3xl mx-auto">
                <div class="flex shadow-2xl rounded-lg overflow-hidden">
                    <input type="text" 
                           name="q"
                           placeholder="Search articles in {{ $journal->name }}..." 
                           class="flex-1 px-6 py-4 text-lg text-gray-900 focus:outline-none"
                           value="{{ $query }}"
                           required>
                    <button type="submit" class="bg-[#0056FF] hover:bg-[#0044CC] px-8 py-4 text-white transition-colors">
                        <i class="fas fa-search text-xl"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Breadcrumb -->
<div class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <nav class="flex items-center space-x-2 text-sm">
            <a href="{{ route('journals.index') }}" class="text-[#0056FF] hover:text-[#0044CC] transition-colors">
                <i class="fas fa-home"></i> Home
            </a>
            <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
            <a href="{{ route('journals.show', $journal) }}" class="text-[#0056FF] hover:text-[#0044CC] transition-colors">
                {{ Str::limit($journal->name, 30) }}
            </a>
            <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
            <span class="text-gray-600">Search Results</span>
        </nav>
    </div>
</div>

<!-- Search Results -->
<section class="bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($articles->count() > 0)
            <div class="space-y-6">
                @foreach($articles as $article)
                    <div class="bg-white rounded-xl border-2 border-gray-200 hover:border-[#0056FF] hover:shadow-xl transition-all duration-300 p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center">
                                <i class="fas fa-file-alt text-white text-xl"></i>
                            </div>
                            @if($article->published_at)
                                <span class="text-xs text-gray-500 font-semibold" style="font-family: 'Inter', sans-serif;">
                                    {{ $article->formatPublishedAt('M d, Y') ?? \Carbon\Carbon::parse($article->published_at)->format('M d, Y') }}
                                </span>
                            @endif
                        </div>
                        
                        <h3 class="text-xl font-bold text-[#0F1B4C] mb-3 leading-tight" style="font-family: 'Playfair Display', serif; font-weight: 700;">
                            <a href="{{ route('journals.article', [$journal, $article->id]) }}" class="hover:text-[#0056FF] transition-colors">{{ $article->title }}</a>
                        </h3>
                        
                        <p class="text-sm text-gray-600 mb-3" style="font-family: 'Inter', sans-serif; font-weight: 500;">
                            @foreach($article->authors as $author)
                                {{ $author->full_name }}@if(!$loop->last), @endif
                            @endforeach
                        </p>
                        
                        @if($article->abstract)
                            <p class="text-gray-700 mb-4 leading-relaxed" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.7;">
                                {{ Str::limit($article->abstract, 300) }}
                            </p>
                        @endif
                        
                        <div class="flex flex-wrap items-center gap-4 mb-4">
                            @if($article->keywords)
                                <div class="flex flex-wrap gap-2">
                                    @foreach(explode(',', $article->keywords) as $keyword)
                                        <span class="bg-[#F7F9FC] text-[#0056FF] px-3 py-1 rounded-full text-xs font-semibold">
                                            {{ trim($keyword) }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                            @if($article->doi)
                                <p class="text-xs text-gray-500" style="font-family: 'Inter', sans-serif;">
                                    <i class="fas fa-fingerprint mr-1"></i>DOI: {{ $article->doi }}
                                </p>
                            @endif
                        </div>
                        
                        @if($article->issue)
                            <p class="text-sm text-gray-600 mb-3" style="font-family: 'Inter', sans-serif;">
                                <i class="fas fa-book mr-1"></i>
                                <span class="font-semibold">Issue:</span> {{ $article->issue->display_title }}
                            </p>
                        @endif
                        
                        <a href="{{ route('journals.article', [$journal, $article->id]) }}" class="text-[#0056FF] hover:text-[#0044CC] text-sm font-semibold transition-colors inline-flex items-center" style="font-family: 'Inter', sans-serif;">
                            Read Full Article <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-8">
                {{ $articles->appends(['q' => $query])->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <i class="fas fa-search text-gray-400 text-6xl mb-4"></i>
                <h2 class="text-2xl font-bold text-gray-700 mb-2" style="font-family: 'Playfair Display', serif;">
                    No articles found
                </h2>
                <p class="text-gray-600 mb-6" style="font-family: 'Inter', sans-serif;">
                    No articles found in {{ $journal->name }} matching "{{ $query }}". Try different keywords.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('journals.show', $journal) }}" 
                       class="bg-[#0056FF] hover:bg-[#0044CC] text-white px-8 py-3 rounded-lg font-semibold transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Journal
                    </a>
                    <a href="{{ route('journals.search', $journal) }}" 
                       class="bg-white hover:bg-gray-50 text-[#0F1B4C] border-2 border-[#0F1B4C] px-8 py-3 rounded-lg font-semibold transition-colors">
                        <i class="fas fa-redo mr-2"></i>New Search
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection

