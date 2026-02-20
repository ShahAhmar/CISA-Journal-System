@extends('layouts.app')

@section('title', $journal->name . ' - Aims & Scope | EMANP')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-br from-[#0F1B4C] via-[#1D72B8] to-[#0F1B4C] text-white py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 20px 20px;"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center">
            <div class="inline-block mb-6">
                @if($journal->logo)
                    <img src="{{ asset('storage/' . $journal->logo) }}" 
                         alt="{{ $journal->name }}" 
                         class="h-20 w-20 object-contain mx-auto bg-white p-3 rounded-xl shadow-xl"
                         onerror="this.style.display='none';">
                @endif
            </div>
            <h1 class="text-4xl md:text-5xl font-bold mb-4 font-display">{{ $journal->name }}</h1>
            <h2 class="text-2xl md:text-3xl font-semibold text-blue-200 mb-2">Aims & Scope</h2>
            <p class="text-lg text-blue-100 max-w-3xl mx-auto">
                Understanding our research focus and publication objectives
            </p>
        </div>
    </div>
</section>

<!-- Breadcrumb -->
<div class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <nav class="flex items-center space-x-2 text-sm">
            <a href="{{ route('journals.index') }}" class="text-[#0056FF] hover:text-[#0044CC] transition-colors">
                <i class="fas fa-home"></i> Home
            </a>
            <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
            <a href="{{ route('journals.show', $journal) }}" class="text-[#0056FF] hover:text-[#0044CC] transition-colors">
                {{ Str::limit($journal->name, 30) }}
            </a>
            <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
            <span class="text-gray-600">Aims & Scope</span>
        </nav>
    </div>
</div>

<!-- Main Content -->
<section class="bg-white py-16">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-xl border-2 border-gray-100 p-8 md:p-12">
            @if($journal->focus_scope || $journal->aims_scope)
                <div class="prose prose-lg max-w-none">
                    <div class="text-gray-800 leading-relaxed text-lg">
                        {!! $journal->focus_scope ?? $journal->aims_scope !!}
                    </div>
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-file-alt text-gray-400 text-6xl mb-4"></i>
                    <h3 class="text-2xl font-bold text-gray-700 mb-2">No Aims & Scope Available</h3>
                    <p class="text-gray-600">Aims and scope information will be available soon.</p>
                </div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex flex-wrap justify-center gap-4">
            <a href="{{ route('journals.show', $journal) }}" 
               class="btn bg-[#0F1B4C] hover:bg-[#0A1538] text-white px-8 py-3 rounded-lg font-semibold transition-colors shadow-lg">
                <i class="fas fa-arrow-left mr-2"></i>Back to Journal
            </a>
            <a href="{{ route('author.submissions.create', $journal) }}" 
               class="btn bg-[#0056FF] hover:bg-[#0044CC] text-white px-8 py-3 rounded-lg font-semibold transition-colors shadow-lg">
                <i class="fas fa-file-upload mr-2"></i>Submit Article
            </a>
            <a href="{{ route('journals.editorial-board', $journal) }}" 
               class="btn bg-white hover:bg-gray-50 text-[#0F1B4C] border-2 border-[#0F1B4C] px-8 py-3 rounded-lg font-semibold transition-colors">
                <i class="fas fa-users mr-2"></i>Editorial Board
            </a>
        </div>
    </div>
</section>

<!-- Related Links Section -->
<section class="bg-[#F7F9FC] py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h3 class="text-2xl font-bold text-[#0F1B4C] mb-8 text-center">Explore More</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ route('journals.editorial-board', $journal) }}" 
               class="bg-white rounded-xl p-6 border-2 border-gray-200 hover:border-[#0056FF] hover:shadow-xl transition-all duration-300 text-center">
                <div class="w-16 h-16 bg-[#0056FF] rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
                <h4 class="font-bold text-[#0F1B4C] mb-2">Editorial Board</h4>
                <p class="text-sm text-gray-600">Meet our expert editorial team</p>
            </a>
            
            <a href="{{ route('journals.submission-guidelines', $journal) }}" 
               class="bg-white rounded-xl p-6 border-2 border-gray-200 hover:border-[#0056FF] hover:shadow-xl transition-all duration-300 text-center">
                <div class="w-16 h-16 bg-[#0056FF] rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-file-upload text-white text-2xl"></i>
                </div>
                <h4 class="font-bold text-[#0F1B4C] mb-2">Submission Guidelines</h4>
                <p class="text-sm text-gray-600">Learn how to submit your research</p>
            </a>
            
            <a href="{{ route('journals.contact', $journal) }}" 
               class="bg-white rounded-xl p-6 border-2 border-gray-200 hover:border-[#0056FF] hover:shadow-xl transition-all duration-300 text-center">
                <div class="w-16 h-16 bg-[#0056FF] rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-envelope text-white text-2xl"></i>
                </div>
                <h4 class="font-bold text-[#0F1B4C] mb-2">Contact Us</h4>
                <p class="text-sm text-gray-600">Get in touch with our team</p>
            </a>
        </div>
    </div>
</section>
@endsection
