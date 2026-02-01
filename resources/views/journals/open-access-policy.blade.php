@extends('layouts.app')

@section('title', $journal->name . ' - Open Access Policy | CISA')

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
                    <li class="text-white font-semibold">Open Access Policy</li>
                </ol>
            </nav>

            <div class="max-w-4xl">
                <h1 class="text-3xl md:text-5xl font-serif font-bold leading-tight mb-4 text-white text-shadow-sm">
                    Open Access Policy
                </h1>
                <p class="text-blue-100 text-lg font-light max-w-2xl">
                    Promoting global knowledge exchange through immediate and free access to research.
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content Layout -->
    <div class="bg-slate-50 py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 md:p-12">
                @if($journal->open_access_policy)
                    <div class="prose prose-lg max-w-none text-gray-700 font-sans leading-relaxed">
                        <div class="flex items-center mb-6">
                            <span class="w-1 h-8 bg-cisa-accent mr-3 rounded-full"></span>
                            <h2 class="text-2xl font-serif font-bold text-cisa-base m-0">Statement</h2>
                        </div>
                        {!! $journal->open_access_policy !!}
                    </div>
                @else
                    <div class="text-center py-12">
                        <div
                            class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                            <i class="fas fa-lock-open text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-500 mb-2">Policy Updating</h3>
                        <p class="text-gray-400">The open access policy is currently being updated.</p>
                    </div>
                @endif
            </div>

            <div class="mt-8 flex justify-center gap-4">
                <div class="bg-cisa-base text-white p-6 rounded-xl shadow-lg max-w-2xl text-center">
                    <i class="fas fa-globe-americas text-4xl text-cisa-accent mb-4"></i>
                    <h3 class="font-bold text-xl mb-2">Knowledge for Everyone</h3>
                    <p class="text-sm text-gray-300">This journal provides immediate open access to its content on the
                        principle that making research freely available to the public supports a greater global exchange of
                        knowledge.</p>
                </div>
            </div>
        </div>
    </div>
@endsection