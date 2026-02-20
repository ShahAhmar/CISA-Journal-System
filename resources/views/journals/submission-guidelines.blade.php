@extends('layouts.app')

@section('title', $journal->name . ' - Submission Guidelines | EMANP')

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
            <h2 class="text-2xl md:text-3xl font-semibold text-blue-200 mb-2">Submission Guidelines</h2>
            <p class="text-lg text-blue-100 max-w-3xl mx-auto">
                Everything you need to know before submitting your manuscript
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
            <span class="text-gray-600">Submission Guidelines</span>
        </nav>
    </div>
</div>

<!-- Main Content -->
<section class="bg-white py-16">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-xl border-2 border-gray-100 p-8 md:p-12">
            @if($journal->submission_guidelines)
                <div class="prose prose-lg max-w-none">
                    <div class="text-gray-800 leading-relaxed text-lg">
                        {!! $journal->submission_guidelines !!}
                    </div>
                </div>
            @elseif($journal->author_guidelines || $journal->submission_requirements || $journal->submission_checklist)
                <!-- Fallback: Show combined content if submission_guidelines is not set -->
                <div class="prose prose-lg max-w-none space-y-8">
                    @if($journal->author_guidelines)
                    <div>
                        <h3 class="text-2xl font-bold text-[#0F1B4C] mb-4">
                            <i class="fas fa-file-alt mr-2 text-[#0056FF]"></i>Author Guidelines
                        </h3>
                        <div class="text-gray-800 leading-relaxed">
                            {!! $journal->author_guidelines !!}
                        </div>
                    </div>
                    @endif

                    @if($journal->submission_requirements)
                    <div>
                        <h3 class="text-2xl font-bold text-[#0F1B4C] mb-4">
                            <i class="fas fa-clipboard-check mr-2 text-[#0056FF]"></i>Submission Requirements
                        </h3>
                        <div class="text-gray-800 leading-relaxed">
                            {!! $journal->submission_requirements !!}
                        </div>
                    </div>
                    @endif

                    @if($journal->submission_checklist)
                    <div>
                        <h3 class="text-2xl font-bold text-[#0F1B4C] mb-4">
                            <i class="fas fa-check-square mr-2 text-[#0056FF]"></i>Submission Checklist
                        </h3>
                        <div class="text-gray-800 leading-relaxed">
                            {!! $journal->submission_checklist !!}
                        </div>
                    </div>
                    @endif
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-file-alt text-gray-400 text-6xl mb-4"></i>
                    <h3 class="text-2xl font-bold text-gray-700 mb-2">Submission Guidelines Coming Soon</h3>
                    <p class="text-gray-600 mb-6">Detailed submission guidelines will be available soon.</p>
                </div>
            @endif
        </div>

        <!-- Quick Guidelines Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
            <div class="bg-[#F7F9FC] rounded-xl p-6 border-2 border-gray-200">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-file-word text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-[#0F1B4C]">Manuscript Format</h3>
                </div>
                <p class="text-gray-600 text-sm">Follow our formatting guidelines for manuscript preparation.</p>
            </div>
            
            <div class="bg-[#F7F9FC] rounded-xl p-6 border-2 border-gray-200">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-[#0F1B4C]">Author Information</h3>
                </div>
                <p class="text-gray-600 text-sm">Provide complete author details and affiliations.</p>
            </div>
            
            <div class="bg-[#F7F9FC] rounded-xl p-6 border-2 border-gray-200">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-check-circle text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-[#0F1B4C]">Peer Review Process</h3>
                </div>
                <p class="text-gray-600 text-sm">Double-blind peer review by independent experts.</p>
            </div>
            
            <div class="bg-[#F7F9FC] rounded-xl p-6 border-2 border-gray-200">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-clock text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-[#0F1B4C]">Review Timeline</h3>
                </div>
                <p class="text-gray-600 text-sm">Average review time: 3-6 weeks from submission.</p>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="mt-12 text-center">
            @auth
                <a href="{{ route('author.submissions.create', $journal) }}" 
                   class="inline-block bg-[#0056FF] hover:bg-[#0044CC] text-white px-12 py-4 rounded-lg font-bold text-lg transition-colors shadow-xl transform hover:scale-105">
                    <i class="fas fa-file-upload mr-2"></i>Submit Your Article Now
                </a>
                <p class="text-gray-600 mt-4 text-sm">You are logged in and ready to submit</p>
            @else
                <div class="bg-[#F7F9FC] rounded-xl p-8 border-2 border-gray-200">
                    <h3 class="text-xl font-bold text-[#0F1B4C] mb-4">Ready to Submit?</h3>
                    <p class="text-gray-600 mb-6">Please login or create an account to submit your manuscript.</p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="{{ route('login') }}" 
                           class="btn bg-[#0056FF] hover:bg-[#0044CC] text-white px-8 py-3 rounded-lg font-semibold transition-colors">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login
                        </a>
                        <a href="{{ route('register') }}" 
                           class="btn bg-white hover:bg-gray-50 text-[#0F1B4C] border-2 border-[#0F1B4C] px-8 py-3 rounded-lg font-semibold transition-colors">
                            <i class="fas fa-user-plus mr-2"></i>Register
                        </a>
                    </div>
                </div>
            @endauth
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex flex-wrap justify-center gap-4">
            <a href="{{ route('journals.show', $journal) }}" 
               class="btn bg-[#0F1B4C] hover:bg-[#0A1538] text-white px-8 py-3 rounded-lg font-semibold transition-colors shadow-lg">
                <i class="fas fa-arrow-left mr-2"></i>Back to Journal
            </a>
            <a href="{{ route('journals.aims-scope', $journal) }}" 
               class="btn bg-white hover:bg-gray-50 text-[#0F1B4C] border-2 border-[#0F1B4C] px-8 py-3 rounded-lg font-semibold transition-colors">
                <i class="fas fa-file-alt mr-2"></i>Aims & Scope
            </a>
        </div>
    </div>
</section>
@endsection
