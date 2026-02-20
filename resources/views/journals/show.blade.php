@extends('layouts.app')

@section('title', $journal->name . ' - CISA Interdisciplinary Journal')

@section('content')
<!-- Ultra Professional Hero Section -->
<section class="bg-gradient-to-br from-purple-900 via-purple-800 to-purple-900 text-white py-24 md:py-32 relative overflow-hidden">
    <!-- Professional Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
    </div>
    
    <!-- Gradient Overlay -->
    <div class="absolute inset-0 bg-gradient-to-t from-purple-900/50 to-transparent"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left Side - Ultra Professional Journal Info -->
            <div>
                <!-- Badge -->
                <div class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full border border-white/20 mb-6">
                    <i class="fas fa-book-open mr-2 text-sm"></i>
                    <span class="text-xs font-semibold uppercase tracking-wider">Interdisciplinary Journal</span>
                </div>
                
                <div class="mb-6">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-3 leading-tight" style="font-family: 'Playfair Display', serif; letter-spacing: -0.03em;">
                        {{ $journal->name }}
                    </h1>
                    @if($journal->issn)
                        <div class="flex items-center space-x-2 mt-3">
                            <span class="px-3 py-1 bg-white/10 backdrop-blur-sm rounded-lg text-xs font-semibold border border-white/20">
                                ISSN: {{ $journal->issn }}
                            </span>
                        </div>
                    @endif
                </div>
                
                @if($journal->description)
                    @php
                        $descriptionText = strip_tags($journal->description);
                        $shortDescription = Str::limit($descriptionText, 200);
                    @endphp
                    <div class="text-base md:text-lg text-purple-100 mb-6 leading-relaxed font-medium">
                        {{ $shortDescription }}
                    </div>
                    <a href="#full-description" 
                       class="inline-flex items-center px-6 py-3 bg-white/10 backdrop-blur-sm hover:bg-white/20 text-white rounded-xl font-semibold transition-all duration-200 mb-8 border border-white/30 hover:border-white/50">
                        <i class="fas fa-arrow-down mr-2"></i>Read More
                    </a>
                @else
                    <div class="text-base md:text-lg text-purple-100 mb-8 leading-relaxed font-medium">
                        A peer-reviewed, open-access interdisciplinary journal for academic excellence
                    </div>
                @endif
                
                <!-- Ultra Professional Search Bar -->
                <div class="mb-8">
                    <form action="{{ route('journals.search', $journal) }}" method="GET" class="flex shadow-2xl rounded-2xl overflow-hidden border-2 border-white/20 backdrop-blur-sm bg-white/10">
                        <input type="text" 
                               name="q"
                               placeholder="Search articles, authors, keywords..." 
                               class="flex-1 px-6 py-4 text-white placeholder-purple-200 bg-transparent focus:outline-none focus:bg-white/5 text-lg"
                               value="{{ request('q') }}"
                               style="font-family: 'Inter', sans-serif;">
                        <button type="submit" class="bg-white text-purple-700 px-8 py-4 font-bold hover:bg-purple-50 transition-all duration-200 flex items-center">
                            <i class="fas fa-search text-xl"></i>
                        </button>
                    </form>
                    <p class="text-sm text-purple-200 mt-3 text-center flex items-center justify-center">
                        <i class="fas fa-info-circle mr-2"></i>Search interdisciplinary research published in {{ $journal->name }}
                    </p>
                </div>
                
                <!-- Professional Key Attributes -->
                <div class="flex flex-wrap gap-3">
                    <span class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm rounded-xl text-sm border border-white/20 font-semibold">
                        <i class="fas fa-unlock-alt mr-2"></i>Open Access
                    </span>
                    <span class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm rounded-xl text-sm border border-white/20 font-semibold">
                        <i class="fas fa-clock mr-2"></i>3-6 Weeks Review
                    </span>
                    <span class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm rounded-xl text-sm border border-white/20 font-semibold">
                        <i class="fas fa-certificate mr-2"></i>CC BY 4.0
                    </span>
                </div>
            </div>
            
            <!-- Right Side - Professional Journal Cover -->
            <div class="flex items-center justify-center">
                @if($journal->cover_image)
                    <div class="relative group">
                        <img src="{{ asset('storage/' . $journal->cover_image) }}" 
                             alt="{{ $journal->name }} Cover" 
                             class="max-w-full h-auto max-h-96 lg:max-h-[500px] object-contain rounded-3xl shadow-2xl transform group-hover:scale-105 transition-transform duration-300 bg-white p-6"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="absolute inset-0 bg-gradient-to-t from-purple-900/20 to-transparent rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-16 h-80 lg:h-96 flex items-center justify-center max-w-md mx-auto border border-white/20 hidden">
                        <div class="text-center text-white">
                            <div class="w-20 h-20 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-book-open text-4xl opacity-50"></i>
                            </div>
                            <p class="font-semibold text-lg">Journal Cover</p>
                        </div>
                    </div>
                @else
                    <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-16 h-80 lg:h-96 flex items-center justify-center max-w-md mx-auto border border-white/20">
                        <div class="text-center text-white">
                            <div class="w-20 h-20 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-book-open text-4xl opacity-50"></i>
                            </div>
                            <p class="font-semibold text-lg">Journal Cover</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Decorative Bottom Gradient -->
    <div class="absolute bottom-0 left-0 right-0 h-20 bg-gradient-to-t from-white to-transparent"></div>
