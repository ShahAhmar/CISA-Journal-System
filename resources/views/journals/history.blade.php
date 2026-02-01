@extends('layouts.app')

@section('title', $journal->name . ' - Journal History | CISA')

@section('content')
    <!-- Hero Section -->
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
                    <li class="text-white font-semibold">Journal History</li>
                </ol>
            </nav>

            <div class="max-w-4xl">
                <h1 class="text-3xl md:text-5xl font-serif font-bold leading-tight mb-4 text-white text-shadow-sm">
                    History & Milestones
                </h1>
                <p class="text-blue-100 text-lg font-light max-w-2xl">
                    Tracing the journey of our commitment to academic excellence.
                </p>
            </div>
        </div>
    </div>

    <!-- Bio & Description -->
    @if($journal->description)
        <div class="bg-white py-16 border-b border-gray-100">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <span class="text-cisa-accent font-bold uppercase tracking-wider text-sm mb-4 block">About the Journal</span>
                <h2 class="text-3xl font-serif font-bold text-cisa-base mb-8">{{ $journal->name }}</h2>
                <div class="prose prose-lg max-w-none text-gray-600 font-sans leading-relaxed text-left mx-auto">
                    {!! $journal->description !!}
                </div>
            </div>
        </div>
    @endif

    <!-- Statistics -->
    <div class="bg-slate-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
                <!-- Stat 1 -->
                <div
                    class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 text-center hover:-translate-y-1 transition-transform duration-300">
                    <div class="text-4xl font-bold text-cisa-base mb-2 font-serif">{{ $totalIssues ?? 0 }}</div>
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-widest">Issues Published</div>
                </div>
                <!-- Stat 2 -->
                <div
                    class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 text-center hover:-translate-y-1 transition-transform duration-300">
                    <div class="text-4xl font-bold text-cisa-base mb-2 font-serif">{{ $totalArticles ?? 0 }}</div>
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-widest">Articles Indexed</div>
                </div>
                <!-- Stat 3 -->
                <div
                    class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 text-center hover:-translate-y-1 transition-transform duration-300">
                    <div class="text-4xl font-bold text-cisa-base mb-2 font-serif">
                        {{ $firstIssue ? $firstIssue->year : 'N/A' }}
                    </div>
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-widest">First Volume</div>
                </div>
                <!-- Stat 4 -->
                <div
                    class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 text-center hover:-translate-y-1 transition-transform duration-300">
                    <div class="text-4xl font-bold text-cisa-base mb-2 font-serif">
                        {{ $latestIssue && $latestIssue->published_date ? $latestIssue->published_date->format('Y') : date('Y') }}
                    </div>
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-widest">Latest Volume</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Timeline -->
    <div class="bg-white py-16">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold font-serif text-cisa-base mb-4">Publication Timeline</h2>
                <div class="w-24 h-1 bg-cisa-accent mx-auto rounded-full"></div>
            </div>

            <div class="relative border-l-2 border-gray-100 ml-6 md:ml-10 space-y-12">

                @if($latestIssue)
                    <!-- Latest Milestone -->
                    <div class="relative pl-8 md:pl-12">
                        <div
                            class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-cisa-accent border-4 border-white shadow-sm ring-1 ring-gray-100">
                        </div>

                        <div class="flex flex-col md:flex-row md:items-center gap-2 mb-2">
                            <span class="text-lg font-bold text-cisa-base">Latest Publication</span>
                            <span
                                class="px-2 py-0.5 rounded text-xs font-bold bg-green-50 text-green-700 border border-green-100">Current</span>
                        </div>
                        <div
                            class="bg-slate-50 rounded-xl p-6 border border-gray-100 inline-block w-full hover:shadow-md transition-shadow">
                            <div class="text-sm font-bold text-gray-400 mb-1">
                                {{ $latestIssue->published_date ? $latestIssue->published_date->format('F Y') : 'Recently' }}
                            </div>
                            <h3 class="font-bold text-gray-800 text-lg">
                                Volume {{ $latestIssue->volume }}, Issue {{ $latestIssue->issue_number }}
                            </h3>
                            <p class="text-gray-500 text-sm mt-2">
                                Continuing the tradition of excellence with our most recent collection of research.
                            </p>
                        </div>
                    </div>
                @endif

                <!-- Add more milestones here dynamically in future -->

                @if($firstIssue)
                    <!-- First Milestone -->
                    <div class="relative pl-8 md:pl-12">
                        <div
                            class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-cisa-base border-4 border-white shadow-sm ring-1 ring-gray-100">
                        </div>

                        <div class="flex flex-col md:flex-row md:items-center gap-2 mb-2">
                            <span class="text-lg font-bold text-cisa-base">Inception</span>
                        </div>
                        <div
                            class="bg-slate-50 rounded-xl p-6 border border-gray-100 inline-block w-full hover:shadow-md transition-shadow">
                            <div class="text-sm font-bold text-gray-400 mb-1">
                                {{ $firstIssue->published_date ? $firstIssue->published_date->format('F Y') : $firstIssue->year }}
                            </div>
                            <h3 class="font-bold text-gray-800 text-lg">
                                Establishment & First Issue
                            </h3>
                            <p class="text-gray-500 text-sm mt-2">
                                The journal was founded with the mission to disseminate high-quality research, launching its
                                inaugural issue.
                            </p>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection