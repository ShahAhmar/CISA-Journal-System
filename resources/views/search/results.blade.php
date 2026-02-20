@extends('layouts.app')

@section('title', 'Search Results - EMANP')

@section('content')
<!-- Search Results Header -->
<section class="bg-[#0F1B4C] py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-6">
                Search Results for "{{ $query }}"
            </h1>
            <p class="text-white text-lg mb-6">
                Found {{ $totalResults }} result(s)
            </p>
            
            <!-- Search Bar -->
            <form action="{{ route('search') }}" method="GET" class="max-w-3xl mx-auto">
                <div class="flex shadow-2xl rounded-lg overflow-hidden">
                    <input type="text" 
                           name="q"
                           placeholder="Enter keywords, authors, DOI, etc." 
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

<!-- Search Results Content -->
<section class="bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($totalResults > 0)
            <!-- Journals Results -->
            @if($results['journals']->count() > 0)
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-[#0F1B4C] mb-6">
                        Journals ({{ $results['journals']->count() }})
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($results['journals'] as $journal)
                            <div class="bg-white rounded-xl border-2 border-gray-200 hover:border-[#0056FF] hover:shadow-xl transition-all duration-300 overflow-hidden">
                                <div class="h-48 bg-gradient-to-br from-[#0056FF] to-[#1D72B8] flex items-center justify-center">
                                    @if($journal->logo)
                                        <img src="{{ asset('storage/' . $journal->logo) }}" 
                                             alt="{{ $journal->name }}" 
                                             class="w-full h-full object-cover"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="w-full h-full flex items-center justify-center hidden">
                                            <i class="fas fa-book-open text-white text-5xl opacity-50"></i>
                                        </div>
                                    @else
                                        <i class="fas fa-book-open text-white text-5xl opacity-50"></i>
                                    @endif
                                </div>
                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-[#0F1B4C] mb-3">{{ $journal->name }}</h3>
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ Str::limit($journal->description, 100) }}</p>
                                    <a href="{{ route('journals.show', $journal) }}" class="btn bg-[#0F1B4C] hover:bg-[#0A1538] text-white w-full text-center py-2.5 rounded-lg font-semibold transition-colors">
                                        View Journal
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Articles Results -->
            @if($results['articles']->count() > 0)
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-[#0F1B4C] mb-6">
                        Articles ({{ $results['articles']->count() }})
                    </h2>
                    <div class="space-y-4">
                        @foreach($results['articles'] as $article)
                            <div class="bg-white rounded-xl border-2 border-gray-200 hover:border-[#0056FF] hover:shadow-lg transition-all duration-300 p-6">
                                <h3 class="text-xl font-bold text-[#0F1B4C] mb-3">
                                    <a href="#" class="hover:text-[#0056FF] transition-colors">{{ $article->title }}</a>
                                </h3>
                                <p class="text-sm text-gray-600 mb-2">
                                    <span class="font-semibold">{{ $article->journal->name }}</span>
                                </p>
                                <p class="text-sm text-gray-600 mb-2">
                                    @foreach($article->authors as $author)
                                        {{ $author->full_name }}@if(!$loop->last), @endif
                                    @endforeach
                                </p>
                                @if($article->abstract)
                                    <p class="text-gray-700 mb-3 line-clamp-2">{{ Str::limit($article->abstract, 200) }}</p>
                                @endif
                                @if($article->doi)
                                    <p class="text-xs text-gray-500 mb-3">
                                        <span class="font-semibold">DOI:</span> {{ $article->doi }}
                                    </p>
                                @endif
                                @if($article->formatted_published_at)
                                    <p class="text-xs text-gray-500">
                                        <span class="font-semibold">Published:</span> {{ $article->formatted_published_at }}
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Authors Results -->
            @if($results['authors']->count() > 0)
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-[#0F1B4C] mb-6">
                        Authors ({{ $results['authors']->count() }})
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($results['authors'] as $author)
                            <div class="bg-white rounded-xl border-2 border-gray-200 hover:border-[#0056FF] hover:shadow-lg transition-all duration-300 p-6">
                                <h3 class="text-lg font-bold text-[#0F1B4C] mb-2">{{ $author->full_name }}</h3>
                                @if($author->affiliation)
                                    <p class="text-sm text-gray-600 mb-2">{{ $author->affiliation }}</p>
                                @endif
                                <p class="text-sm text-gray-500">{{ $author->email }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @else
            <div class="text-center py-16">
                <i class="fas fa-search text-gray-400 text-6xl mb-4"></i>
                <h2 class="text-2xl font-bold text-gray-700 mb-2">No results found</h2>
                <p class="text-gray-600 mb-6">Try different keywords or search terms.</p>
                <a href="{{ route('journals.index') }}" class="btn bg-[#0056FF] hover:bg-[#0044CC] text-white px-8 py-3 rounded-lg font-semibold transition-colors">
                    Browse All Journals
                </a>
            </div>
        @endif
    </div>
</section>
@endsection

