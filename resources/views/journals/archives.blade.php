@extends('layouts.app')

@section('title', $journal->name . ' - Archives')

@section('content')
<!-- Hero Section -->
<section class="bg-[#0F1B4C] text-white py-20 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 20px 20px;"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center">
            <nav class="text-sm text-blue-200 mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2">
                    <li><a href="{{ route('journals.index') }}" class="hover:text-white transition-colors">Home</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li><a href="{{ route('journals.show', $journal) }}" class="hover:text-white transition-colors">{{ $journal->name }}</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li class="text-white">Archives</li>
                </ol>
            </nav>
            <h1 class="text-4xl md:text-5xl font-bold mb-4" style="font-family: 'Playfair Display', serif; font-weight: 700; letter-spacing: 0.03em; line-height: 1.2;">
                Archives
            </h1>
            <p class="text-xl text-blue-100 max-w-2xl mx-auto" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.6;">
                Browse all published issues of {{ $journal->name }}
            </p>
        </div>
    </div>
</section>

<!-- View Toggle -->
<section class="bg-white border-b-2 border-gray-200 sticky top-0 z-10 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex flex-wrap gap-3 justify-center">
            <a href="{{ route('journals.archives', ['journal' => $journal, 'view' => 'year']) }}" 
               class="px-6 py-2 rounded-lg font-semibold transition-all {{ $view === 'year' ? 'bg-[#0056FF] text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
               style="font-family: 'Inter', sans-serif; font-weight: 600;">
                <i class="fas fa-calendar-alt mr-2"></i>Year-wise
            </a>
            <a href="{{ route('journals.archives', ['journal' => $journal, 'view' => 'volume']) }}" 
               class="px-6 py-2 rounded-lg font-semibold transition-all {{ $view === 'volume' ? 'bg-[#0056FF] text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
               style="font-family: 'Inter', sans-serif; font-weight: 600;">
                <i class="fas fa-book mr-2"></i>Volume-wise
            </a>
            <a href="{{ route('journals.archives', ['journal' => $journal, 'view' => 'issue']) }}" 
               class="px-6 py-2 rounded-lg font-semibold transition-all {{ $view === 'issue' ? 'bg-[#0056FF] text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
               style="font-family: 'Inter', sans-serif; font-weight: 600;">
                <i class="fas fa-list mr-2"></i>Issue-wise
            </a>
        </div>
    </div>
</section>

