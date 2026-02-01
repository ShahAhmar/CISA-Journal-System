@extends('layouts.app')

@section('title', $journal->name . ' - Aims & Scope | CISA')

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
                    <li class="text-white font-semibold">Aims & Scope</li>
                </ol>
            </nav>

            <div class="max-w-4xl">
                <h1 class="text-3xl md:text-5xl font-serif font-bold leading-tight mb-4 text-white text-shadow-sm">
                    Aims & Scope
                </h1>
                <p class="text-blue-100 text-lg font-light max-w-2xl">
                    Defining the research focus and scholarly mission of {{ $journal->name }}
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content Layout -->
    <div class="bg-slate-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

                <!-- Left Column (Content) -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white rounded-xl p-8 shadow-sm border border-gray-100">
                        @if($journal->focus_scope || $journal->aims_scope)
                            <div class="prose prose-lg max-w-none text-gray-700 font-sans leading-relaxed">
                                <div class="flex items-center mb-6">
                                    <span class="w-1 h-8 bg-cisa-accent mr-3 rounded-full"></span>
                                    <h2 class="text-2xl font-serif font-bold text-cisa-base m-0">Journal Focus</h2>
                                </div>
                                {!! $journal->focus_scope ?? $journal->aims_scope !!}
                            </div>
                        @else
                            <div class="text-center py-12">
                                <i class="fas fa-file-alt text-gray-200 text-6xl mb-4"></i>
                                <h3 class="text-xl font-bold text-gray-500 mb-2">Information Updating</h3>
                                <p class="text-gray-400">The aims and scope for this journal are currently being updated.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Call to Action -->
                    <div class="bg-cisa-light/10 border border-cisa-light/20 rounded-xl p-8 text-center">
                        <h3 class="text-xl font-serif font-bold text-cisa-base mb-3">Does your research fit our scope?</h3>
                        <p class="text-gray-600 mb-6">Submit your manuscript today for rigorous peer review and global
                            dissemination.</p>
                        <a href="{{ route('author.submissions.create', $journal) }}"
                            class="btn-cisa-primary px-8 py-3 inline-flex items-center shadow-lg hover:-translate-y-1 transition-transform">
                            <i class="fas fa-file-upload mr-2"></i> Submit Manuscript
                        </a>
                    </div>
                </div>

                <!-- Right Column (Sidebar) -->
                <div class="lg:col-span-1 space-y-8">
                    <!-- Journal Info Small -->
                    <div class="bg-white rounded-xl shadow-glass border border-gray-100 p-6 sticky top-24">
                        <h3 class="text-lg font-bold text-cisa-base mb-4 font-serif">Journal Menu</h3>
                        <div class="space-y-2">
                            <a href="{{ route('journals.editorial-board', $journal) }}"
                                class="flex items-center justify-between p-3 bg-slate-50 text-gray-700 rounded-lg hover:bg-cisa-base hover:text-white transition-all group">
                                <span class="font-medium text-sm">Editorial Board</span>
                                <i class="fas fa-users text-gray-400 group-hover:text-white"></i>
                            </a>
                            <a href="{{ route('journals.author-guidelines', $journal) }}"
                                class="flex items-center justify-between p-3 bg-slate-50 text-gray-700 rounded-lg hover:bg-cisa-base hover:text-white transition-all group">
                                <span class="font-medium text-sm">Author Guidelines</span>
                                <i class="fas fa-file-alt text-gray-400 group-hover:text-white"></i>
                            </a>
                            <a href="{{ route('journals.contact', $journal) }}"
                                class="flex items-center justify-between p-3 bg-slate-50 text-gray-700 rounded-lg hover:bg-cisa-base hover:text-white transition-all group">
                                <span class="font-medium text-sm">Contact</span>
                                <i class="fas fa-envelope text-gray-400 group-hover:text-white"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Open Access Badge -->
                    <div class="bg-gradient-to-br from-cisa-base to-cisa-light rounded-xl p-6 text-white text-center">
                        <div
                            class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-4 backdrop-blur-sm">
                            <i class="fas fa-lock-open text-cisa-accent text-xl"></i>
                        </div>
                        <h3 class="font-bold font-serif text-lg mb-2">Open Access</h3>
                        <p class="text-xs text-gray-300 leading-relaxed mb-4">
                            All articles detailed in our scope are published Open Access, ensuring maximum visibility and
                            impact.
                        </p>
                        <a href="{{ route('journals.open-access-policy', $journal) }}"
                            class="text-cisa-accent text-xs font-bold hover:text-white uppercase tracking-wider">Read
                            Policy</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection