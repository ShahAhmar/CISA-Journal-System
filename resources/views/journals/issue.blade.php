@extends('layouts.app')

@section('title', $journal->name . ' - ' . $issue->display_title)

@section('content')
<!-- Hero Section -->
<section class="bg-[#0F1B4C] text-white py-20 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 20px 20px;"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <nav class="text-sm text-blue-200 mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-2">
                <li><a href="{{ route('journals.index') }}" class="hover:text-white transition-colors">Home</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li><a href="{{ route('journals.show', $journal) }}" class="hover:text-white transition-colors">{{ $journal->name }}</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li><a href="{{ route('journals.issues', $journal) }}" class="hover:text-white transition-colors">Issues</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li class="text-white">{{ $issue->display_title }}</li>
            </ol>
        </nav>
        
        <div class="text-center">
            <div class="inline-block bg-white bg-opacity-20 backdrop-blur-sm px-6 py-2 rounded-full mb-6">
                <span class="text-lg font-bold" style="font-family: 'Inter', sans-serif; font-weight: 700; letter-spacing: 0.05em;">
                    Volume {{ $issue->volume }}, Issue {{ $issue->issue_number }} ({{ $issue->year }})
                </span>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold mb-4" style="font-family: 'Playfair Display', serif; font-weight: 700; letter-spacing: 0.03em; line-height: 1.2;">
                {{ $issue->display_title }}
            </h1>
            @if($issue->published_date)
                <p class="text-xl text-blue-100" style="font-family: 'Inter', sans-serif; font-weight: 400;">
                    <i class="fas fa-calendar-alt mr-2"></i>Published: {{ $issue->getFormattedPublishedDateAttribute('F d, Y') }}
                </p>
            @endif
        </div>
    </div>
</section>

<!-- Issue Description -->
@if($issue->description)
<section class="bg-white py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-[#F7F9FC] rounded-xl border-2 border-gray-200 p-8">
            <h2 class="text-2xl font-bold text-[#0F1B4C] mb-4" style="font-family: 'Playfair Display', serif; font-weight: 700;">
                <i class="fas fa-info-circle mr-3 text-[#0056FF]"></i>About This Issue
            </h2>
            <div class="prose max-w-none text-gray-700" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.8;">
                {!! nl2br(e($issue->description)) !!}
            </div>
        </div>
    </div>
</section>
@endif

<!-- Articles Section -->
<section class="bg-[#F7F9FC] py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl md:text-4xl font-bold text-[#0F1B4C]" style="font-family: 'Playfair Display', serif; font-weight: 700;">
                Articles <span class="text-[#0056FF]">({{ $articles->count() }})</span>
            </h2>
            <a href="{{ route('journals.archives', $journal) }}" 
               class="text-[#0056FF] hover:text-[#0044CC] font-semibold transition-colors"
               style="font-family: 'Inter', sans-serif; font-weight: 600;">
                <i class="fas fa-archive mr-2"></i>View All Issues
            </a>
        </div>

        @if($articles->count() > 0)
            <div class="space-y-6">
                @foreach($articles as $index => $article)
                    <div class="bg-white rounded-xl border-2 border-gray-200 hover:border-[#0056FF] hover:shadow-xl transition-all duration-300 p-8">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center text-white font-bold text-lg" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                    {{ $index + 1 }}
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-[#0F1B4C] mb-2 hover:text-[#0056FF] transition-colors" style="font-family: 'Inter', sans-serif; font-weight: 700; line-height: 1.3;">
                                        <a href="{{ route('journals.article', [$journal, $article]) }}">{{ $article->title }}</a>
                                    </h3>
                                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
                                        @if($article->authors->count() > 0)
                                            <div>
                                                <i class="fas fa-user-edit mr-1 text-[#0056FF]"></i>
                                                <span style="font-family: 'Inter', sans-serif; font-weight: 500;">
                                                    @foreach($article->authors as $author)
                                                        {{ $author->full_name }}@if(!$loop->last), @endif
                                                    @endforeach
                                                </span>
                                            </div>
                                        @endif
                                        @if($article->published_at)
                                            <div>
                                                <i class="fas fa-calendar mr-1 text-[#0056FF]"></i>
                                                <span style="font-family: 'Inter', sans-serif; font-weight: 500;">{{ $article->formatted_published_at ?? 'N/A' }}</span>
                                            </div>
                                        @endif
                                        @if($article->doi)
                                            <div>
                                                <i class="fas fa-fingerprint mr-1 text-[#0056FF]"></i>
                                                <span style="font-family: 'Inter', sans-serif; font-weight: 500;">DOI: {{ $article->doi }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($article->abstract)
                            <div class="mb-4">
                                <h4 class="text-sm font-bold text-gray-600 mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">Abstract</h4>
                                <p class="text-gray-700 leading-relaxed" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.7;">
                                    {{ Str::limit(strip_tags($article->abstract), 300) }}
                                </p>
                            </div>
                        @endif

                        @if($article->keywords)
                            <div class="mb-4">
                                <h4 class="text-sm font-bold text-gray-600 mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">Keywords</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach(explode(',', $article->keywords) as $keyword)
                                        <span class="bg-[#F7F9FC] text-[#0056FF] px-3 py-1 rounded-full text-xs font-semibold" style="font-family: 'Inter', sans-serif; font-weight: 600;">
                                            {{ trim($keyword) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="flex flex-wrap gap-3 pt-4 border-t border-gray-200">
                            <a href="{{ route('journals.article', [$journal, $article]) }}" 
                               class="bg-[#0056FF] hover:bg-[#0044CC] text-white px-6 py-2 rounded-lg font-semibold transition-colors"
                               style="font-family: 'Inter', sans-serif; font-weight: 600;">
                                <i class="fas fa-eye mr-2"></i>Read Full Article
                            </a>
                            @php
                                $pdfFile = $article->files()->where('file_type', 'manuscript')->first();
                            @endphp
                            @if($pdfFile)
                                <a href="{{ asset('storage/' . $pdfFile->file_path) }}" 
                                   target="_blank"
                                   class="bg-white hover:bg-gray-50 text-[#0056FF] border-2 border-[#0056FF] px-6 py-2 rounded-lg font-semibold transition-colors"
                                   style="font-family: 'Inter', sans-serif; font-weight: 600;">
                                    <i class="fas fa-file-pdf mr-2"></i>Download PDF
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-xl border-2 border-gray-200 p-12 text-center">
                <i class="fas fa-file-alt text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-2xl font-bold text-gray-700 mb-2" style="font-family: 'Playfair Display', serif; font-weight: 700;">
                    No Articles Published Yet
                </h3>
                <p class="text-gray-600" style="font-family: 'Inter', sans-serif; font-weight: 400;">
                    Articles will appear here once they are published.
                </p>
            </div>
        @endif
    </div>
</section>
@endsection
