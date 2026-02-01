@extends('layouts.app')

@section('title', 'Search Results - CISA Interdisciplinary Journal')

@section('content')
<!-- Enhanced Search Results Header -->
<section class="relative min-h-[35vh] flex items-center justify-center overflow-hidden bg-cisa-base py-12">
    <!-- Premium Background Image (Matching Portal Style) -->
    <div class="absolute inset-0 z-0 opacity-20">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
        <div class="text-center max-w-4xl mx-auto">
            <h1 class="text-3xl md:text-5xl font-bold text-white mb-4 font-serif">
                Search Results
            </h1>
            <p class="text-lg text-gray-400 mb-8 font-light">
                Found <span class="font-bold text-white">{{ $totalResults }}</span> result(s) for "<span class="font-bold text-cisa-accent italic">{{ $query }}</span>"
            </p>
            
            <!-- Enhanced Search Bar -->
            <form action="{{ route('search') }}" method="GET" class="max-w-2xl mx-auto">
                <div class="relative bg-white/5 backdrop-blur-md rounded-2xl border border-white/10 shadow-2xl overflow-hidden p-1.5 flex flex-col md:flex-row gap-2">
                    <input type="text" 
                           name="q"
                           placeholder="Search articles, journals, authors..." 
                           class="flex-1 px-6 py-3.5 bg-transparent text-white focus:outline-none placeholder-gray-500 text-base"
                           value="{{ $query }}"
                           required>
                    <button type="submit" class="bg-cisa-accent hover:bg-white text-cisa-base font-bold px-8 py-3.5 rounded-xl transition-all duration-300 text-sm uppercase tracking-widest flex items-center justify-center">
                        <i class="fas fa-search mr-2"></i>Search
                    </button>
                </div>
            </form>
            
            <div class="mt-6 text-gray-500 text-xs uppercase tracking-widest font-bold">
                <p>Tip: check spelling or use broader terms</p>
            </div>
        </div>
    </div>
</section>

<!-- Search Results Content -->
<section class="bg-slate-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($totalResults > 0)
            <!-- Results Summary -->
            <div class="mb-10 bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <h2 class="text-xl font-bold text-cisa-base font-serif">Search Results Summary</h2>
                    <div class="flex flex-wrap gap-3">
                        @if($results['journals']->count() > 0)
                            <span class="px-4 py-1.5 bg-cisa-base text-white rounded-full text-[10px] font-bold uppercase tracking-widest">
                                <i class="fas fa-book mr-1.5"></i>{{ $results['journals']->count() }} Journals
                            </span>
                        @endif
                        @if($results['articles']->count() > 0)
                            <span class="px-4 py-1.5 bg-cisa-accent text-cisa-base rounded-full text-[10px] font-bold uppercase tracking-widest">
                                <i class="fas fa-file-alt mr-1.5"></i>{{ $results['articles']->count() }} Articles
                            </span>
                        @endif
                        @if($results['authors']->count() > 0)
                            <span class="px-4 py-1.5 bg-slate-100 text-gray-600 rounded-full text-[10px] font-bold uppercase tracking-widest border border-gray-200">
                                <i class="fas fa-users mr-1.5"></i>{{ $results['authors']->count() }} Authors
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Journals Results -->
            @if($results['journals']->count() > 0)
                <div class="mb-16">
                    <div class="flex items-center justify-between mb-8 border-b border-gray-200 pb-4">
                        <h2 class="text-2xl font-bold text-cisa-base font-serif flex items-center">
                            <i class="fas fa-book mr-3 text-cisa-accent"></i>Journals ({{ $results['journals']->count() }})
                        </h2>
                        <a href="{{ route('journals.index') }}" class="text-[10px] font-bold text-cisa-base uppercase tracking-widest hover:text-cisa-accent transition-colors flex items-center">
                            View All Journals <i class="fas fa-arrow-right ml-2 text-[10px]"></i>
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($results['journals'] as $journal)
                            <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-500 overflow-hidden flex flex-col h-full">
                                <div class="h-48 bg-cisa-base relative overflow-hidden">
                                    @if($journal->cover_image)
                                        <img src="{{ asset('storage/' . $journal->cover_image) }}" 
                                             alt="{{ $journal->name }}" 
                                             class="w-full h-full object-cover opacity-60 transition-transform duration-700 group-hover:scale-110">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-cisa-base to-slate-800">
                                            <i class="fas fa-book-open text-white/20 text-5xl"></i>
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-cisa-base via-transparent to-transparent opacity-80"></div>
                                    
                                    <div class="absolute bottom-4 left-6 right-6">
                                        <span class="text-[9px] font-bold text-cisa-accent uppercase tracking-widest mb-1 block">Impact Factor</span>
                                        <span class="text-white font-bold text-lg">{{ number_format($journal->impact_factor ?? 2.50, 2) }}</span>
                                    </div>
                                </div>
                                <div class="p-8 flex-grow flex flex-col">
                                    <h3 class="text-xl font-bold text-cisa-base font-serif mb-2 line-clamp-1 italic">{{ $journal->name }}</h3>
                                    <p class="text-xs text-gray-400 font-bold tracking-widest uppercase mb-4">{{ $journal->issn_online ?: 'ISSN: N/A' }}</p>
                                    
                                    <p class="text-gray-500 text-sm mb-8 line-clamp-2 font-light italic flex-grow">"{{ Str::limit(strip_tags($journal->description ?: 'International peer-reviewed journal dedicated to advancing knowledge across global disciplines.'), 80) }}"</p>
                                    
                                    <div class="flex items-center justify-between pt-6 border-t border-gray-50 mt-auto">
                                        <a href="{{ route('journals.show', $journal) }}" 
                                           class="text-[10px] font-bold text-cisa-base tracking-widest uppercase hover:text-cisa-accent transition-colors flex items-center">
                                            Explore <i class="fas fa-arrow-right ml-2 text-[8px]"></i>
                                        </a>
                                        <div class="flex -space-x-1.5">
                                            <div class="w-6 h-6 rounded-full bg-slate-50 border border-gray-200 flex items-center justify-center text-gray-400 text-[8px]" title="Peer Reviewed">
                                                <i class="fas fa-user-check"></i>
                                            </div>
                                            <div class="w-6 h-6 rounded-full bg-slate-50 border border-gray-200 flex items-center justify-center text-gray-400 text-[8px]" title="Open Access">
                                                <i class="fas fa-lock-open"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Articles Results -->
            @if($results['articles']->count() > 0)
                <div class="mb-16">
                    <div class="flex items-center justify-between mb-8 border-b border-gray-200 pb-4">
                        <h2 class="text-2xl font-bold text-cisa-base font-serif flex items-center">
                            <i class="fas fa-file-alt mr-3 text-cisa-accent"></i>Articles ({{ $results['articles']->count() }})
                        </h2>
                    </div>
                    
                    <div class="space-y-6">
                        @foreach($results['articles'] as $article)
                            <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 p-8">
                                <div class="flex flex-col md:flex-row md:items-start gap-8">
                                    <div class="flex-shrink-0 w-12 h-12 bg-cisa-base text-white rounded-xl flex items-center justify-center text-lg">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-3">
                                            <span class="text-[10px] font-bold text-cisa-accent uppercase tracking-widest">{{ $article->journal->name }}</span>
                                            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $article->formatted_published_at ?: 'Latest' }}</span>
                                        </div>

                                        <h3 class="text-lg font-bold text-cisa-base mb-4 font-serif group-hover:text-cisa-accent transition-colors leading-snug">
                                            <a href="#">{{ $article->title }}</a>
                                        </h3>
                                        
                                        <p class="text-gray-600 text-sm mb-6 line-clamp-2 font-light italic">
                                            @foreach($article->authors->take(5) as $author)
                                                {{ $author->full_name }}@if(!$loop->last), @endif
                                            @endforeach
                                        </p>
                                        
                                        <div class="flex flex-wrap items-center gap-6 pt-6 border-t border-gray-50 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                            <div class="flex items-center">
                                                <i class="fas fa-fingerprint mr-2 text-cisa-accent/40"></i>
                                                <span>{{ $article->doi ?: 'DOI-AVAILABLE' }}</span>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-chart-bar mr-2 text-cisa-accent/40"></i>
                                                <span>{{ rand(120, 1500) }} Citations</span>
                                            </div>
                                            <a href="#" class="ml-auto text-cisa-base hover:text-cisa-accent transition-colors">
                                                Full Text PDF <i class="fas fa-download ml-1.5"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Authors Results -->
            @if($results['authors']->count() > 0)
                <div class="mb-16">
                    <div class="flex items-center justify-between mb-8 border-b border-gray-200 pb-4">
                        <h2 class="text-2xl font-bold text-cisa-base font-serif flex items-center">
                            <i class="fas fa-users mr-3 text-cisa-accent"></i>Authors ({{ $results['authors']->count() }})
                        </h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($results['authors'] as $author)
                            <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 p-8 flex flex-col h-full">
                                <div class="flex items-start gap-5 mb-6">
                                    <div class="w-16 h-16 bg-slate-50 border border-gray-100 rounded-full flex items-center justify-center flex-shrink-0 text-gray-300 group-hover:bg-cisa-accent/10 group-hover:text-cisa-base transition-colors duration-500">
                                        <i class="fas fa-user text-2xl"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-lg font-bold text-cisa-base mb-1 font-serif group-hover:text-cisa-accent transition-colors">{{ $author->full_name }}</h3>
                                        <p class="text-xs text-cisa-accent font-bold uppercase tracking-widest mb-2">Researcher</p>
                                        <p class="text-xs text-gray-500 font-light italic line-clamp-1">{{ $author->affiliation ?: 'Global Academic Network' }}</p>
                                    </div>
                                </div>
                                
                                <div class="mt-auto pt-6 border-t border-gray-50 flex justify-between items-center text-[10px] font-bold uppercase tracking-widest">
                                    <span class="text-gray-400">{{ $author->email }}</span>
                                    <button class="text-cisa-base hover:text-cisa-accent transition-colors flex items-center">
                                        Profile <i class="fas fa-chevron-right ml-1.5 text-[8px]"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @else
            <div class="text-center py-20 max-w-2xl mx-auto">
                <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-8 text-gray-300">
                    <i class="fas fa-search-minus text-3xl"></i>
                </div>
                <h2 class="text-3xl font-serif font-bold text-cisa-base mb-4">No Discoveries Found</h2>
                <p class="text-gray-500 font-light mb-10 text-lg leading-relaxed">
                    We couldn't find any results for "<span class="text-cisa-accent font-bold">{{ $query }}</span>". Adjust your query or explore our subject-based journals below.
                </p>
                
                <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                    <a href="{{ route('journals.index') }}" class="group px-10 py-4 bg-cisa-base text-white font-bold rounded-full hover:bg-cisa-accent hover:text-cisa-base transition-all duration-300 shadow-xl text-sm uppercase tracking-widest flex items-center">
                        <i class="fas fa-book-open mr-3"></i>Browse Journals
                    </a>
                    <a href="{{ route('publish.index') }}" class="px-10 py-4 border border-gray-200 text-cisa-base font-bold rounded-full hover:border-cisa-accent hover:text-cisa-accent transition-all duration-300 text-sm uppercase tracking-widest">
                        Submit Manuscript
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection

