@extends('layouts.app')

@section('title', $journal->name . ' - Archives | CISA')

@section('content')
    <!-- Hero Section -->
    <div class="relative bg-cisa-base text-white overflow-hidden min-h-[300px] flex items-center">
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

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full py-12">
            <nav class="flex mb-6 text-sm text-gray-300" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2">
                    <li><a href="{{ route('journals.index') }}" class="hover:text-cisa-accent transition-colors">Home</a>
                    </li>
                    <li><i class="fas fa-chevron-right text-xs opacity-50"></i></li>
                    <li><a href="{{ route('journals.show', $journal) }}"
                            class="hover:text-cisa-accent transition-colors">{{ $journal->name }}</a></li>
                    <li><i class="fas fa-chevron-right text-xs opacity-50"></i></li>
                    <li class="text-white font-semibold">Archives</li>
                </ol>
            </nav>

            <h1 class="text-3xl md:text-5xl font-serif font-bold leading-tight mb-2 text-white text-shadow-sm">
                Archives
            </h1>
            <p class="text-blue-200 text-lg font-light">
                Browse the complete history of our published research.
            </p>
        </div>
    </div>

    <!-- View Toggle (Sticky) -->
    <div class="bg-white border-b border-gray-200 sticky top-0 z-30 shadow-sm backdrop-blur-md bg-white/90">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-wrap gap-2 justify-center sm:justify-start">
                <span
                    class="mr-2 text-gray-500 font-bold self-center text-sm uppercase tracking-wider hidden sm:inline-block">Browse
                    By:</span>
                <a href="{{ route('journals.archives', ['journal' => $journal, 'view' => 'year']) }}"
                    class="px-4 py-2 rounded-lg text-sm font-bold transition-all border {{ $view === 'year' ? 'bg-cisa-base text-white border-cisa-base shadow-md' : 'bg-slate-50 text-gray-600 border-gray-200 hover:bg-white hover:border-cisa-accent hover:text-cisa-base' }}">
                    <i class="fas fa-calendar-alt mr-2"></i>Year
                </a>
                <a href="{{ route('journals.archives', ['journal' => $journal, 'view' => 'volume']) }}"
                    class="px-4 py-2 rounded-lg text-sm font-bold transition-all border {{ $view === 'volume' ? 'bg-cisa-base text-white border-cisa-base shadow-md' : 'bg-slate-50 text-gray-600 border-gray-200 hover:bg-white hover:border-cisa-accent hover:text-cisa-base' }}">
                    <i class="fas fa-book mr-2"></i>Volume
                </a>
                <a href="{{ route('journals.archives', ['journal' => $journal, 'view' => 'issue']) }}"
                    class="px-4 py-2 rounded-lg text-sm font-bold transition-all border {{ $view === 'issue' ? 'bg-cisa-base text-white border-cisa-base shadow-md' : 'bg-slate-50 text-gray-600 border-gray-200 hover:bg-white hover:border-cisa-accent hover:text-cisa-base' }}">
                    <i class="fas fa-list mr-2"></i>List
                </a>
            </div>
        </div>
    </div>

    <!-- Archives Content -->
    <div class="bg-slate-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if($view === 'year')
                <!-- Year-wise View -->
                <div class="space-y-10">
                    @foreach($issuesByYear as $year => $yearIssues)
                        <div class="relative pl-8 border-l-2 border-gray-200">
                            <div
                                class="absolute -left-[18px] top-0 w-9 h-9 bg-cisa-base text-white rounded-full flex items-center justify-center font-bold shadow-lg border-4 border-slate-50">
                                {{ substr($year, -2) }}
                            </div>

                            <h2 class="text-3xl font-serif font-bold text-cisa-base mb-6 flex items-center">
                                {{ $year }} <span class="text-sm font-sans font-normal text-gray-400 ml-3">({{ count($yearIssues) }}
                                    Issues)</span>
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($yearIssues as $issue)
                                    <a href="{{ route('journals.issue', [$journal, $issue]) }}"
                                        class="group bg-white rounded-xl p-6 border border-gray-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all">
                                        <div class="flex justify-between items-start mb-4">
                                            <div
                                                class="bg-blue-50 text-blue-700 px-3 py-1 rounded text-xs font-bold uppercase tracking-wide">
                                                Vol {{ $issue->volume }}
                                            </div>
                                            <div
                                                class="bg-cisa-accent/10 text-cisa-accent px-3 py-1 rounded text-xs font-bold uppercase tracking-wide">
                                                No {{ $issue->issue_number }}
                                            </div>
                                        </div>
                                        <h3
                                            class="font-bold text-cisa-base text-lg mb-2 group-hover:text-cisa-accent transition-colors leading-tight">
                                            {{ $issue->display_title }}
                                        </h3>
                                        @if($issue->published_date)
                                            <p class="text-xs text-gray-400 mb-4">
                                                <i class="far fa-calendar-alt mr-1"></i> {{ $issue->formatted_published_date }}
                                            </p>
                                        @endif

                                        @php
                                            $articleCount = $issue->submissions()->where('status', 'published')->count();
                                        @endphp
                                        <div class="flex items-center text-sm text-gray-500 mt-auto pt-4 border-t border-gray-50">
                                            <i class="fas fa-file-alt mr-2"></i> {{ $articleCount }} Articles
                                            <i
                                                class="fas fa-arrow-right ml-auto text-cisa-accent opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

            @elseif($view === 'volume')
                <!-- Volume-wise View -->
                <div class="grid grid-cols-1 gap-12">
                    @foreach($issuesByVolume as $volume => $volumeIssues)
                        <div>
                            <div class="flex items-center mb-6">
                                <span class="w-1 h-8 bg-cisa-accent mr-3 rounded-full"></span>
                                <h2 class="text-2xl font-serif font-bold text-cisa-base m-0">Volume {{ $volume }}</h2>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                @foreach($volumeIssues as $issue)
                                    <a href="{{ route('journals.issue', [$journal, $issue]) }}"
                                        class="group bg-white rounded-xl p-5 border border-gray-100 shadow-sm hover:shadow-lg hover:border-cisa-accent/30 transition-all">
                                        <div class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-2">
                                            Issue {{ $issue->issue_number }} &bull; {{ $issue->year }}
                                        </div>
                                        <h3
                                            class="font-bold text-cisa-base text-lg mb-4 group-hover:text-cisa-accent transition-colors">
                                            {{ $issue->display_title }}
                                        </h3>
                                        @php
                                            $articleCount = $issue->submissions()->where('status', 'published')->count();
                                        @endphp
                                        <div class="text-xs text-gray-500 flex items-center justify-between">
                                            <span>{{ $articleCount }} Articles</span>
                                            <span class="text-cisa-base font-bold group-hover:underline">View</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

            @else
                <!-- Issue-wise View (List) -->
                <div class="max-w-4xl mx-auto space-y-4">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-serif font-bold text-cisa-base">All Issues List</h2>
                        <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-bold">{{ count($issues) }}
                            Total</span>
                    </div>

                    @foreach($issues as $issue)
                        <a href="{{ route('journals.issue', [$journal, $issue]) }}"
                            class="block bg-white rounded-xl p-6 border border-gray-100 shadow-sm hover:shadow-md hover:border-cisa-accent/30 transition-all group">
                            <div class="flex flex-col md:flex-row md:items-center gap-6">

                                <div
                                    class="flex-shrink-0 flex flex-row md:flex-col items-center gap-3 md:gap-1 text-center min-w-[80px]">
                                    <div
                                        class="text-3xl font-serif font-bold text-cisa-base group-hover:text-cisa-accent transition-colors">
                                        {{ $issue->issue_number }}
                                    </div>
                                    <div class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                                        Issue
                                    </div>
                                </div>

                                <div class="flex-grow border-l-0 md:border-l border-gray-100 md:pl-6">
                                    <div class="flex flex-wrap items-center gap-2 mb-2">
                                        <span class="bg-cisa-base text-white px-2 py-0.5 rounded text-xs font-bold">Vol
                                            {{ $issue->volume }}</span>
                                        <span
                                            class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded text-xs font-bold">{{ $issue->year }}</span>
                                        @if($issue->published_date)
                                            <span class="text-xs text-gray-400 ml-auto">{{ $issue->formatted_published_date }}</span>
                                        @endif
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-cisa-accent transition-colors">
                                        {{ $issue->display_title }}
                                    </h3>
                                    @if($issue->description)
                                        <p class="text-gray-500 text-sm line-clamp-2">{{ $issue->description }}</p>
                                    @endif
                                </div>

                                <div class="flex-shrink-0 self-center">
                                    <span
                                        class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-cisa-base group-hover:bg-cisa-accent group-hover:text-white transition-colors">
                                        <i class="fas fa-chevron-right"></i>
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif

            @if(isset($issues) && $issues instanceof \Illuminate\Pagination\LengthAwarePaginator && $issues->isEmpty())
                <div class="bg-white rounded-xl border border-gray-100 p-12 text-center shadow-sm">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                        <i class="fas fa-box-open text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-500 mb-2">No Archives Found</h3>
                    <p class="text-gray-400 text-sm">We couldn't find any issues matching your criteria.</p>
                </div>
            @endif
        </div>
    </div>
@endsection