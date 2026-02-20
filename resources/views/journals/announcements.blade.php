@extends('layouts.app')

@section('title', $journal->name . ' - Announcements')

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
                <li class="text-white">Announcements</li>
            </ol>
        </nav>
        
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4" style="font-family: 'Playfair Display', serif; font-weight: 700; letter-spacing: 0.03em; line-height: 1.2;">
                Announcements
            </h1>
            <p class="text-xl text-blue-100 max-w-2xl mx-auto" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.6;">
                Stay updated with the latest news and updates from {{ $journal->name }}
            </p>
        </div>
    </div>
</section>

<!-- Announcements Content -->
<section class="bg-[#F7F9FC] py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="space-y-6">
            @forelse($announcements as $announcement)
                <div class="bg-white rounded-xl border-2 border-gray-200 hover:border-[#0056FF] hover:shadow-xl transition-all duration-300 p-8">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-16 h-16 rounded-lg flex items-center justify-center flex-shrink-0
                            @if($announcement->type === 'call_for_papers') bg-blue-100 text-blue-600
                            @elseif($announcement->type === 'new_issue') bg-green-100 text-green-600
                            @elseif($announcement->type === 'maintenance') bg-red-100 text-red-600
                            @else bg-orange-100 text-orange-600
                            @endif">
                            @if($announcement->type === 'call_for_papers')
                                <i class="fas fa-bullhorn text-2xl"></i>
                            @elseif($announcement->type === 'new_issue')
                                <i class="fas fa-book text-2xl"></i>
                            @elseif($announcement->type === 'maintenance')
                                <i class="fas fa-tools text-2xl"></i>
                            @else
                                <i class="fas fa-star text-2xl"></i>
                            @endif
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-2xl font-bold text-[#0F1B4C]" style="font-family: 'Playfair Display', serif; font-weight: 700;">
                                    {{ $announcement->title }}
                                </h3>
                                @if($announcement->published_at)
                                    <span class="text-sm text-gray-500" style="font-family: 'Inter', sans-serif; font-weight: 400;">
                                        {{ \Carbon\Carbon::parse($announcement->published_at)->format('M d, Y') }}
                                    </span>
                                @endif
                            </div>
                            @if($announcement->journal)
                                <p class="text-sm text-gray-500 mb-2" style="font-family: 'Inter', sans-serif; font-weight: 400;">
                                    <i class="fas fa-book mr-1"></i>{{ $announcement->journal->name }}
                                </p>
                            @else
                                <p class="text-sm text-gray-500 mb-2" style="font-family: 'Inter', sans-serif; font-weight: 400;">
                                    <i class="fas fa-globe mr-1"></i>Platform-Wide Announcement
                                </p>
                            @endif
                            <div class="text-gray-700 leading-relaxed prose max-w-none" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.8;">
                                {!! $announcement->content !!}
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl border-2 border-gray-200 p-12 text-center">
                    <i class="fas fa-bullhorn text-gray-400 text-6xl mb-4"></i>
                    <h3 class="text-2xl font-bold text-gray-700 mb-2" style="font-family: 'Playfair Display', serif; font-weight: 700;">
                        No Announcements Yet
                    </h3>
                    <p class="text-gray-600" style="font-family: 'Inter', sans-serif; font-weight: 400;">
                        Check back soon for updates and announcements.
                    </p>
                </div>
            @endforelse
        </div>
        
        @if($announcements->hasPages())
            <div class="mt-8">
                {{ $announcements->links() }}
            </div>
        @endif
    </div>
</section>
@endsection

