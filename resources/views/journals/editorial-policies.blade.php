@extends('layouts.app')

@section('title', $journal->name . ' - Editorial Policies')

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
                <li class="text-white">Editorial Policies</li>
            </ol>
        </nav>
        
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4" style="font-family: 'Playfair Display', serif; font-weight: 700; letter-spacing: 0.03em; line-height: 1.2;">
                Editorial Policies
            </h1>
            <p class="text-xl text-blue-100 max-w-2xl mx-auto" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.6;">
                Our commitment to quality, integrity, and ethical publishing
            </p>
        </div>
    </div>
</section>

<!-- Policies Content -->
<section class="bg-[#F7F9FC] py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <!-- Focus & Scope -->
        @if($journal->focus_scope)
        <div class="bg-white rounded-xl border-2 border-gray-200 p-8">
            <h2 class="text-2xl font-bold text-[#0F1B4C] mb-4" style="font-family: 'Playfair Display', serif; font-weight: 700;">
                <i class="fas fa-bullseye mr-3 text-[#0056FF]"></i>Focus & Scope
            </h2>
            <div class="prose max-w-none text-gray-700 leading-relaxed" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.8;">
                {!! $journal->focus_scope !!}
            </div>
        </div>
        @endif

        <!-- Publication Frequency -->
        @if($journal->publication_frequency)
        <div class="bg-white rounded-xl border-2 border-gray-200 p-8">
            <h2 class="text-2xl font-bold text-[#0F1B4C] mb-4" style="font-family: 'Playfair Display', serif; font-weight: 700;">
                <i class="fas fa-calendar-alt mr-3 text-[#0056FF]"></i>Publication Frequency
            </h2>
            <div class="prose max-w-none text-gray-700 leading-relaxed" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.8;">
                {!! $journal->publication_frequency !!}
            </div>
        </div>
        @endif

        <!-- Peer Review Policy -->
        @if($journal->peer_review_policy)
        <div class="bg-white rounded-xl border-2 border-gray-200 p-8">
            <h2 class="text-2xl font-bold text-[#0F1B4C] mb-4" style="font-family: 'Playfair Display', serif; font-weight: 700;">
                <i class="fas fa-check-double mr-3 text-[#0056FF]"></i>Peer Review Policy
            </h2>
            <div class="prose max-w-none text-gray-700 leading-relaxed" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.8;">
                {!! $journal->peer_review_policy !!}
            </div>
        </div>
        @endif

        @if($journal->peer_review_process)
        <div class="bg-white rounded-xl border-2 border-gray-200 p-8">
            <h2 class="text-2xl font-bold text-[#0F1B4C] mb-4" style="font-family: 'Playfair Display', serif; font-weight: 700;">
                <i class="fas fa-users-cog mr-3 text-[#0056FF]"></i>Peer Review Process
            </h2>
            <div class="prose max-w-none text-gray-700 leading-relaxed" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.8;">
                {!! $journal->peer_review_process !!}
            </div>
        </div>
        @endif

        <!-- Open Access Policy -->
        @if($journal->open_access_policy)
        <div class="bg-white rounded-xl border-2 border-gray-200 p-8">
            <h2 class="text-2xl font-bold text-[#0F1B4C] mb-4" style="font-family: 'Playfair Display', serif; font-weight: 700;">
                <i class="fas fa-unlock mr-3 text-[#0056FF]"></i>Open Access Policy
            </h2>
            <div class="prose max-w-none text-gray-700 leading-relaxed" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.8;">
                {!! $journal->open_access_policy !!}
            </div>
        </div>
        @endif

        <!-- Copyright Notice -->
        @if($journal->copyright_notice)
        <div class="bg-white rounded-xl border-2 border-gray-200 p-8">
            <h2 class="text-2xl font-bold text-[#0F1B4C] mb-4" style="font-family: 'Playfair Display', serif; font-weight: 700;">
                <i class="fas fa-copyright mr-3 text-[#0056FF]"></i>Copyright Notice
            </h2>
            <div class="prose max-w-none text-gray-700 leading-relaxed whitespace-pre-line" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.8;">
                {!! nl2br(e($journal->copyright_notice)) !!}
            </div>
        </div>
        @endif

        <!-- Privacy Statement -->
        @if($journal->privacy_statement)
        <div class="bg-white rounded-xl border-2 border-gray-200 p-8">
            <h2 class="text-2xl font-bold text-[#0F1B4C] mb-4" style="font-family: 'Playfair Display', serif; font-weight: 700;">
                <i class="fas fa-shield-alt mr-3 text-[#0056FF]"></i>Privacy Statement
            </h2>
            <div class="prose max-w-none text-gray-700 leading-relaxed" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.8;">
                {!! $journal->privacy_statement !!}
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

