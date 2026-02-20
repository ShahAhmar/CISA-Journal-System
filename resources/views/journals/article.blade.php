@extends('layouts.app')

@section('title', $submission->title . ' - ' . $journal->name)

@section('content')
<!-- Hero Section -->
<section class="bg-[#0F1B4C] text-white py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 20px 20px;"></div>
    </div>
    
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <nav class="text-sm text-blue-200 mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-2">
                <li><a href="{{ route('journals.index') }}" class="hover:text-white transition-colors">Home</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li><a href="{{ route('journals.show', $journal) }}" class="hover:text-white transition-colors">{{ $journal->name }}</a></li>
                @if($submission->issue)
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li><a href="{{ route('journals.issue', [$journal, $submission->issue]) }}" class="hover:text-white transition-colors">{{ $submission->issue->display_title }}</a></li>
                @endif
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li class="text-white">Article</li>
            </ol>
        </nav>
        
        <h1 class="text-3xl md:text-4xl font-bold mb-6 leading-tight" style="font-family: 'Playfair Display', serif; font-weight: 700; letter-spacing: 0.02em; line-height: 1.3;">
            {{ $submission->title }}
        </h1>
        
        <div class="flex flex-wrap items-center gap-6 text-blue-100">
            @if($submission->authors->count() > 0)
                <div>
                    <i class="fas fa-user-edit mr-2"></i>
                    <span style="font-family: 'Inter', sans-serif; font-weight: 500;">
                        @foreach($submission->authors as $author)
                            {{ $author->full_name }}@if(!$loop->last), @endif
                        @endforeach
                    </span>
                </div>
            @endif
            @if($submission->formatted_published_at)
                <div>
                    <i class="fas fa-calendar-alt mr-2"></i>
                    <span style="font-family: 'Inter', sans-serif; font-weight: 500;">Published: {{ $submission->formatted_published_at }}</span>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Article Content -->