</section>

<!-- Action Buttons Section -->
<section class="bg-white shadow-xl -mt-8 relative z-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('author.submissions.create', $journal) }}" 
               class="bg-white rounded-xl p-6 border-2 border-gray-200 hover:border-[#0056FF] hover:shadow-xl transition-all duration-300 text-center transform hover:-translate-y-1">
                <div class="w-16 h-16 bg-[#0056FF] rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-file-upload text-white text-2xl"></i>
                </div>
                <h3 class="font-bold text-[#0F1B4C] text-lg" style="font-family: 'Inter', sans-serif; font-weight: 700; letter-spacing: -0.01em;">Submit Manuscript</h3>
            </a>
            <a href="{{ route('journals.issues', $journal) }}" 
               class="bg-white rounded-xl p-6 border-2 border-gray-200 hover:border-[#0056FF] hover:shadow-xl transition-all duration-300 text-center transform hover:-translate-y-1">
                <div class="w-16 h-16 bg-[#0056FF] rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-book text-white text-2xl"></i>
                </div>
                <h3 class="font-bold text-[#0F1B4C] text-lg" style="font-family: 'Inter', sans-serif; font-weight: 700; letter-spacing: -0.01em;">Browse Issues</h3>
            </a>
            <a href="{{ route('journals.editorial-board', $journal) }}" 
               class="bg-white rounded-xl p-6 border-2 border-gray-200 hover:border-[#0056FF] hover:shadow-xl transition-all duration-300 text-center transform hover:-translate-y-1">
                <div class="w-16 h-16 bg-[#0056FF] rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
                <h3 class="font-bold text-[#0F1B4C] text-lg" style="font-family: 'Inter', sans-serif; font-weight: 700; letter-spacing: -0.01em;">Editorial Board</h3>
            </a>
            <a href="{{ route('journals.contact', $journal) }}" 
               class="bg-white rounded-xl p-6 border-2 border-gray-200 hover:border-[#0056FF] hover:shadow-xl transition-all duration-300 text-center transform hover:-translate-y-1">
                <div class="w-16 h-16 bg-[#0056FF] rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-envelope text-white text-2xl"></i>
                </div>
                <h3 class="font-bold text-[#0F1B4C] text-lg" style="font-family: 'Inter', sans-serif; font-weight: 700; letter-spacing: -0.01em;">Contact Us</h3>
            </a>
        </div>
    </div>
</section>

