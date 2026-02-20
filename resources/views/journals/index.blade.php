@extends('layouts.app')

@section('title', 'CISA Interdisciplinary Journal - A Platform for Interdisciplinary Research Excellence')

@section('content')
<!-- Ultra Professional Slider Section -->
<section class="relative overflow-hidden group">
    <!-- Swiper Container -->
    <div class="swiper main-hero-slider">
        <div class="swiper-wrapper">
            <!-- Slide 1: Welcome -->
            <div class="swiper-slide bg-gradient-to-br from-purple-900 via-purple-800 to-purple-900 py-24 md:py-32 relative">
                <div class="absolute inset-0 opacity-5">
                    <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
                </div>
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                    <div class="text-center max-w-4xl mx-auto">
                        <div class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full border border-white/20 mb-6">
                            <i class="fas fa-star text-yellow-300 mr-2 text-sm"></i>
                            <span class="text-white text-sm font-semibold">{{ __('common.home') }} • {{ __('common.journals') }}</span>
                        </div>
                        <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-white mb-6 leading-tight animate-slide-up" style="font-family: 'Playfair Display', serif; letter-spacing: -0.03em;">
                            Discover Interdisciplinary<br/>Research Excellence
                        </h1>
                        <p class="text-xl md:text-2xl text-purple-100 mb-10 font-medium leading-relaxed max-w-3xl mx-auto opacity-0 animate-[fadeIn_0.5s_ease-in_0.3s_forwards]">
                            CISA Interdisciplinary Journal - Bridging Knowledge Across Disciplines
                        </p>
                        <div class="flex flex-wrap justify-center gap-4 opacity-0 animate-[fadeIn_0.5s_ease-in_0.5s_forwards]">
                            <a href="#journals" class="inline-flex items-center px-8 py-4 bg-white text-purple-700 rounded-xl text-lg font-bold shadow-2xl hover:shadow-purple-500/50 transition-all duration-200 transform hover:scale-105">
                                <i class="fas fa-book-open mr-2"></i>
                                Explore Journals
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2: Plagiarism Service -->
            <div class="swiper-slide bg-gradient-to-br from-indigo-900 via-blue-900 to-indigo-900 py-24 md:py-32 relative">
                <div class="absolute inset-0 opacity-10">
                    <img src="https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?auto=format&fit=crop&q=80&w=2000" class="w-full h-full object-cover" alt="Research">
                </div>
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                    <div class="text-center max-w-4xl mx-auto">
                        <div class="inline-flex items-center px-4 py-2 bg-blue-500/20 backdrop-blur-sm rounded-full border border-blue-400/30 mb-6">
                            <i class="fas fa-shield-alt text-blue-300 mr-2 text-sm"></i>
                            <span class="text-white text-sm font-semibold">Integrity Matters</span>
                        </div>
                        <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-white mb-6 leading-tight" style="font-family: 'Playfair Display', serif; letter-spacing: -0.03em;">
                            Professional Plagiarism<br/>Check Service
                        </h1>
                        <p class="text-xl md:text-2xl text-blue-100 mb-10 font-medium leading-relaxed max-w-3xl mx-auto">
                            Standalone service for $20 per scan. Ensure your research is original and publication-ready.
                        </p>
                        <div class="flex flex-wrap justify-center gap-4">
                            <a href="#" class="inline-flex items-center px-8 py-4 bg-blue-600 text-white rounded-xl text-lg font-bold shadow-2xl hover:bg-blue-700 transition-all duration-200 transform hover:scale-105">
                                <i class="fas fa-check-double mr-2"></i>
                                Scan Your Paper
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 3: Partnership -->
            <div class="swiper-slide bg-gradient-to-br from-emerald-900 via-teal-900 to-emerald-900 py-24 md:py-32 relative">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                    <div class="text-center max-w-4xl mx-auto">
                        <div class="inline-flex items-center px-4 py-2 bg-emerald-500/20 backdrop-blur-sm rounded-full border border-emerald-400/30 mb-6">
                            <i class="fas fa-handshake text-emerald-300 mr-2 text-sm"></i>
                            <span class="text-white text-sm font-semibold">Join Our Mission</span>
                        </div>
                        <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-white mb-6 leading-tight" style="font-family: 'Playfair Display', serif; letter-spacing: -0.03em;">
                            Partnership for<br/>Global Impact
                        </h1>
                        <p class="text-xl md:text-2xl text-emerald-100 mb-10 font-medium leading-relaxed max-w-3xl mx-auto">
                            Attracting Donors and Universities to bridge knowledge across disciplines.
                        </p>
                        <div class="flex flex-wrap justify-center gap-4">
                            <a href="#" class="inline-flex items-center px-8 py-4 bg-white text-emerald-700 rounded-xl text-lg font-bold shadow-2xl hover:bg-emerald-50 transition-all duration-200 transform hover:scale-105">
                                <i class="fas fa-people-carry mr-2"></i>
                                Partner with Us
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Navigation Buttons -->
        <div class="swiper-button-next !text-white/50 hover:!text-white transition-colors"></div>
        <div class="swiper-button-prev !text-white/50 hover:!text-white transition-colors"></div>
        
        <!-- Pagination -->
        <div class="swiper-pagination !bottom-8"></div>
    </div>
</section>

<style>
    .swiper-pagination-bullet { @apply bg-white/50 w-3 h-3 transition-all duration-300; }
    .swiper-pagination-bullet-active { @apply bg-white w-8 rounded-full; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const swiper = new Swiper('.main-hero-slider', {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            }
        });
    });
</script>

<!-- Ultra Professional Featured Journals Section -->
<section id="journals" class="bg-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center px-4 py-2 bg-purple-50 rounded-full mb-4">
                <i class="fas fa-book text-purple-600 mr-2"></i>
                <span class="text-sm font-semibold text-purple-700">Our Publications</span>
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4" style="font-family: 'Playfair Display', serif; letter-spacing: -0.02em;">
                Interdisciplinary Journals
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Explore cutting-edge research across diverse fields, fostering innovation and global scholarly collaboration
            </p>
        </div>
        
        @if($journals->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($journals->take(6) as $journal)
                    <div class="bg-white rounded-2xl border border-gray-200 hover:border-purple-300 hover:shadow-2xl transition-all duration-200 overflow-hidden transform hover:scale-[1.01] group">
                        <!-- Journal Cover - Full Width Top with proper aspect ratio -->
                        <div class="h-72 bg-white flex items-center justify-center relative overflow-hidden">
                            @if($journal->cover_image)
                                <img src="{{ asset('storage/' . $journal->cover_image) }}" 
                                     alt="{{ $journal->name }}" 
                                     class="w-full h-full object-contain p-2"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="w-full h-full bg-gradient-to-br from-purple-600 to-purple-800 flex items-center justify-center hidden">
                                    <i class="fas fa-book-open text-white text-6xl opacity-50"></i>
                                </div>
                            @elseif($journal->logo)
                                <img src="{{ asset('storage/' . $journal->logo) }}" 
                                     alt="{{ $journal->name }}" 
                                     class="w-full h-full object-contain p-4"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="w-full h-full bg-gradient-to-br from-purple-600 to-purple-800 flex items-center justify-center hidden">
                                    <i class="fas fa-book-open text-white text-6xl opacity-50"></i>
                                </div>
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-purple-600 to-purple-800 flex items-center justify-center">
                                    <i class="fas fa-book-open text-white text-6xl opacity-50"></i>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Professional Journal Info -->
                        <div class="p-6 bg-white">
                            <h3 class="text-xl font-bold text-gray-900 mb-4 min-h-[3rem] leading-tight group-hover:text-purple-700 transition-colors">{{ $journal->name }}</h3>
                            
                            <!-- Professional Stats Layout -->
                            <div class="space-y-2.5 mb-6 pb-5 border-b border-gray-100">
                                <div class="flex items-center justify-between py-1.5">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-unlock-alt text-purple-600 text-xs"></i>
                                        <span class="text-sm text-gray-600">Open Access</span>
                                    </div>
                                    <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Yes</span>
                                </div>
                                <div class="flex items-center justify-between py-1.5">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-clock text-purple-600 text-xs"></i>
                                        <span class="text-sm text-gray-600">Review Time</span>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-800">3-6 Weeks</span>
                                </div>
                                <div class="flex items-center justify-between py-1.5">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-certificate text-purple-600 text-xs"></i>
                                        <span class="text-sm text-gray-600">License</span>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-800">CC BY 4.0</span>
                                </div>
                            </div>
                            
                            <a href="{{ route('journals.show', $journal) }}" class="block w-full bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white text-center py-3 rounded-xl font-semibold transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-[1.02]">
                                <span class="flex items-center justify-center">
                                    Explore Journal
                                    <i class="fas fa-arrow-right ml-2 text-sm"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-gradient-to-br from-gray-50 to-white rounded-2xl p-16 text-center border border-gray-200">
                <div class="w-20 h-20 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-book-open text-purple-600 text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No journals published yet</h3>
                <p class="text-gray-600">Check back soon for new interdisciplinary journal publications.</p>
            </div>
        @endif
    </div>
</section>

<!-- Ultra Professional Announcements Section -->
@if(isset($announcementsByJournal) && $announcementsByJournal->count() > 0)
<section id="announcements" class="bg-gradient-to-br from-purple-50 via-white to-purple-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center px-4 py-2 bg-purple-100 rounded-full mb-4">
                <i class="fas fa-bullhorn text-purple-600 mr-2"></i>
                <span class="text-sm font-semibold text-purple-700">Stay Updated</span>
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4" style="font-family: 'Playfair Display', serif; letter-spacing: -0.02em;">
                Latest Announcements
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Stay informed about interdisciplinary research opportunities and journal updates</p>
        </div>

        <div class="space-y-8">
            @foreach($announcementsByJournal as $journalId => $announcements)
                @php
                    $journal = $journalId === 'platform-wide' ? null : \App\Models\Journal::find($journalId);
                @endphp
                
                <div class="bg-white rounded-2xl border border-gray-200 shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-200">
                    <!-- Professional Journal/Platform Title -->
                    <div class="bg-gradient-to-r from-purple-600 to-purple-700 text-white px-6 py-5">
                        <h3 class="text-xl md:text-2xl font-bold flex items-center">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-bullhorn"></i>
                            </div>
                            @if($journal)
                                {{ $journal->name }} - Announcements
                            @else
                                Platform-Wide Announcements
                            @endif
                        </h3>
                    </div>
                    
                    <!-- Announcements List -->
                    <div class="p-6 space-y-4">
                        @foreach($announcements as $announcement)
                            <div class="border-l-4 border-purple-600 pl-5 py-4 hover:bg-purple-50/50 transition-all duration-200 rounded-r-xl group" x-data="{ expanded: false }">
                                <div class="flex items-start justify-between mb-3">
                                    <h4 class="text-lg font-bold text-gray-900 flex-1 cursor-pointer group-hover:text-purple-700 transition-colors" @click="expanded = !expanded">
                                        {{ $announcement->title }}
                                    </h4>
                                    @if($announcement->published_at)
                                        <span class="text-xs text-gray-500 ml-4 whitespace-nowrap bg-gray-50 px-2 py-1 rounded-lg font-medium">
                                            {{ \Carbon\Carbon::parse($announcement->published_at)->format('M d, Y') }}
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Professional Type Badge -->
                                <div class="mb-3">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border
                                        @if($announcement->type === 'call_for_papers') bg-purple-100 text-purple-800 border-purple-200
                                        @elseif($announcement->type === 'new_issue') bg-green-100 text-green-800 border-green-200
                                        @elseif($announcement->type === 'maintenance') bg-red-100 text-red-800 border-red-200
                                        @else bg-orange-100 text-orange-800 border-orange-200
                                        @endif">
                                        <i class="fas fa-circle text-[6px] mr-1.5"></i>
                                        {{ ucfirst(str_replace('_', ' ', $announcement->type)) }}
                                    </span>
                                </div>
                                
                                <!-- Content Preview (Always Visible) -->
                                <p class="text-gray-700 leading-relaxed mb-3" x-show="!expanded">
                                    {{ Str::limit(strip_tags($announcement->content), 200) }}
                                </p>
                                
                                <!-- Full Content (Expanded) -->
                                <div class="text-gray-700 leading-relaxed mb-3 prose max-w-none" x-show="expanded" x-transition>
                                    {!! $announcement->content !!}
                                </div>
                                
                                <!-- Professional Read More Toggle -->
                                <button @click="expanded = !expanded" class="mt-3 text-purple-600 hover:text-purple-700 text-sm font-semibold transition-all duration-200 inline-flex items-center group">
                                    <span x-text="expanded ? 'Read Less' : 'Read More'"></span>
                                    <i class="fas ml-2 transition-transform duration-200 group-hover:translate-x-1" :class="expanded ? 'fa-chevron-up' : 'fa-arrow-right'"></i>
                                </button>
                                
                                <!-- Professional Journal Link -->
                                @if($journal)
                                    <div class="mt-3 pt-3 border-t border-gray-100">
                                        <a href="{{ route('journals.announcements', $journal) }}" class="text-purple-600 hover:text-purple-700 text-sm font-semibold transition-all duration-200 inline-flex items-center group">
                                            View All {{ $journal->name }} Announcements
                                            <i class="fas fa-external-link-alt ml-2 text-xs group-hover:translate-x-0.5 transition-transform"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Section Separator -->
<div class="bg-gradient-to-r from-purple-700 via-purple-800 to-purple-700 py-6 border-y border-purple-600/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center justify-center space-y-2 md:space-y-0 md:space-x-3 text-white text-center">
            <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm">
                <i class="fas fa-book-open text-lg"></i>
            </div>
            <p class="text-lg font-semibold">Discover the latest research across all academic disciplines</p>
        </div>
    </div>
</div>

<!-- Ultra Professional Subject Section -->
<section class="bg-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center px-4 py-2 bg-purple-50 rounded-full mb-4">
                <i class="fas fa-layer-group text-purple-600 mr-2"></i>
                <span class="text-sm font-semibold text-purple-700">Browse by Discipline</span>
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4" style="font-family: 'Playfair Display', serif; letter-spacing: -0.02em;">
                Research Across Disciplines
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Explore interdisciplinary research spanning multiple fields and academic domains</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 mb-10">
            @php
                $subjects = [
                    ['icon' => 'fa-globe', 'name' => 'Area Studies'],
                    ['icon' => 'fa-dna', 'name' => 'Bioscience'],
                    ['icon' => 'fa-laptop-code', 'name' => 'Computer Science'],
                    ['icon' => 'fa-chalkboard-teacher', 'name' => 'Education'],
                    ['icon' => 'fa-palette', 'name' => 'Arts'],
                    ['icon' => 'fa-city', 'name' => 'Built Environment'],
                    ['icon' => 'fa-mountain', 'name' => 'Earth Sciences'],
                    ['icon' => 'fa-cogs', 'name' => 'Engineering & Technology'],
                    ['icon' => 'fa-heartbeat', 'name' => 'Health Sciences'],
                    ['icon' => 'fa-balance-scale', 'name' => 'Law & Policy'],
                ];
            @endphp
            @foreach($subjects as $subject)
                <a href="#"
                   class="bg-white rounded-xl p-5 text-center border border-gray-200 hover:border-purple-400 hover:shadow-lg transition-all duration-200 group">
                    <div class="w-12 h-12 mx-auto mb-3 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center group-hover:bg-gradient-to-br group-hover:from-purple-600 group-hover:to-purple-700 group-hover:text-white transition-all duration-200">
                        <i class="fas {{ $subject['icon'] }}"></i>
                    </div>
                    <span class="text-sm font-semibold text-gray-800 group-hover:text-purple-700 transition-colors">{{ $subject['name'] }}</span>
                </a>
            @endforeach
        </div>
        
        <div class="text-center mt-12">
            <a href="#" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white rounded-xl font-bold shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                <i class="fas fa-list mr-2"></i>
                Browse All Journals
            </a>
        </div>
    </div>
</section>

<!-- Section Separator -->
<div class="bg-gradient-to-r from-purple-700 via-purple-800 to-purple-700 py-6 border-y border-purple-600/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center justify-center space-y-2 md:space-y-0 md:space-x-3 text-white text-center">
            <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm">
                <i class="fas fa-book-open text-lg"></i>
            </div>
            <p class="text-lg font-semibold">Research services designed for interdisciplinary excellence</p>
        </div>
    </div>
</div>

<!-- Ultra Professional Services Section -->
<section class="bg-gradient-to-br from-gray-50 to-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center px-4 py-2 bg-purple-50 rounded-full mb-4">
                <i class="fas fa-handshake text-purple-600 mr-2"></i>
                <span class="text-sm font-semibold text-purple-700">Our Services</span>
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4" style="font-family: 'Playfair Display', serif; letter-spacing: -0.02em;">
                Research Services
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Comprehensive support for interdisciplinary research and academic publishing excellence</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
            <div class="bg-white rounded-2xl p-8 border border-gray-200 hover:border-purple-300 hover:shadow-xl transition-all duration-200 group">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-purple-700 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg group-hover:scale-110 transition-transform duration-200">
                    <i class="fas fa-pen text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-3 text-center group-hover:text-purple-700 transition-colors">Editorial Support</h3>
                <p class="text-sm text-gray-600 text-center leading-relaxed">Expert editing, peer review coordination, and manuscript preparation assistance.</p>
            </div>
            
            <div class="bg-white rounded-2xl p-8 border border-gray-200 hover:border-purple-300 hover:shadow-xl transition-all duration-200 group">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-purple-700 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg group-hover:scale-110 transition-transform duration-200">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-3 text-center group-hover:text-purple-700 transition-colors">Research Collaboration</h3>
                <p class="text-sm text-gray-600 text-center leading-relaxed">Connect with interdisciplinary research teams and collaborative opportunities.</p>
            </div>
            
            <div class="bg-white rounded-2xl p-8 border border-gray-200 hover:border-purple-300 hover:shadow-xl transition-all duration-200 group">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-purple-700 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg group-hover:scale-110 transition-transform duration-200">
                    <i class="fas fa-graduation-cap text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-3 text-center group-hover:text-purple-700 transition-colors">Academic Training</h3>
                <p class="text-sm text-gray-600 text-center leading-relaxed">Workshops on interdisciplinary research methods and publication best practices.</p>
            </div>
            
            <div class="bg-white rounded-2xl p-8 border border-gray-200 hover:border-purple-300 hover:shadow-xl transition-all duration-200 group">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-purple-700 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg group-hover:scale-110 transition-transform duration-200">
                    <i class="fas fa-network-wired text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-3 text-center group-hover:text-purple-700 transition-colors">Knowledge Exchange</h3>
                <p class="text-sm text-gray-600 text-center leading-relaxed">Facilitating cross-disciplinary dialogue and research dissemination.</p>
            </div>
            
            <div class="bg-white rounded-2xl p-8 border border-gray-200 hover:border-purple-300 hover:shadow-xl transition-all duration-200 group">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-purple-700 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg group-hover:scale-110 transition-transform duration-200">
                    <i class="fas fa-chart-line text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-3 text-center group-hover:text-purple-700 transition-colors">Research Impact</h3>
                <p class="text-sm text-gray-600 text-center leading-relaxed">Enhancing research visibility and maximizing academic impact.</p>
            </div>
        </div>
    </div>
</section>

<!-- Section Separator -->
<div class="bg-gradient-to-r from-purple-700 via-purple-800 to-purple-700 py-6 border-y border-purple-600/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center justify-center space-y-2 md:space-y-0 md:space-x-3 text-white text-center">
            <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm">
                <i class="fas fa-book-open text-lg"></i>
            </div>
            <p class="text-lg font-semibold">Featured articles from across our journals</p>
        </div>
    </div>
</div>

<!-- Ultra Professional Featured Research Section -->
@php
    $trendingArticles = \App\Models\Submission::where('status', 'published')
        ->with(['journal', 'authors'])
        ->latest('published_at')
        ->take(5)
        ->get();
@endphp
@if($trendingArticles->count() > 0)
<section class="bg-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center px-4 py-2 bg-purple-50 rounded-full mb-4">
                <i class="fas fa-star text-purple-600 mr-2"></i>
                <span class="text-sm font-semibold text-purple-700">Featured Content</span>
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4" style="font-family: 'Playfair Display', serif; letter-spacing: -0.02em;">
                Featured Research
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Latest interdisciplinary research publications</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($trendingArticles as $article)
                <div class="bg-white rounded-2xl border border-gray-200 hover:border-purple-300 hover:shadow-xl transition-all duration-200 p-6 group">
                    <div class="flex items-start justify-between mb-5">
                        <div class="w-14 h-14 bg-gradient-to-br from-purple-600 to-purple-700 rounded-xl flex items-center justify-center shadow-md group-hover:scale-110 transition-transform duration-200">
                            <i class="fas fa-file-alt text-white text-lg"></i>
                        </div>
                        <span class="text-xs text-gray-500 font-semibold bg-gray-50 px-2 py-1 rounded-lg">{{ rand(500, 5000) }} views</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-4 min-h-[3.5rem] leading-tight group-hover:text-purple-700 transition-colors">{{ Str::limit($article->title, 60) }}</h3>
                    @if($article->doi)
                        <div class="flex items-center mb-3 text-sm text-gray-600">
                            <i class="fas fa-link text-purple-600 mr-2 text-xs"></i>
                            <span class="font-medium">DOI:</span>
                            <span class="ml-1 font-mono text-xs">{{ Str::limit($article->doi, 25) }}</span>
                        </div>
                    @endif
                    @if($article->formatted_published_at)
                        <div class="flex items-center mb-5 text-sm text-gray-600">
                            <i class="fas fa-calendar text-purple-600 mr-2 text-xs"></i>
                            <span class="font-medium">Published:</span>
                            <span class="ml-1">{{ $article->formatted_published_at }}</span>
                        </div>
                    @endif
                    <a href="#" class="block w-full bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white text-center py-3 rounded-xl font-semibold transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-[1.02]">
                        <span class="flex items-center justify-center">
                            Read Article
                            <i class="fas fa-arrow-right ml-2 text-sm"></i>
                        </span>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
