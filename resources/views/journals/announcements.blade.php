@extends('layouts.app')

@section('title', $journal->name . ' - Announcements | CISA')

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
                    <li class="text-white font-semibold">Announcements</li>
                </ol>
            </nav>

            <div class="max-w-4xl">
                <h1 class="text-3xl md:text-5xl font-serif font-bold leading-tight mb-4 text-white text-shadow-sm">
                    Announcements
                </h1>
                <p class="text-blue-100 text-lg font-light max-w-2xl">
                    Stay informed with the latest news, calls for papers, and updates.
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content Layout -->
    <div class="bg-slate-50 py-16">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="space-y-8">
                @forelse($announcements as $announcement)
                    <div
                        class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 group border border-gray-100">
                        <div class="flex flex-col md:flex-row">
                            <!-- Icon Column -->
                            <div class="md:w-32 bg-gray-50 flex items-center justify-center p-6 border-r border-gray-100">
                                @if($announcement->type === 'call_for_papers')
                                    <div
                                        class="w-16 h-16 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-2xl shadow-inner">
                                        <i class="fas fa-bullhorn"></i>
                                    </div>
                                @elseif($announcement->type === 'new_issue')
                                    <div
                                        class="w-16 h-16 rounded-full bg-green-100 text-green-600 flex items-center justify-center text-2xl shadow-inner">
                                        <i class="fas fa-book-open"></i>
                                    </div>
                                @elseif($announcement->type === 'maintenance')
                                    <div
                                        class="w-16 h-16 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-2xl shadow-inner">
                                        <i class="fas fa-tools"></i>
                                    </div>
                                @else
                                    <div
                                        class="w-16 h-16 rounded-full bg-cisa-accent/20 text-cisa-accent flex items-center justify-center text-2xl shadow-inner">
                                        <i class="fas fa-star"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Content Column -->
                            <div class="p-8 flex-1">
                                <div class="flex flex-col md:flex-row md:items-center justify-between mb-4">
                                    <div>
                                        @if($announcement->published_at)
                                            <span class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1 block">
                                                {{ \Carbon\Carbon::parse($announcement->published_at)->format('F d, Y') }}
                                            </span>
                                        @endif
                                        <h2
                                            class="text-2xl font-serif font-bold text-cisa-base group-hover:text-cisa-accent transition-colors">
                                            {{ $announcement->title }}
                                        </h2>
                                    </div>
                                    <div class="mt-2 md:mt-0">
                                        @if($announcement->journal)
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                                {{ $announcement->journal->code ?? 'Journal' }}
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                General
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="prose prose-sm max-w-none text-gray-600 mb-6">
                                    {!! Str::limit($announcement->content, 300) !!}
                                </div>

                                <a href="#"
                                    class="inline-flex items-center font-bold text-cisa-base hover:text-cisa-accent transition-colors">
                                    Read More <i class="fas fa-arrow-right ml-2 text-sm"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-xl border border-gray-100 p-16 text-center shadow-sm">
                        <div
                            class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300">
                            <i class="fas fa-scroll text-4xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-500 mb-2">No Announcements</h3>
                        <p class="text-gray-400">There are no announcements to display at this time.</p>
                    </div>
                @endforelse
            </div>

            @if($announcements->hasPages())
                <div class="mt-12">
                    {{ $announcements->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection