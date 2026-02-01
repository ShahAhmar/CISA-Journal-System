@extends('layouts.app')

@section('title', $journal->name . ' - Submission Guidelines | CISA')

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
                    <li class="text-white font-semibold">Submission Guidelines</li>
                </ol>
            </nav>

            <div class="max-w-4xl">
                <h1 class="text-3xl md:text-5xl font-serif font-bold leading-tight mb-4 text-white text-shadow-sm">
                    Submission Guidelines
                </h1>
                <p class="text-blue-100 text-lg font-light max-w-2xl">
                    Requirements and instructions for submitting your research to {{ $journal->name }}.
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content Layout -->
    <div class="bg-slate-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

                <!-- Left Column (Content) -->
                <div class="lg:col-span-2 space-y-12">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                        @if($journal->submission_guidelines)
                            <div class="prose prose-lg max-w-none text-gray-700 font-sans leading-relaxed">
                                <div class="flex items-center mb-6">
                                    <span class="w-1 h-8 bg-cisa-accent mr-3 rounded-full"></span>
                                    <h2 class="text-2xl font-serif font-bold text-cisa-base m-0">Submission Guidelines</h2>
                                </div>
                                {!! $journal->submission_guidelines !!}
                            </div>
                        @elseif($journal->author_guidelines || $journal->submission_requirements || $journal->submission_checklist)
                            <!-- Fallback: Show combined content -->
                            <div class="prose prose-lg max-w-none space-y-8">
                                @if($journal->author_guidelines)
                                    <div>
                                        <h3 class="text-xl font-bold text-cisa-base mb-4 flex items-center">
                                            <i class="fas fa-file-alt mr-3 text-cisa-accent"></i>Author Guidelines
                                        </h3>
                                        <div class="text-gray-700 leading-relaxed font-sans">
                                            {!! $journal->author_guidelines !!}
                                        </div>
                                    </div>
                                @endif

                                @if($journal->submission_requirements)
                                    <div>
                                        <h3 class="text-xl font-bold text-cisa-base mb-4 flex items-center">
                                            <i class="fas fa-clipboard-check mr-3 text-cisa-accent"></i>Requirements
                                        </h3>
                                        <div class="text-gray-700 leading-relaxed font-sans">
                                            {!! $journal->submission_requirements !!}
                                        </div>
                                    </div>
                                @endif

                                @if($journal->submission_checklist)
                                    <div>
                                        <h3 class="text-xl font-bold text-cisa-base mb-4 flex items-center">
                                            <i class="fas fa-tasks mr-3 text-cisa-accent"></i>Checklist
                                        </h3>
                                        <div class="text-gray-700 leading-relaxed font-sans">
                                            {!! $journal->submission_checklist !!}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-12">
                                <i class="fas fa-file-contract text-gray-200 text-6xl mb-4"></i>
                                <h3 class="text-xl font-bold text-gray-500 mb-2">Information Updating</h3>
                                <p class="text-gray-400">Submission guidelines are currently being updated.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Column (Sidebar) -->
                <div class="lg:col-span-1 space-y-8">
                    <!-- Submit CTA Sidebar -->
                    <div class="bg-cisa-base rounded-xl p-8 text-white text-center shadow-lg relative overflow-hidden">
                        <div
                            class="absolute top-0 right-0 w-32 h-32 bg-cisa-accent rounded-full opacity-10 blur-2xl -mr-10 -mt-10">
                        </div>
                        <h3 class="font-bold font-serif text-xl mb-4 relative z-10">Start Submission</h3>
                        <p class="text-sm text-gray-300 mb-6 relative z-10">
                            Ready to submit your manuscript?
                        </p>
                        <a href="{{ route('author.submissions.create', $journal) }}"
                            class="btn-cisa-accent w-full block py-3 relative z-10">Submit Now</a>
                    </div>

                    <!-- Quick Guidelines -->
                    <div class="bg-white rounded-xl shadow-glass border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-cisa-base mb-4 font-serif">Quick Guide</h3>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <i class="fas fa-file-pdf text-red-500 mt-1 mr-3"></i>
                                <div>
                                    <h4 class="text-sm font-bold text-gray-800">Format</h4>
                                    <p class="text-xs text-gray-500">PDF, Double-spaced, 12pt font.</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-user-secret text-gray-600 mt-1 mr-3"></i>
                                <div>
                                    <h4 class="text-sm font-bold text-gray-800">Anonymity</h4>
                                    <p class="text-xs text-gray-500">Remove author details for review.</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-quote-right text-blue-500 mt-1 mr-3"></i>
                                <div>
                                    <h4 class="text-sm font-bold text-gray-800">Citations</h4>
                                    <p class="text-xs text-gray-500">Follow APA or Chicago style.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection