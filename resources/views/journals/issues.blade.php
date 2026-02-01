@extends('layouts.app')

@section('title', $journal->name . ' - Browse Issues | CISA')

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
                    <li class="text-white font-semibold">Browse Issues</li>
                </ol>
            </nav>

            <h1 class="text-3xl md:text-5xl font-serif font-bold leading-tight mb-2 text-white text-shadow-sm">
                Browse Issues
            </h1>
            <p class="text-blue-200 text-lg font-light">
                Explore the full collection of published issues.
            </p>
        </div>
    </div>

    <div class="bg-slate-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-serif font-bold text-cisa-base">All Issues</h2>
                <div class="text-sm text-gray-500">Showing all published issues</div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($issues as $issue)
                    <div
                        class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all group hover:-translate-y-1">
                        <div class="bg-cisa-base p-6 text-white relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-24 h-24 bg-white opacity-5 rounded-full -mr-8 -mt-8"></div>
                            <span
                                class="inline-block bg-cisa-accent text-cisa-base px-2 py-1 rounded text-xs font-bold uppercase tracking-wider mb-2">
                                {{ $issue->year }}
                            </span>
                            <h3 class="text-xl font-serif font-bold mb-1 group-hover:text-cisa-accent transition-colors">
                                {{ $issue->display_title }}
                            </h3>
                            @if($issue->published_date)
                                <p class="text-xs text-blue-200">
                                    <i class="far fa-calendar-alt mr-1"></i> {{ $issue->published_date->format('F d, Y') }}
                                </p>
                            @endif
                        </div>

                        <div class="p-6">
                            @if($issue->description)
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                    {{ Str::limit($issue->description, 100) }}
                                </p>
                            @else
                                <p class="text-gray-400 text-sm mb-4 italic">
                                    No description available for this issue.
                                </p>
                            @endif

                            <a href="{{ route('journals.issue', [$journal, $issue]) }}"
                                class="btn-cisa-outline w-full text-center block py-2 text-sm">
                                View Table of Contents <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-xl p-12 text-center border border-gray-100 shadow-sm">
                        <div
                            class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                            <i class="fas fa-layer-group text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-500 mb-2">No Issues Found</h3>
                        <p class="text-gray-400 text-sm">There are no published issues available for this journal yet.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-12">
                {{ $issues->links() }}
            </div>
        </div>
    </div>
@endsection