@extends('layouts.app')

@section('title', $submission->title . ' - ' . $journal->name)

@section('content')
    <!-- Article Hero Section -->
    <div class="relative bg-cisa-base text-white overflow-hidden min-h-[400px] flex items-center">
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
                    @if($submission->issue)
                        <li><i class="fas fa-chevron-right text-xs opacity-50"></i></li>
                        <li><a href="{{ route('journals.issue', [$journal, $submission->issue]) }}"
                                class="hover:text-cisa-accent transition-colors">Vol {{ $submission->issue->volume }}, No
                                {{ $submission->issue->issue_number }}</a></li>
                    @endif
                    <li><i class="fas fa-chevron-right text-xs opacity-50"></i></li>
                    <li class="text-white font-semibold">Article</li>
                </ol>
            </nav>

            <div class="max-w-4xl">
                <div class="flex flex-wrap gap-3 mb-6">
                    <span
                        class="bg-cisa-accent text-cisa-base px-3 py-1 rounded text-xs font-bold tracking-wider uppercase">
                        Open Access
                    </span>
                    <span
                        class="bg-blue-500/20 backdrop-blur-md border border-blue-400/30 text-blue-200 px-3 py-1 rounded text-xs font-semibold tracking-wider uppercase">
                        Research Article
                    </span>
                </div>

                <h1 class="text-3xl md:text-5xl font-serif font-bold leading-tight mb-6 text-white text-shadow-sm">
                    {{ $submission->title }}
                </h1>

                <div class="text-lg text-gray-200 mb-8 font-light">
                    @foreach($submission->authors as $author)
                        <span class="inline-block mr-4 mb-2">
                            <i class="far fa-user-circle mr-2 opacity-70"></i>
                            <span
                                class="font-medium border-b border-gray-500 hover:border-cisa-accent transition-colors cursor-pointer"
                                title="{{ $author->affiliation }}">{{ $author->full_name }}</span>
                        </span>
                    @endforeach
                </div>

                <div class="flex flex-wrap gap-6 text-sm text-gray-400 border-t border-white/10 pt-6">
                    <div>
                        <span
                            class="uppercase tracking-wider text-xs font-bold block mb-1 text-cisa-accent">Published</span>
                        {{ $submission->formatPublishedAt('M d, Y') }}
                    </div>
                    @if($submission->doi)
                        <div>
                            <span class="uppercase tracking-wider text-xs font-bold block mb-1 text-cisa-accent">DOI</span>
                            <a href="https://doi.org/{{ $submission->doi }}" target="_blank"
                                class="hover:text-white underline decoration-dotted">
                                {{ $submission->doi }}
                            </a>
                        </div>
                    @endif
                    <div>
                        <span class="uppercase tracking-wider text-xs font-bold block mb-1 text-cisa-accent">Views</span>
                        {{ number_format($submission->views_count ?? 0) }}
                    </div>
                    <div>
                        <span
                            class="uppercase tracking-wider text-xs font-bold block mb-1 text-cisa-accent">Downloads</span>
                        {{ number_format($submission->downloads_count ?? 0) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Layout -->
    <div class="bg-slate-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

                <!-- Left Column (Article Body) -->
                <div class="lg:col-span-2 space-y-10">

                    <!-- Abstract -->
                    @if($submission->abstract)
                        <section class="bg-white rounded-xl p-8 shadow-sm border border-gray-100">
                            <h2 class="text-2xl font-serif font-bold text-cisa-base mb-6 flex items-center">
                                <span class="w-1 h-8 bg-cisa-accent mr-3 rounded-full"></span>
                                Abstract
                            </h2>
                            <div class="prose prose-lg text-gray-700 max-w-none font-sans leading-relaxed text-justify">
                                {!! $submission->abstract !!}
                            </div>
                        </section>
                    @endif

                    <!-- Keywords -->
                    @if($submission->keywords)
                        <section class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Keywords</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach(explode(',', $submission->keywords) as $keyword)
                                    <a href="{{ route('journals.search', ['journal' => $journal, 'q' => trim($keyword)]) }}"
                                        class="bg-slate-100 hover:bg-cisa-base hover:text-white text-gray-600 px-4 py-2 rounded-full text-sm transition-all duration-300">
                                        {{ trim($keyword) }}
                                    </a>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    <!-- Full Text PDF CTA -->
                    @php
                        $pdfFile = $submission->files()->where('file_type', 'manuscript')->first();
                    @endphp
                    @if($pdfFile)
                        <section class="bg-cisa-base text-white rounded-xl p-8 shadow-lg relative overflow-hidden group">
                            <div
                                class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-cisa-accent rounded-full opacity-10 blur-3xl group-hover:opacity-20 transition-opacity duration-700">
                            </div>
                            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                                <div>
                                    <h3 class="text-2xl font-serif font-bold mb-2">Read Full Article</h3>
                                    <p class="text-gray-300 font-light">Read online or download the full text PDF.</p>
                                </div>
                                <div class="flex gap-4">
                                    <a href="{{ route('journals.article.view', ['journal' => $journal->slug, 'submission' => $submission->id]) }}"
                                        target="_blank"
                                        class="px-6 py-3 rounded-lg bg-white/10 hover:bg-white/20 text-white font-bold transition-all border border-white/20 flex items-center">
                                        <i class="fas fa-eye mr-2"></i> Read Online
                                    </a>
                                    <a href="{{ route('journals.article.download', ['journal' => $journal->slug, 'submission' => $submission->id]) }}"
                                        class="btn-cisa-primary px-8 py-4 shadow-xl hover:-translate-y-1 transition-transform flex items-center whitespace-nowrap">
                                        <i class="fas fa-file-pdf mr-3"></i> Download PDF
                                    </a>
                                </div>
                            </div>
                        </section>
                    @endif

                    <!-- References -->
                    @if($submission->references->count() > 0)
                        <section class="bg-white rounded-xl p-8 shadow-sm border border-gray-100">
                            <h2 class="text-2xl font-serif font-bold text-cisa-base mb-6 flex items-center">
                                <span class="w-1 h-8 bg-cisa-accent mr-3 rounded-full"></span>
                                References
                            </h2>
                            <div class="space-y-4">
                                @foreach($submission->references as $index => $reference)
                                    <div class="flex gap-4">
                                        <span class="text-gray-400 font-bold text-sm min-w-[20px]">{{ $index + 1 }}.</span>
                                        <p class="text-gray-600 text-sm leading-relaxed">
                                            {{ $reference->reference_text }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    @endif

                </div>

                <!-- Right Column (Sidebar) -->
                <div class="lg:col-span-1 space-y-8">

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-xl shadow-glass border border-gray-100 p-6 sticky top-24">
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Article Tools</h3>
                        <div class="space-y-3">
                            @if($pdfFile)
                                <a href="{{ route('journals.article.view', ['journal' => $journal->slug, 'submission' => $submission->id]) }}"
                                    target="_blank"
                                    class="flex items-center justify-between p-3 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition-colors group">
                                    <span class="font-medium text-sm flex items-center"><i class="fas fa-eye w-6"></i>
                                        Read Online</span>
                                    <i class="fas fa-external-link-alt text-xs opacity-50"></i>
                                </a>
                                <a href="{{ route('journals.article.download', ['journal' => $journal->slug, 'submission' => $submission->id]) }}"
                                    class="flex items-center justify-between p-3 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition-colors group">
                                    <span class="font-medium text-sm flex items-center"><i class="fas fa-file-pdf w-6"></i>
                                        Download PDF</span>
                                    <i class="fas fa-download text-xs opacity-50"></i>
                                </a>
                            @endif
                            <button onclick="window.print()"
                                class="w-full flex items-center justify-center p-3 bg-slate-50 text-gray-700 rounded-lg hover:bg-slate-100 transition-colors text-sm font-medium">
                                <i class="fas fa-print mr-2 text-gray-400"></i> Print Article
                            </button>
                        </div>

                        <div class="mt-6 pt-6 border-t border-gray-100">
                            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Cite content</h3>
                            <div class="grid grid-cols-3 gap-2">
                                <a href="{{ route('export.ris', $submission) }}"
                                    class="p-2 text-center bg-slate-50 rounded hover:bg-cisa-base hover:text-white transition-colors text-xs font-bold text-gray-600">RIS</a>
                                <a href="{{ route('export.bibtex', $submission) }}"
                                    class="p-2 text-center bg-slate-50 rounded hover:bg-cisa-base hover:text-white transition-colors text-xs font-bold text-gray-600">BibTeX</a>
                                <a href="{{ route('export.xml', $submission) }}"
                                    class="p-2 text-center bg-slate-50 rounded hover:bg-cisa-base hover:text-white transition-colors text-xs font-bold text-gray-600">XML</a>
                            </div>
                        </div>
                        <div class="mt-6 pt-6 border-t border-gray-100">
                            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Share</h3>
                            <div class="flex gap-2">
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($submission->title) }}"
                                    target="_blank"
                                    class="w-10 h-10 flex items-center justify-center bg-slate-100 hover:bg-[#1DA1F2] hover:text-white rounded-full transition-colors"><i
                                        class="fab fa-twitter"></i></a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                                    target="_blank"
                                    class="w-10 h-10 flex items-center justify-center bg-slate-100 hover:bg-[#4267B2] hover:text-white rounded-full transition-colors"><i
                                        class="fab fa-facebook-f"></i></a>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}"
                                    target="_blank"
                                    class="w-10 h-10 flex items-center justify-center bg-slate-100 hover:bg-[#0077b5] hover:text-white rounded-full transition-colors"><i
                                        class="fab fa-linkedin-in"></i></a>
                                <a href="mailto:?subject={{ urlencode($submission->title) }}&body={{ urlencode(request()->url()) }}"
                                    class="w-10 h-10 flex items-center justify-center bg-slate-100 hover:bg-gray-600 hover:text-white rounded-full transition-colors"><i
                                        class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    </div>

                    <!-- Copyright / License -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">License</h3>
                        <div class="flex items-start gap-4">
                            <i class="fab fa-creative-commons text-3xl text-gray-400"></i>
                            <p class="text-xs text-gray-500 leading-relaxed">
                                This work is licensed under a <a href="#" class="text-cisa-base underline">Creative Commons
                                    Attribution 4.0 International License</a>. Authors retain copyright and grant the
                                journal right of first publication.
                            </p>
                        </div>
                    </div>

                    <!-- Journal Info Small -->
                    <div class="bg-cisa-base rounded-xl p-6 text-white text-center">
                        <p class="text-sm opacity-80 mb-4">Published in</p>
                        <h3 class="font-bold font-serif text-lg mb-4">{{ $journal->name }}</h3>
                        <a href="{{ route('journals.show', $journal) }}"
                            class="btn-cisa-outline text-xs py-2 px-4 w-full">View
                            Journal</a>
                    </div>

                </div>
            </div>

            <!-- Bottom CTA -->
            <div class="mt-16 text-center border-t border-gray-100 pt-12">
                <h2 class="text-2xl font-serif font-bold text-cisa-base mb-6">Inspired by this research?</h2>
                <div class="flex justify-center gap-4">
                    <a href="{{ route('publish.index') }}" class="btn-cisa-primary">
                        Submit Your Manuscript
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection