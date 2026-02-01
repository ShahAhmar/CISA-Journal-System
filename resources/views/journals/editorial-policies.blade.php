@extends('layouts.app')

@section('title', $journal->name . ' - Editorial Policies | CISA')

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
                    <li class="text-white font-semibold">Editorial Policies</li>
                </ol>
            </nav>

            <div class="max-w-4xl">
                <h1 class="text-3xl md:text-5xl font-serif font-bold leading-tight mb-4 text-white text-shadow-sm">
                    Editorial Policies
                </h1>
                <p class="text-blue-100 text-lg font-light max-w-2xl">
                    Guiding principles and standards for publication and editorial conduct.
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content Layout -->
    <div class="bg-slate-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

                <!-- Sidebar Navigation (Sticky) -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-glass border border-gray-100 p-6 sticky top-24">
                        <h3 class="font-bold font-serif text-cisa-base mb-4">Policy Contents</h3>
                        <ul class="space-y-2 text-sm">
                            @if($journal->focus_scope)
                                <li>
                                    <a href="#focus-scope"
                                        class="flex items-center text-gray-600 hover:text-cisa-accent transition-colors group">
                                        <i
                                            class="fas fa-chevron-right text-xs opacity-50 mr-2 group-hover:text-cisa-accent"></i>
                                        Focus & Scope
                                    </a>
                                </li>
                            @endif
                            @if($journal->publication_frequency)
                                <li>
                                    <a href="#publication-frequency"
                                        class="flex items-center text-gray-600 hover:text-cisa-accent transition-colors group">
                                        <i
                                            class="fas fa-chevron-right text-xs opacity-50 mr-2 group-hover:text-cisa-accent"></i>
                                        Frequency
                                    </a>
                                </li>
                            @endif
                            @if($journal->peer_review_policy || $journal->peer_review_process)
                                <li>
                                    <a href="#peer-review"
                                        class="flex items-center text-gray-600 hover:text-cisa-accent transition-colors group">
                                        <i
                                            class="fas fa-chevron-right text-xs opacity-50 mr-2 group-hover:text-cisa-accent"></i>
                                        Peer Review
                                    </a>
                                </li>
                            @endif
                            @if($journal->open_access_policy)
                                <li>
                                    <a href="#open-access"
                                        class="flex items-center text-gray-600 hover:text-cisa-accent transition-colors group">
                                        <i
                                            class="fas fa-chevron-right text-xs opacity-50 mr-2 group-hover:text-cisa-accent"></i>
                                        Open Access
                                    </a>
                                </li>
                            @endif
                            @if($journal->copyright_notice)
                                <li>
                                    <a href="#copyright"
                                        class="flex items-center text-gray-600 hover:text-cisa-accent transition-colors group">
                                        <i
                                            class="fas fa-chevron-right text-xs opacity-50 mr-2 group-hover:text-cisa-accent"></i>
                                        Copyright
                                    </a>
                                </li>
                            @endif
                            @if($journal->privacy_statement)
                                <li>
                                    <a href="#privacy"
                                        class="flex items-center text-gray-600 hover:text-cisa-accent transition-colors group">
                                        <i
                                            class="fas fa-chevron-right text-xs opacity-50 mr-2 group-hover:text-cisa-accent"></i>
                                        Privacy
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>

                <!-- Content Area -->
                <div class="lg:col-span-3 space-y-12">
                    <!-- Focus & Scope -->
                    @if($journal->focus_scope)
                        <section id="focus-scope" class="bg-white rounded-xl border border-gray-100 p-8 shadow-sm">
                            <div class="flex items-center mb-6">
                                <span class="w-1 h-8 bg-cisa-accent mr-3 rounded-full"></span>
                                <h2 class="text-2xl font-serif font-bold text-cisa-base m-0">Focus & Scope</h2>
                            </div>
                            <div class="prose prose-lg max-w-none text-gray-700 font-sans leading-relaxed">
                                {!! $journal->focus_scope !!}
                            </div>
                        </section>
                    @endif

                    <!-- Publication Frequency -->
                    @if($journal->publication_frequency)
                        <section id="publication-frequency" class="bg-white rounded-xl border border-gray-100 p-8 shadow-sm">
                            <div class="flex items-center mb-6">
                                <span class="w-1 h-8 bg-cisa-accent mr-3 rounded-full"></span>
                                <h2 class="text-2xl font-serif font-bold text-cisa-base m-0">Publication Frequency</h2>
                            </div>
                            <div class="prose prose-lg max-w-none text-gray-700 font-sans leading-relaxed">
                                {!! $journal->publication_frequency !!}
                            </div>
                        </section>
                    @endif

                    <!-- Peer Review -->
                    @if($journal->peer_review_policy || $journal->peer_review_process)
                        <section id="peer-review" class="bg-white rounded-xl border border-gray-100 p-8 shadow-sm">
                            <div class="flex items-center mb-6">
                                <span class="w-1 h-8 bg-cisa-accent mr-3 rounded-full"></span>
                                <h2 class="text-2xl font-serif font-bold text-cisa-base m-0">Peer Review Process</h2>
                            </div>
                            <div class="prose prose-lg max-w-none text-gray-700 font-sans leading-relaxed space-y-6">
                                @if($journal->peer_review_policy)
                                    <div>
                                        <h3 class="font-bold text-lg text-cisa-base mb-2">Policy</h3>
                                        {!! $journal->peer_review_policy !!}
                                    </div>
                                @endif
                                @if($journal->peer_review_process)
                                    <div>
                                        <h3 class="font-bold text-lg text-cisa-base mb-2">Process</h3>
                                        {!! $journal->peer_review_process !!}
                                    </div>
                                @endif
                            </div>
                        </section>
                    @endif

                    <!-- Open Access -->
                    @if($journal->open_access_policy)
                        <section id="open-access" class="bg-white rounded-xl border border-gray-100 p-8 shadow-sm">
                            <div class="flex items-center mb-6">
                                <span class="w-1 h-8 bg-cisa-accent mr-3 rounded-full"></span>
                                <h2 class="text-2xl font-serif font-bold text-cisa-base m-0">Open Access Policy</h2>
                            </div>
                            <div class="prose prose-lg max-w-none text-gray-700 font-sans leading-relaxed">
                                {!! $journal->open_access_policy !!}
                            </div>
                        </section>
                    @endif

                    <!-- Copyright -->
                    @if($journal->copyright_notice)
                        <section id="copyright" class="bg-white rounded-xl border border-gray-100 p-8 shadow-sm">
                            <div class="flex items-center mb-6">
                                <span class="w-1 h-8 bg-cisa-accent mr-3 rounded-full"></span>
                                <h2 class="text-2xl font-serif font-bold text-cisa-base m-0">Copyright Notice</h2>
                            </div>
                            <div class="prose prose-lg max-w-none text-gray-700 font-sans leading-relaxed">
                                {!! nl2br(e($journal->copyright_notice)) !!}
                            </div>
                        </section>
                    @endif

                    <!-- Privacy -->
                    @if($journal->privacy_statement)
                        <section id="privacy" class="bg-white rounded-xl border border-gray-100 p-8 shadow-sm">
                            <div class="flex items-center mb-6">
                                <span class="w-1 h-8 bg-cisa-accent mr-3 rounded-full"></span>
                                <h2 class="text-2xl font-serif font-bold text-cisa-base m-0">Privacy Statement</h2>
                            </div>
                            <div class="prose prose-lg max-w-none text-gray-700 font-sans leading-relaxed">
                                {!! $journal->privacy_statement !!}
                            </div>
                        </section>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection