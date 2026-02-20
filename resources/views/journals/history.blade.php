@extends('layouts.app')

@section('title', $journal->name . ' - Journal History')

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
                <li class="text-white">Journal History</li>
            </ol>
        </nav>
        
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4" style="font-family: 'Playfair Display', serif; font-weight: 700; letter-spacing: 0.03em; line-height: 1.2;">
                Journal History
            </h1>
            <p class="text-xl text-blue-100 max-w-2xl mx-auto" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.6;">
                Learn about the history and milestones of {{ $journal->name }}
            </p>
        </div>
    </div>
</section>

<!-- Statistics -->
<section class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-[#F7F9FC] rounded-xl border-2 border-gray-200 p-8 text-center">
                <div class="w-16 h-16 bg-[#0056FF] rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-book text-white text-2xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-[#0056FF] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                    {{ $totalIssues }}
                </h3>
                <p class="text-gray-600 font-semibold" style="font-family: 'Inter', sans-serif; font-weight: 600;">
                    Published Issues
                </p>
            </div>

            <div class="bg-[#F7F9FC] rounded-xl border-2 border-gray-200 p-8 text-center">
                <div class="w-16 h-16 bg-[#0056FF] rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-file-alt text-white text-2xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-[#0056FF] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                    {{ $totalArticles }}
                </h3>
                <p class="text-gray-600 font-semibold" style="font-family: 'Inter', sans-serif; font-weight: 600;">
                    Published Articles
                </p>
            </div>

            @if($firstIssue)
            <div class="bg-[#F7F9FC] rounded-xl border-2 border-gray-200 p-8 text-center">
                <div class="w-16 h-16 bg-[#0056FF] rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-calendar-check text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-[#0056FF] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                    {{ $firstIssue->published_date ? $firstIssue->getFormattedPublishedDateAttribute('Y') : 'N/A' }}
                </h3>
                <p class="text-gray-600 font-semibold" style="font-family: 'Inter', sans-serif; font-weight: 600;">
                    First Issue
                </p>
            </div>
            @endif

            @if($latestIssue)
            <div class="bg-[#F7F9FC] rounded-xl border-2 border-gray-200 p-8 text-center">
                <div class="w-16 h-16 bg-[#0056FF] rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-calendar-star text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-[#0056FF] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                    {{ $latestIssue->published_date ? $latestIssue->getFormattedPublishedDateAttribute('Y') : 'N/A' }}
                </h3>
                <p class="text-gray-600 font-semibold" style="font-family: 'Inter', sans-serif; font-weight: 600;">
                    Latest Issue
                </p>
            </div>
            @endif
        </div>
    </div>
</section>

<!-- Journal Description -->
@if($journal->description)
<section class="bg-[#F7F9FC] py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl border-2 border-gray-200 p-8">
            <h2 class="text-2xl font-bold text-[#0F1B4C] mb-4" style="font-family: 'Playfair Display', serif; font-weight: 700;">
                <i class="fas fa-info-circle mr-3 text-[#0056FF]"></i>About {{ $journal->name }}
            </h2>
            <div class="prose max-w-none text-gray-700 leading-relaxed" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.8;">
                {!! $journal->description !!}
            </div>
        </div>
    </div>
</section>
@endif

<!-- Timeline -->
<section class="bg-white py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-[#0F1B4C] mb-4" style="font-family: 'Playfair Display', serif; font-weight: 700;">
                Publication Timeline
            </h2>
            <div class="w-24 h-1 bg-[#0056FF] mx-auto rounded-full"></div>
        </div>

        @if($firstIssue && $latestIssue)
        <div class="bg-[#F7F9FC] rounded-xl border-2 border-gray-200 p-8">
            <div class="flex items-center justify-between">
                <div class="text-center">
                    <div class="w-20 h-20 bg-[#0056FF] rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-flag text-white text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                        First Publication
                    </h3>
                    <p class="text-gray-600" style="font-family: 'Inter', sans-serif; font-weight: 400;">
                        {{ $firstIssue->published_date ? $firstIssue->getFormattedPublishedDateAttribute('F Y') : 'N/A' }}
                    </p>
                </div>
                <div class="flex-1 h-1 bg-[#0056FF] mx-4"></div>
                <div class="text-center">
                    <div class="w-20 h-20 bg-[#0056FF] rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-star text-white text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                        Latest Publication
                    </h3>
                    <p class="text-gray-600" style="font-family: 'Inter', sans-serif; font-weight: 400;">
                        {{ $latestIssue->published_date ? $latestIssue->getFormattedPublishedDateAttribute('F Y') : 'N/A' }}
                    </p>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