<!-- Archives Content -->
<section class="bg-[#F7F9FC] py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($view === 'year')
            <!-- Year-wise View -->
            <div class="space-y-8">
                @foreach($issuesByYear as $year => $yearIssues)
                    <div class="bg-white rounded-xl border-2 border-gray-200 shadow-lg overflow-hidden">
                        <div class="bg-[#0056FF] text-white px-8 py-4">
                            <h2 class="text-2xl font-bold" style="font-family: 'Playfair Display', serif; font-weight: 700;">
                                <i class="fas fa-calendar-alt mr-3"></i>{{ $year }}
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($yearIssues as $issue)
                                    <a href="{{ route('journals.issue', [$journal, $issue]) }}" 
                                       class="bg-[#F7F9FC] rounded-lg p-4 border-2 border-gray-200 hover:border-[#0056FF] hover:shadow-md transition-all duration-300">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-sm font-bold text-[#0056FF]" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                                Vol. {{ $issue->volume }}, No. {{ $issue->issue_number }}
                                            </span>
                                            @if($issue->published_date)
                                                <span class="text-xs text-gray-500">{{ $issue->formatted_published_date }}</span>
                                            @endif
                                        </div>
                                        <h3 class="font-semibold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 600;">
                                            {{ $issue->display_title }}
                                        </h3>
                                        @php
                                            $articleCount = $issue->submissions()->where('status', 'published')->count();
                                        @endphp
                                        <p class="text-xs text-gray-600">
                                            <i class="fas fa-file-alt mr-1"></i>{{ $articleCount }} {{ Str::plural('Article', $articleCount) }}
                                        </p>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        @elseif($view === 'volume')
            <!-- Volume-wise View -->
            <div class="space-y-8">
                @foreach($issuesByVolume as $volume => $volumeIssues)
                    <div class="bg-white rounded-xl border-2 border-gray-200 shadow-lg overflow-hidden">
                        <div class="bg-[#0056FF] text-white px-8 py-4">
                            <h2 class="text-2xl font-bold" style="font-family: 'Playfair Display', serif; font-weight: 700;">
                                <i class="fas fa-book mr-3"></i>Volume {{ $volume }}
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($volumeIssues as $issue)
                                    <a href="{{ route('journals.issue', [$journal, $issue]) }}" 
                                       class="bg-[#F7F9FC] rounded-lg p-4 border-2 border-gray-200 hover:border-[#0056FF] hover:shadow-md transition-all duration-300">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-sm font-bold text-[#0056FF]" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                                Issue {{ $issue->issue_number }} ({{ $issue->year }})
                                            </span>
                                            @if($issue->published_date)
                                                <span class="text-xs text-gray-500">{{ $issue->formatted_published_date }}</span>
                                            @endif
                                        </div>
                                        <h3 class="font-semibold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 600;">
                                            {{ $issue->display_title }}
                                        </h3>
                                        @php
                                            $articleCount = $issue->submissions()->where('status', 'published')->count();
                                        @endphp
                                        <p class="text-xs text-gray-600">
                                            <i class="fas fa-file-alt mr-1"></i>{{ $articleCount }} {{ Str::plural('Article', $articleCount) }}
                                        </p>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        @else
            <!-- Issue-wise View (List) -->
            <div class="bg-white rounded-xl border-2 border-gray-200 shadow-lg overflow-hidden">
                <div class="bg-[#0056FF] text-white px-8 py-4">
                    <h2 class="text-2xl font-bold" style="font-family: 'Playfair Display', serif; font-weight: 700;">
                        <i class="fas fa-list mr-3"></i>All Issues
                    </h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($issues as $issue)
                            <a href="{{ route('journals.issue', [$journal, $issue]) }}" 
                               class="block bg-[#F7F9FC] rounded-lg p-6 border-2 border-gray-200 hover:border-[#0056FF] hover:shadow-md transition-all duration-300">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-4 mb-2">
                                            <span class="bg-[#0056FF] text-white px-4 py-1 rounded-full text-sm font-bold" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                                Vol. {{ $issue->volume }}, No. {{ $issue->issue_number }} ({{ $issue->year }})
                                            </span>
                                            @if($issue->published_date)
                                                <span class="text-sm text-gray-600">
                                                    <i class="fas fa-calendar mr-1"></i>{{ $issue->getFormattedPublishedDateAttribute('F d, Y') }}
                                                </span>
                                            @endif
                                        </div>
                                        <h3 class="text-lg font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                            {{ $issue->display_title }}
                                        </h3>
                                        @if($issue->description)
                                            <p class="text-gray-600 text-sm mb-2">{{ Str::limit($issue->description, 150) }}</p>
                                        @endif
                                        @php
                                            $articleCount = $issue->submissions()->where('status', 'published')->count();
                                        @endphp
                                        <p class="text-sm text-gray-600">
                                            <i class="fas fa-file-alt mr-1"></i>{{ $articleCount }} {{ Str::plural('Article', $articleCount) }}
                                        </p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-arrow-right text-[#0056FF] text-xl"></i>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @if($issues->isEmpty())
            <div class="bg-white rounded-xl border-2 border-gray-200 p-12 text-center">
                <i class="fas fa-archive text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-2xl font-bold text-gray-700 mb-2" style="font-family: 'Playfair Display', serif; font-weight: 700;">
                    No Published Issues Yet
                </h3>
                <p class="text-gray-600" style="font-family: 'Inter', sans-serif; font-weight: 400;">
                    Check back soon for published issues.
                </p>
            </div>
        @endif
    </div>
</section>
@endsection