<section class="bg-white py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Abstract -->
                @if($submission->abstract)
                <div class="bg-[#F7F9FC] rounded-xl border-2 border-gray-200 p-8">
                    <h2 class="text-2xl font-bold text-[#0F1B4C] mb-4 flex items-center" style="font-family: 'Playfair Display', serif; font-weight: 700;">
                        <i class="fas fa-file-alt mr-3 text-[#0056FF]"></i>Abstract
                    </h2>
                    <div class="prose max-w-none text-gray-700 leading-relaxed" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.8;">
                        {!! $submission->abstract !!}
                    </div>
                </div>
                @endif

                <!-- Keywords -->
                @if($submission->keywords)
                <div>
                    <h2 class="text-xl font-bold text-[#0F1B4C] mb-4" style="font-family: 'Playfair Display', serif; font-weight: 700;">
                        Keywords
                    </h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach(explode(',', $submission->keywords) as $keyword)
                            <span class="bg-[#0056FF] text-white px-4 py-2 rounded-full text-sm font-semibold" style="font-family: 'Inter', sans-serif; font-weight: 600;">
                                {{ trim($keyword) }}
                            </span>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Full Text PDF -->
                @php
                    $pdfFile = $submission->files()->where('file_type', 'manuscript')->first();
                @endphp
                @if($pdfFile)
                <div class="bg-[#F7F9FC] rounded-xl border-2 border-gray-200 p-8 text-center">
                    <div class="mb-6">
                        <i class="fas fa-file-pdf text-[#0056FF] text-6xl mb-4"></i>
                        <h2 class="text-2xl font-bold text-[#0F1B4C] mb-2" style="font-family: 'Playfair Display', serif; font-weight: 700;">
                            Full Article PDF
                        </h2>
                        <p class="text-gray-600" style="font-family: 'Inter', sans-serif; font-weight: 400;">
                            Download the complete article in PDF format
                        </p>
                    </div>
                    <a href="{{ route('journals.article.download', [$journal, $submission, 'pdf']) }}" 
                       class="inline-block bg-[#0056FF] hover:bg-[#0044CC] text-white px-8 py-4 rounded-lg font-bold text-lg transition-colors shadow-lg transform hover:scale-105"
                       style="font-family: 'Inter', sans-serif; font-weight: 700;">
                        <i class="fas fa-download mr-2"></i>Download PDF
                    </a>
                </div>
                @endif

                <!-- References -->
                @if($submission->references->count() > 0)
                <div>
                    <h2 class="text-2xl font-bold text-[#0F1B4C] mb-6" style="font-family: 'Playfair Display', serif; font-weight: 700;">
                        <i class="fas fa-book mr-3 text-[#0056FF]"></i>References
                    </h2>
                    <div class="space-y-3">
                        @foreach($submission->references as $reference)
                            <div class="bg-[#F7F9FC] rounded-lg p-4 border-l-4 border-[#0056FF]">
                                <p class="text-gray-700 leading-relaxed" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.7;">
                                    {{ $reference->reference_text }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Article Info -->
                <div class="bg-[#F7F9FC] rounded-xl border-2 border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-[#0F1B4C] mb-4" style="font-family: 'Playfair Display', serif; font-weight: 700;">
                        Article Information
                    </h3>
                    <dl class="space-y-3">
                        @if($submission->doi)
                        <div>
                            <dt class="text-sm font-bold text-gray-600 mb-1" style="font-family: 'Inter', sans-serif; font-weight: 700;">DOI</dt>
                            <dd class="text-[#0056FF] font-semibold" style="font-family: 'Inter', sans-serif; font-weight: 600;">
                                <a href="https://doi.org/{{ $submission->doi }}" target="_blank" class="hover:underline">
                                    {{ $submission->doi }}
                                </a>
                            </dd>
                        </div>
                        @endif
                        @if($submission->issue)
                        <div>
                            <dt class="text-sm font-bold text-gray-600 mb-1" style="font-family: 'Inter', sans-serif; font-weight: 700;">Issue</dt>
                            <dd class="text-gray-800" style="font-family: 'Inter', sans-serif; font-weight: 500;">
                                <a href="{{ route('journals.issue', [$journal, $submission->issue]) }}" class="hover:text-[#0056FF] transition-colors">
                                    {{ $submission->issue->display_title }}
                                </a>
                            </dd>
                        </div>
                        @endif
                        @if($submission->published_at)
                        <div>
                            <dt class="text-sm font-bold text-gray-600 mb-1" style="font-family: 'Inter', sans-serif; font-weight: 700;">Published Date</dt>
                            <dd class="text-gray-800" style="font-family: 'Inter', sans-serif; font-weight: 500;">
                                {{ $submission->published_at->format('F d, Y') }}
                            </dd>
                        </div>
                        @endif
                        @if($submission->page_start && $submission->page_end)
                        <div>
                            <dt class="text-sm font-bold text-gray-600 mb-1" style="font-family: 'Inter', sans-serif; font-weight: 700;">Pages</dt>
                            <dd class="text-gray-800" style="font-family: 'Inter', sans-serif; font-weight: 500;">
                                {{ $submission->page_start }}-{{ $submission->page_end }}
                            </dd>
                        </div>
                        @endif
                        <div>
                            <dt class="text-sm font-bold text-gray-600 mb-1" style="font-family: 'Inter', sans-serif; font-weight: 700;">Statistics</dt>
                            <dd class="text-gray-800" style="font-family: 'Inter', sans-serif; font-weight: 500;">
                                <div class="flex items-center space-x-4 mt-2">
                                    <span class="text-sm">
                                        <i class="fas fa-eye text-[#0056FF] mr-1"></i>{{ number_format($submission->views_count ?? 0) }} views
                                    </span>
                                    <span class="text-sm">
                                        <i class="fas fa-download text-green-600 mr-1"></i>{{ number_format($submission->downloads_count ?? 0) }} downloads
                                    </span>
                                </div>
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Export Metadata -->
                <div class="bg-[#F7F9FC] rounded-xl border-2 border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-[#0F1B4C] mb-4" style="font-family: 'Playfair Display', serif; font-weight: 700;">
                        <i class="fas fa-download mr-2 text-[#0056FF]"></i>Export Citation
                    </h3>
                    <div class="space-y-2">
                        <a href="{{ route('export.ris', $submission) }}" 
                           target="_blank"
                           class="block w-full bg-white hover:bg-gray-50 text-[#0056FF] border-2 border-[#0056FF] px-4 py-2 rounded-lg font-semibold transition-colors text-sm"
                           style="font-family: 'Inter', sans-serif; font-weight: 600;">
                            <i class="fas fa-file-alt mr-2"></i>RIS Format
                        </a>
                        <a href="{{ route('export.bibtex', $submission) }}" 
                           target="_blank"
                           class="block w-full bg-white hover:bg-gray-50 text-[#0056FF] border-2 border-[#0056FF] px-4 py-2 rounded-lg font-semibold transition-colors text-sm"
                           style="font-family: 'Inter', sans-serif; font-weight: 600;">
                            <i class="fas fa-file-code mr-2"></i>BibTeX Format
                        </a>
                        <a href="{{ route('export.xml', $submission) }}" 
                           target="_blank"
                           class="block w-full bg-white hover:bg-gray-50 text-[#0056FF] border-2 border-[#0056FF] px-4 py-2 rounded-lg font-semibold transition-colors text-sm"
                           style="font-family: 'Inter', sans-serif; font-weight: 600;">
                            <i class="fas fa-file-code mr-2"></i>XML (CrossRef)
                        </a>
                    </div>
                </div>

                <!-- Authors -->
                @if($submission->authors->count() > 0)
                <div class="bg-[#F7F9FC] rounded-xl border-2 border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-[#0F1B4C] mb-4" style="font-family: 'Playfair Display', serif; font-weight: 700;">
                        Authors
                    </h3>
                    <div class="space-y-3">
                        @foreach($submission->authors as $author)
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-[#0056FF] rounded-full flex items-center justify-center text-white font-bold">
                                    {{ strtoupper(substr($author->first_name ?? '', 0, 1) . substr($author->last_name ?? '', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-[#0F1B4C]" style="font-family: 'Inter', sans-serif; font-weight: 600;">
                                        {{ $author->full_name }}
                                    </p>
                                    @if($author->affiliation)
                                        <p class="text-xs text-gray-600" style="font-family: 'Inter', sans-serif; font-weight: 400;">
                                            {{ $author->affiliation }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Share -->
                <div class="bg-[#F7F9FC] rounded-xl border-2 border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-[#0F1B4C] mb-4" style="font-family: 'Playfair Display', serif; font-weight: 700;">
                        Share Article
                    </h3>
                    <div class="flex gap-3">
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($submission->title) }}" 
                           target="_blank"
                           class="flex-1 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-center font-semibold transition-colors"
                           style="font-family: 'Inter', sans-serif; font-weight: 600;">
                            <i class="fab fa-twitter mr-2"></i>Twitter
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                           target="_blank"
                           class="flex-1 bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg text-center font-semibold transition-colors"
                           style="font-family: 'Inter', sans-serif; font-weight: 600;">
                            <i class="fab fa-facebook mr-2"></i>Facebook
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