<!-- Welcome Section -->
<section class="bg-white py-16" id="full-description">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-[#0F1B4C] mb-4" style="font-family: 'Playfair Display', serif; font-weight: 700; letter-spacing: -0.01em; line-height: 1.2;">
                Welcome to <span class="text-[#0056FF]">{{ $journal->name }}</span>
            </h2>
            <div class="w-24 h-1 bg-[#0056FF] mx-auto rounded-full"></div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left - Description -->
            <div>
                <div class="text-base text-gray-700 leading-relaxed mb-6" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.7; letter-spacing: -0.01em;">
                    {!! $journal->description ?? 'A peer-reviewed, open-access journal published by EMANP. This journal serves as a global platform for integrative research across various fields, fostering interdisciplinary collaboration and knowledge exchange.' !!}
                </div>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('journals.aims-scope', $journal) }}" 
                       class="btn bg-[#0056FF] hover:bg-[#0044CC] text-white px-6 py-3 rounded-lg font-semibold transition-colors shadow-lg">
                        <i class="fas fa-arrow-right mr-2"></i>Learn More
                    </a>
                    <a href="{{ route('author.submissions.create', $journal) }}" 
                       class="btn bg-white hover:bg-gray-50 text-[#0F1B4C] border-2 border-[#0F1B4C] px-6 py-3 rounded-lg font-semibold transition-colors">
                        <i class="fas fa-file-upload mr-2"></i>Submit Article
                    </a>
                </div>
            </div>
            
            <!-- Right - Feature Cards -->
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-[#F7F9FC] rounded-xl p-6 border-2 border-gray-200 hover:border-[#0056FF] hover:shadow-xl transition-all duration-300 text-center">
                    <div class="w-16 h-16 bg-[#0056FF] rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-check-double text-white text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700; letter-spacing: -0.01em;">Peer-Reviewed</h3>
                    <p class="text-sm text-gray-600" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.6;">Double blind peer review by independent experts</p>
                </div>
                <div class="bg-[#F7F9FC] rounded-xl p-6 border-2 border-gray-200 hover:border-[#0056FF] hover:shadow-xl transition-all duration-300 text-center">
                    <div class="w-16 h-16 bg-[#0056FF] rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-globe text-white text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700; letter-spacing: -0.01em;">Open Access</h3>
                    <p class="text-sm text-gray-600" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.6;">Free access under CC BY 4.0 license</p>
                </div>
                <div class="bg-[#F7F9FC] rounded-xl p-6 border-2 border-gray-200 hover:border-[#0056FF] hover:shadow-xl transition-all duration-300 text-center">
                    <div class="w-16 h-16 bg-[#0056FF] rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-bolt text-white text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700; letter-spacing: -0.01em;">Rapid Publication</h3>
                    <p class="text-sm text-gray-600" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.6;">Online first within 2 weeks of acceptance</p>
                </div>
                <div class="bg-[#F7F9FC] rounded-xl p-6 border-2 border-gray-200 hover:border-[#0056FF] hover:shadow-xl transition-all duration-300 text-center">
                    <div class="w-16 h-16 bg-[#0056FF] rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-link text-white text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700; letter-spacing: -0.01em;">Interdisciplinary</h3>
                    <p class="text-sm text-gray-600" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.6;">Bridging multiple fields of knowledge</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Announcements Section -->
@if($announcements && $announcements->count() > 0)
<section class="bg-[#F7F9FC] py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-[#0F1B4C] mb-4" style="font-family: 'Playfair Display', serif; font-weight: 700; letter-spacing: -0.01em; line-height: 1.2;">
                <span class="text-[#0056FF]">Announcements</span>
            </h2>
            <div class="w-24 h-1 bg-[#0056FF] mx-auto rounded-full"></div>
            <p class="text-lg text-gray-600 mt-4" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.7;">Stay updated with the latest news and updates</p>
        </div>
        
        <div class="space-y-4 max-w-4xl mx-auto">
            @foreach($announcements as $announcement)
                <div class="bg-white rounded-xl border-2 border-gray-200 hover:border-[#0056FF] hover:shadow-xl transition-all duration-300 p-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0
                            @if($announcement->type === 'call_for_papers') bg-blue-100 text-blue-600
                            @elseif($announcement->type === 'new_issue') bg-green-100 text-green-600
                            @elseif($announcement->type === 'maintenance') bg-red-100 text-red-600
                            @else bg-orange-100 text-orange-600
                            @endif">
                            @if($announcement->type === 'call_for_papers')
                                <i class="fas fa-bullhorn text-xl"></i>
                            @elseif($announcement->type === 'new_issue')
                                <i class="fas fa-book text-xl"></i>
                            @elseif($announcement->type === 'maintenance')
                                <i class="fas fa-tools text-xl"></i>
                            @else
                                <i class="fas fa-star text-xl"></i>
                            @endif
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-xl font-bold text-[#0F1B4C]" style="font-family: 'Playfair Display', serif; font-weight: 700;">
                                    {{ $announcement->title }}
                                </h3>
                                @if($announcement->published_at)
                                    <span class="text-sm text-gray-500" style="font-family: 'Inter', sans-serif; font-weight: 400;">
                                        {{ \Carbon\Carbon::parse($announcement->published_at)->format('M d, Y') }}
                                    </span>
                                @endif
                            </div>
                            <p class="text-gray-700 leading-relaxed mb-3" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.8;">
                                {{ Str::limit(strip_tags($announcement->content), 200) }}
                            </p>
                            <a href="{{ route('journals.announcements', $journal) }}" class="text-[#0056FF] hover:text-[#0044CC] text-sm font-semibold transition-colors">
                                Read More <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-8 text-center">
            <a href="{{ route('journals.announcements', $journal) }}" 
               class="btn bg-[#0056FF] hover:bg-[#0044CC] text-white px-8 py-3 rounded-lg font-semibold transition-colors shadow-lg">
                <i class="fas fa-bullhorn mr-2"></i>View All Announcements
            </a>
        </div>
    </div>
</section>
@endif

<!-- Aims & Scope Preview Section -->
@if($journal->focus_scope || $journal->aims_scope)
<section class="bg-[#F7F9FC] py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-[#0F1B4C] mb-4" style="font-family: 'Playfair Display', serif; font-weight: 700; letter-spacing: -0.01em; line-height: 1.2;">
                <span class="text-[#0056FF]">Aims & Scope</span>
            </h2>
            <div class="w-24 h-1 bg-[#0056FF] mx-auto rounded-full"></div>
            <p class="text-lg text-gray-600 mt-4" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.7;">{{ $journal->name }} welcomes manuscripts in the following areas:</p>
        </div>
        
        <div class="bg-white rounded-2xl shadow-xl border-2 border-gray-100 p-8 md:p-12 max-w-5xl mx-auto">
            <div class="prose max-w-none">
                @php
                    $content = $journal->focus_scope ?? $journal->aims_scope;
                    $preview = strip_tags($content);
                    $preview = Str::limit($preview, 500);
                @endphp
                <div class="text-gray-800 leading-relaxed line-clamp-6">
                    {!! $preview !!}
                </div>
            </div>
            <div class="mt-8 text-center">
                <a href="{{ route('journals.aims-scope', $journal) }}" 
                   class="btn bg-[#0056FF] hover:bg-[#0044CC] text-white px-8 py-3 rounded-lg font-semibold transition-colors shadow-lg">
                    <i class="fas fa-file-alt mr-2"></i>View Full Aims & Scope
                </a>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Explore Section -->
<section class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-[#0F1B4C] mb-4" style="font-family: 'Playfair Display', serif; font-weight: 700; letter-spacing: -0.01em; line-height: 1.2;">
                Explore <span class="text-[#0056FF]">{{ $journal->name }}</span>
            </h2>
            <div class="w-24 h-1 bg-[#0056FF] mx-auto rounded-full"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            <a href="{{ route('journals.aims-scope', $journal) }}" 
               class="bg-white rounded-xl p-8 border-2 border-gray-200 hover:border-[#0056FF] hover:shadow-xl transition-all duration-300 text-center transform hover:-translate-y-1">
                <div class="w-20 h-20 bg-[#0056FF] rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-file-alt text-white text-3xl"></i>
                </div>
                <h3 class="font-bold text-[#0F1B4C] mb-2 text-lg" style="font-family: 'Inter', sans-serif; font-weight: 700; letter-spacing: -0.01em;">Aims & Scope</h3>
                <p class="text-sm text-gray-600" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.6;">Learn about our research focus and objectives</p>
            </a>
            
            <a href="{{ route('journals.editorial-board', $journal) }}" 
               class="bg-white rounded-xl p-8 border-2 border-gray-200 hover:border-[#0056FF] hover:shadow-xl transition-all duration-300 text-center transform hover:-translate-y-1">
                <div class="w-20 h-20 bg-[#0056FF] rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users text-white text-3xl"></i>
                </div>
                <h3 class="font-bold text-[#0F1B4C] mb-2 text-lg" style="font-family: 'Inter', sans-serif; font-weight: 700; letter-spacing: -0.01em;">Editorial Board</h3>
                <p class="text-sm text-gray-600" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.6;">Meet our editorial board members</p>
            </a>
            
            <a href="{{ route('journals.submission-guidelines', $journal) }}" 
               class="bg-white rounded-xl p-8 border-2 border-gray-200 hover:border-[#0056FF] hover:shadow-xl transition-all duration-300 text-center transform hover:-translate-y-1">
                <div class="w-20 h-20 bg-[#0056FF] rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-paper-plane text-white text-3xl"></i>
                </div>
                <h3 class="font-bold text-[#0F1B4C] mb-2 text-lg" style="font-family: 'Inter', sans-serif; font-weight: 700; letter-spacing: -0.01em;">Submission Guidelines</h3>
                <p class="text-sm text-gray-600" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.6;">Start your submission process</p>
            </a>
            
            <a href="{{ route('journals.contact', $journal) }}" 
               class="bg-white rounded-xl p-8 border-2 border-gray-200 hover:border-[#0056FF] hover:shadow-xl transition-all duration-300 text-center transform hover:-translate-y-1">
                <div class="w-20 h-20 bg-[#0056FF] rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-envelope text-white text-3xl"></i>
                </div>
                <h3 class="font-bold text-[#0F1B4C] mb-2 text-lg" style="font-family: 'Inter', sans-serif; font-weight: 700; letter-spacing: -0.01em;">Contact Us</h3>
                <p class="text-sm text-gray-600" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.6;">Get in touch with our team</p>
            </a>
            
            <a href="{{ route('journals.archives', $journal) }}" 
               class="bg-white rounded-xl p-8 border-2 border-gray-200 hover:border-[#0056FF] hover:shadow-xl transition-all duration-300 text-center transform hover:-translate-y-1">
                <div class="w-20 h-20 bg-[#0056FF] rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-archive text-white text-3xl"></i>
                </div>
                <h3 class="font-bold text-[#0F1B4C] mb-2 text-lg" style="font-family: 'Inter', sans-serif; font-weight: 700; letter-spacing: -0.01em;">Archives</h3>
                <p class="text-sm text-gray-600" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.6;">Browse all published issues</p>
            </a>
            
            <a href="{{ route('journals.author-guidelines', $journal) }}" 
               class="bg-white rounded-xl p-8 border-2 border-gray-200 hover:border-[#0056FF] hover:shadow-xl transition-all duration-300 text-center transform hover:-translate-y-1">
                <div class="w-20 h-20 bg-[#0056FF] rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-clipboard-list text-white text-3xl"></i>
                </div>
                <h3 class="font-bold text-[#0F1B4C] mb-2 text-lg" style="font-family: 'Inter', sans-serif; font-weight: 700; letter-spacing: -0.01em;">Author Guidelines</h3>
                <p class="text-sm text-gray-600" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.6;">Submission process & guidelines</p>
            </a>
            
            <a href="{{ route('journals.peer-review-policy', $journal) }}" 
               class="bg-white rounded-xl p-8 border-2 border-gray-200 hover:border-[#0056FF] hover:shadow-xl transition-all duration-300 text-center transform hover:-translate-y-1">
                <div class="w-20 h-20 bg-[#0056FF] rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check-circle text-white text-3xl"></i>
                </div>
                <h3 class="font-bold text-[#0F1B4C] mb-2 text-lg" style="font-family: 'Inter', sans-serif; font-weight: 700; letter-spacing: -0.01em;">Peer Review Policy</h3>
                <p class="text-sm text-gray-600" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.6;">Our review process & standards</p>
            </a>
            
            <a href="{{ route('journals.open-access-policy', $journal) }}" 
               class="bg-white rounded-xl p-8 border-2 border-gray-200 hover:border-[#0056FF] hover:shadow-xl transition-all duration-300 text-center transform hover:-translate-y-1">
                <div class="w-20 h-20 bg-[#0056FF] rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-unlock text-white text-3xl"></i>
                </div>
                <h3 class="font-bold text-[#0F1B4C] mb-2 text-lg" style="font-family: 'Inter', sans-serif; font-weight: 700; letter-spacing: -0.01em;">Open Access Policy</h3>
                <p class="text-sm text-gray-600" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.6;">Free access to research</p>
            </a>
            
            <a href="{{ route('journals.copyright-notice', $journal) }}" 
               class="bg-white rounded-xl p-8 border-2 border-gray-200 hover:border-[#0056FF] hover:shadow-xl transition-all duration-300 text-center transform hover:-translate-y-1">
                <div class="w-20 h-20 bg-[#0056FF] rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-copyright text-white text-3xl"></i>
                </div>
                <h3 class="font-bold text-[#0F1B4C] mb-2 text-lg" style="font-family: 'Inter', sans-serif; font-weight: 700; letter-spacing: -0.01em;">Copyright Notice</h3>
                <p class="text-sm text-gray-600" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.6;">Copyright & licensing info</p>
            </a>
            
            <a href="{{ route('journals.editorial-policies', $journal) }}" 
               class="bg-white rounded-xl p-8 border-2 border-gray-200 hover:border-[#0056FF] hover:shadow-xl transition-all duration-300 text-center transform hover:-translate-y-1">
                <div class="w-20 h-20 bg-[#0056FF] rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-balance-scale text-white text-3xl"></i>
                </div>
                <h3 class="font-bold text-[#0F1B4C] mb-2 text-lg" style="font-family: 'Inter', sans-serif; font-weight: 700; letter-spacing: -0.01em;">Editorial Policies</h3>
                <p class="text-sm text-gray-600" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.6;">Our publishing policies</p>
            </a>
            
            <a href="{{ route('journals.announcements', $journal) }}" 
               class="bg-white rounded-xl p-8 border-2 border-gray-200 hover:border-[#0056FF] hover:shadow-xl transition-all duration-300 text-center transform hover:-translate-y-1">
                <div class="w-20 h-20 bg-[#0056FF] rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-bullhorn text-white text-3xl"></i>
                </div>
                <h3 class="font-bold text-[#0F1B4C] mb-2 text-lg" style="font-family: 'Inter', sans-serif; font-weight: 700; letter-spacing: -0.01em;">Announcements</h3>
                <p class="text-sm text-gray-600" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.6;">Latest news & updates</p>
            </a>
            
            <a href="{{ route('journals.history', $journal) }}" 
               class="bg-white rounded-xl p-8 border-2 border-gray-200 hover:border-[#0056FF] hover:shadow-xl transition-all duration-300 text-center transform hover:-translate-y-1">
                <div class="w-20 h-20 bg-[#0056FF] rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-history text-white text-3xl"></i>
                </div>
                <h3 class="font-bold text-[#0F1B4C] mb-2 text-lg" style="font-family: 'Inter', sans-serif; font-weight: 700; letter-spacing: -0.01em;">Journal History</h3>
                <p class="text-sm text-gray-600" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.6;">Learn about our journey</p>
            </a>
        </div>
    </div>
</section>

<!-- Latest Issue Section -->
@if($latestIssue)
<section class="bg-gradient-to-br from-[#F7F9FC] to-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-[#0F1B4C] mb-4" style="font-family: 'Playfair Display', serif; font-weight: 700; letter-spacing: -0.01em; line-height: 1.2;">
                Latest <span class="text-[#0056FF]">Issue</span>
            </h2>
            <div class="w-24 h-1 bg-[#0056FF] mx-auto rounded-full"></div>
        </div>
        
        <div class="bg-white rounded-2xl shadow-xl border-2 border-gray-100 p-8 md:p-12 max-w-4xl mx-auto text-center">
            <div class="mb-6">
                <div class="inline-block bg-[#0056FF] text-white px-6 py-2 rounded-full font-bold text-lg mb-4" style="font-family: 'Inter', sans-serif; font-weight: 700; letter-spacing: 0.02em;">
                    Volume {{ $latestIssue->volume }}, Issue {{ $latestIssue->issue_number }} ({{ $latestIssue->year }})
                </div>
            </div>
            <h3 class="text-2xl md:text-3xl font-bold text-[#0F1B4C] mb-4" style="font-family: 'Playfair Display', serif; font-weight: 700; letter-spacing: -0.01em; line-height: 1.3;">{{ $latestIssue->display_title }}</h3>
            @if($latestIssue->description)
                <p class="text-gray-700 mb-8 text-lg leading-relaxed">{{ $latestIssue->description }}</p>
            @endif
            <a href="{{ route('journals.issue', [$journal, $latestIssue]) }}" 
               class="btn bg-[#0056FF] hover:bg-[#0044CC] text-white px-8 py-4 rounded-lg font-bold text-lg transition-colors shadow-lg transform hover:scale-105">
                <i class="fas fa-book-open mr-2"></i>View Issue
            </a>
        </div>
    </div>
</section>
@endif

<!-- Recent Articles Section -->
@if($recentArticles->count() > 0)
<section class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-[#0F1B4C] mb-4" style="font-family: 'Playfair Display', serif; font-weight: 700; letter-spacing: -0.01em; line-height: 1.2;">
                Recent <span class="text-[#0056FF]">Articles</span>
            </h2>
            <div class="w-24 h-1 bg-[#0056FF] mx-auto rounded-full"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($recentArticles as $article)
                <div class="bg-white rounded-xl border-2 border-gray-200 hover:border-[#0056FF] hover:shadow-xl transition-all duration-300 p-6 transform hover:-translate-y-1">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center">
                            <i class="fas fa-file-alt text-white text-xl"></i>
                        </div>
                        @if($article->formatted_published_at)
                            <span class="text-xs text-gray-500 font-semibold" style="font-family: 'Inter', sans-serif; font-weight: 600;">{{ \Carbon\Carbon::parse($article->formatted_published_at)->format('M Y') }}</span>
                        @endif
                    </div>
                    <h3 class="text-lg font-bold text-[#0F1B4C] mb-3 min-h-[3.5rem] leading-tight" style="font-family: 'Playfair Display', serif; font-weight: 700; letter-spacing: -0.01em; line-height: 1.4;">
                        <a href="#" class="hover:text-[#0056FF] transition-colors">{{ Str::limit($article->title, 60) }}</a>
                    </h3>
                    <p class="text-sm text-gray-600 mb-3" style="font-family: 'Inter', sans-serif; font-weight: 500; line-height: 1.5;">
                        @foreach($article->authors as $author)
                            {{ $author->full_name }}@if(!$loop->last), @endif
                        @endforeach
                    </p>
                    @if($article->abstract)
                        <p class="text-sm text-gray-700 mb-4 line-clamp-3" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.6;">{{ Str::limit($article->abstract, 120) }}</p>
                    @endif
                    @if($article->doi)
                        <p class="text-xs text-gray-500 mb-3">
                            <i class="fas fa-fingerprint mr-1"></i>DOI: {{ $article->doi }}
                        </p>
                    @endif
                    <a href="#" class="text-[#0056FF] hover:text-[#0044CC] text-sm font-semibold transition-colors inline-flex items-center">
                        Read More <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Technologies/Indexing Section -->
<section class="bg-[#0F1B4C] py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h2 class="text-xl font-bold text-white uppercase tracking-wide mb-2">Indexed & Supported By</h2>
            <div class="w-24 h-1 bg-[#0056FF] mx-auto rounded-full"></div>
        </div>
        <div class="flex flex-wrap justify-center items-center gap-12">
            <div class="text-center group">
                <i class="fab fa-orcid text-5xl text-white opacity-70 group-hover:opacity-100 transition-opacity mb-2"></i>
                <p class="text-xs text-white opacity-70">ORCID</p>
            </div>
            <div class="text-center group">
                <i class="fas fa-link text-5xl text-white opacity-70 group-hover:opacity-100 transition-opacity mb-2"></i>
                <p class="text-xs text-white opacity-70">Crossref</p>
            </div>
            <div class="text-center group">
                <i class="fas fa-database text-5xl text-white opacity-70 group-hover:opacity-100 transition-opacity mb-2"></i>
                <p class="text-xs text-white opacity-70">PubMed</p>
            </div>
            <div class="text-center group">
                <i class="fas fa-book text-5xl text-white opacity-70 group-hover:opacity-100 transition-opacity mb-2"></i>
                <p class="text-xs text-white opacity-70">DOAJ</p>
            </div>
            <div class="text-center group">
                <i class="fas fa-chart-line text-5xl text-white opacity-70 group-hover:opacity-100 transition-opacity mb-2"></i>
                <p class="text-xs text-white opacity-70">Clarivate</p>
            </div>
        </div>
    </div>
</section>
@endsection
