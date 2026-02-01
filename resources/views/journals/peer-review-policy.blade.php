@extends('layouts.app')

@section('title', $journal->name . ' - Peer Review Policy | CISA')

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
                    <li class="text-white font-semibold">Peer Review Policy</li>
                </ol>
            </nav>

            <div class="max-w-4xl">
                <h1 class="text-3xl md:text-5xl font-serif font-bold leading-tight mb-4 text-white text-shadow-sm">
                    Peer Review Policy
                </h1>
                <p class="text-blue-100 text-lg font-light max-w-2xl">
                    Ensuring scientific rigor and integrity through transparent review processes.
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content Layout -->
    <div class="bg-slate-50 py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 md:p-12">
                @if($journal->peer_review_policy)
                    <div class="prose prose-lg max-w-none text-gray-700 font-sans leading-relaxed">
                        <div class="flex items-center mb-6">
                            <span class="w-1 h-8 bg-cisa-accent mr-3 rounded-full"></span>
                            <h2 class="text-2xl font-serif font-bold text-cisa-base m-0">Our Process</h2>
                        </div>
                        {!! $journal->peer_review_policy !!}
                    </div>
                @else
                    <div class="text-center py-12">
                        <div
                            class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                            <i class="fas fa-tasks text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-500 mb-2">Policy Updating</h3>
                        <p class="text-gray-400">The peer review policy is currently being updated.</p>
                    </div>
                @endif
            </div>

            <!-- Sidebar / Additional Info can go here if layout changes to 2-col, for now focusing on content -->
            <div class="mt-8 flex justify-center gap-4">
                <a href="{{ route('journals.show', $journal) }}" class="btn-cisa-outline px-6 py-2 text-sm">Back to
                    Journal</a>
                <a href="{{ route('journals.editorial-board', $journal) }}" class="btn-cisa-primary px-6 py-2 text-sm">Meet
                    the Editors</a>
            </div>
        </div>
    </div>
@endsection