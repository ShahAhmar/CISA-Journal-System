@extends('layouts.app')

@section('title', 'Journal Information - ' . $journal->name)

@section('content')
    <!-- Hero Section -->
    <div class="bg-cisa-base text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10">
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <h1 class="text-5xl md:text-6xl font-serif font-bold mb-6">Journal Identity</h1>
            <p class="text-xl text-gray-300 max-w-3xl leading-relaxed">
                Official specifications, indexing compliance, and standard publishing workflows for CISA Interdisciplinary
                Journal.
            </p>
        </div>
    </div>

    <!-- Content Section -->
    <div class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Verification Note -->
            <div class="mb-16 bg-cisa-accent/10 border-2 border-cisa-accent/20 p-8 rounded-3xl text-center">
                <p class="text-cisa-base text-xl font-serif font-bold">
                    <i class="fas fa-certificate mr-3"></i>
                    This page is for indexing, citation, and verification purposes.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-16">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-20">

                    <!-- Identity Specifications -->
                    <section id="identity">
                        <h2 class="text-3xl font-serif font-bold text-cisa-base mb-10 flex items-center">
                            <span class="w-1.5 h-8 bg-cisa-accent mr-4 rounded-full"></span>
                            Official Specifications
                        </h2>

                        <div
                            class="grid grid-cols-1 md:grid-cols-2 gap-px bg-gray-100 rounded-3xl overflow-hidden border border-gray-100 shadow-sm">
                            <div class="bg-white p-8">
                                <h4 class="text-xs uppercase tracking-widest text-cisa-muted font-bold mb-2">Formal Title
                                </h4>
                                <p class="text-lg font-serif font-bold text-cisa-base">{{ $journal->name }}</p>
                            </div>
                            <div class="bg-white p-8">
                                <h4 class="text-xs uppercase tracking-widest text-cisa-muted font-bold mb-2">Acronym</h4>
                                <p class="text-lg font-bold text-gray-800">CISA-CIJ</p>
                            </div>
                            <div class="bg-white p-8">
                                <h4 class="text-xs uppercase tracking-widest text-cisa-muted font-bold mb-2">Online ISSN
                                </h4>
                                <p class="text-lg font-mono font-bold text-gray-800">
                                    {{ $journal->online_issn ?: 'Not assigned yet' }}
                                </p>
                            </div>
                            <div class="bg-white p-8">
                                <h4 class="text-xs uppercase tracking-widest text-cisa-muted font-bold mb-2">Print ISSN
                                </h4>
                                <p class="text-lg font-mono font-bold text-gray-800">
                                    {{ $journal->print_issn ?: 'Not available' }}
                                </p>
                            </div>
                            <div class="bg-white p-8">
                                <h4 class="text-xs uppercase tracking-widest text-cisa-muted font-bold mb-2">Review Process
                                </h4>
                                <div class="text-lg font-bold text-gray-800">
                                    {!! $journal->peer_review_process ?: 'Not specified' !!}
                                </div>
                            </div>
                            <div class="bg-white p-8">
                                <h4 class="text-xs uppercase tracking-widest text-cisa-muted font-bold mb-2">Access Model
                                </h4>
                                <p class="text-lg font-bold text-gray-800 flex items-center">
                                    <i class="fas fa-unlock-alt text-cisa-accent mr-2"></i> Global Open Access
                                </p>
                            </div>
                            <div class="bg-white p-8">
                                <h4 class="text-xs uppercase tracking-widest text-cisa-muted font-bold mb-2">Frequency</h4>
                                <div class="text-lg font-bold text-gray-800">
                                    {!! $journal->publication_frequency ?: 'Not specified' !!}
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Publishing Workflow -->
                    <section id="workflow">
                        <h2 class="text-3xl font-serif font-bold text-cisa-base mb-10 flex items-center">
                            <span class="w-1.5 h-8 bg-cisa-accent mr-4 rounded-full"></span>
                            Publishing Workflow
                        </h2>

                        <div class="space-y-4">
                            <!-- Step 1 -->
                            <div class="flex gap-6 group">
                                <div class="shrink-0">
                                    <div
                                        class="w-12 h-12 bg-cisa-base text-cisa-accent font-bold rounded-2xl flex items-center justify-center text-xl shadow-lg group-hover:bg-cisa-accent group-hover:text-cisa-base transition-colors">
                                        1</div>
                                </div>
                                <div class="pb-8 border-b border-gray-100 w-full">
                                    <h3 class="text-xl font-bold text-cisa-base mb-2">Submission & Screening</h3>
                                    <p class="text-gray-600 leading-relaxed">Manuscript submission via portal, followed by
                                        rigorous internal screening for scope, originality, and basic technical adherence.
                                    </p>
                                </div>
                            </div>
                            <!-- Step 2 -->
                            <div class="flex gap-6 group">
                                <div class="shrink-0">
                                    <div
                                        class="w-12 h-12 bg-slate-100 text-slate-400 font-bold rounded-2xl flex items-center justify-center text-xl group-hover:bg-cisa-base group-hover:text-white transition-colors">
                                        2</div>
                                </div>
                                <div class="pb-8 border-b border-gray-100 w-full">
                                    <h3 class="text-xl font-bold text-cisa-base mb-2">Expert Peer Review</h3>
                                    <p class="text-gray-600 leading-relaxed">Double-blind evaluation by at least two
                                        independent subject-matter experts to ensure scientific rigor and contribution.</p>
                                </div>
                            </div>
                            <!-- Step 3 -->
                            <div class="flex gap-6 group">
                                <div class="shrink-0">
                                    <div
                                        class="w-12 h-12 bg-slate-100 text-slate-400 font-bold rounded-2xl flex items-center justify-center text-xl group-hover:bg-cisa-base group-hover:text-white transition-colors">
                                        3</div>
                                </div>
                                <div class="pb-8 border-b border-gray-100 w-full">
                                    <h3 class="text-xl font-bold text-cisa-base mb-2">Editorial Decision</h3>
                                    <p class="text-gray-600 leading-relaxed">Final synthesis of reviewer comments by Section
                                        Editors followed by formal acceptance, revision request, or rejection.</p>
                                </div>
                            </div>
                            <!-- Step 4 -->
                            <div class="flex gap-6 group">
                                <div class="shrink-0">
                                    <div
                                        class="w-12 h-12 bg-slate-100 text-slate-400 font-bold rounded-2xl flex items-center justify-center text-xl group-hover:bg-cisa-accent group-hover:text-cisa-base transition-colors">
                                        4</div>
                                </div>
                                <div class="w-full">
                                    <h3 class="text-xl font-bold text-cisa-base mb-2">Production & Release</h3>
                                    <p class="text-gray-600 leading-relaxed">Professional copyediting, layout design, DOI
                                        assignment, and immediate open-access publication on the CIJ platform.</p>
                                </div>
                            </div>
                        </div>
                    </section>

                </div>

                <!-- Sidebar / CTAs -->
                <div class="lg:col-span-1">
                    <div class="sticky top-24 space-y-8">
                        <!-- Browse CTA -->
                        <div class="bg-cisa-base text-white p-10 rounded-3xl shadow-2xl relative overflow-hidden group">
                            <div
                                class="absolute inset-0 bg-gradient-to-br from-cisa-base to-cisa-light opacity-0 group-hover:opacity-100 transition-opacity">
                            </div>
                            <div class="relative z-10">
                                <h3 class="text-2xl font-serif font-bold mb-4">Validate Research</h3>
                                <p class="text-gray-300 text-sm mb-8 leading-relaxed">View all published papers to verify
                                    citations and indexing metadata.</p>
                                <a href="{{ route('journals.publications', $journal) }}"
                                    class="w-full block text-center bg-white text-cisa-base font-bold py-4 rounded-full hover:bg-cisa-accent hover:text-cisa-base transition-all shadow-xl">
                                    Browse Publications
                                </a>
                            </div>
                        </div>

                        <!-- Submit CTA -->
                        <div class="bg-slate-50 p-10 rounded-3xl border border-slate-100 shadow-sm space-y-6">
                            <h3 class="text-2xl font-serif font-bold text-cisa-base">Contribute</h3>
                            <p class="text-gray-600 text-sm leading-relaxed">Start your submission process to be included in
                                our next indexed compilation.</p>
                            <a href="{{ route('author.submissions.create', $journal) }}"
                                class="w-full block text-center bg-cisa-accent text-cisa-base font-bold py-4 rounded-full hover:bg-cisa-base hover:text-white transition-all shadow-lg shadow-cisa-accent/20">
                                Submit Your Manuscript
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection