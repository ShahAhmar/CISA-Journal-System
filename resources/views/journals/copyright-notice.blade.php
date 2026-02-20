@extends('layouts.app')

@section('title', $journal->name . ' - Copyright Notice | EMANP')

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
            <h2 class="text-2xl md:text-3xl font-semibold text-blue-200 mb-2">Copyright Notice</h2>
            <p class="text-lg text-blue-100 max-w-3xl mx-auto">
                Copyright and licensing information
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
            <span class="text-gray-600">Copyright Notice</span>
        </nav>
    </div>
</div>

<!-- Main Content -->
<section class="bg-white py-16">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-xl border-2 border-gray-100 p-8 md:p-12">
            @if($journal->copyright_notice)
                <div class="prose prose-lg max-w-none">
                    <div class="text-gray-800 leading-relaxed text-lg whitespace-pre-line">
                        {{ $journal->copyright_notice }}
                    </div>
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-copyright text-gray-400 text-6xl mb-4"></i>
                    <h3 class="text-2xl font-bold text-gray-700 mb-2">Copyright Notice Coming Soon</h3>
                    <p class="text-gray-600 mb-6">Copyright notice will be available soon.</p>
                </div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex flex-wrap justify-center gap-4">
            <a href="{{ route('journals.show', $journal) }}" 
               class="btn bg-[#0F1B4C] hover:bg-[#0A1538] text-white px-8 py-3 rounded-lg font-semibold transition-colors shadow-lg">
                <i class="fas fa-arrow-left mr-2"></i>Back to Journal
            </a>
            <a href="{{ route('journals.aims-scope', $journal) }}" 
               class="btn bg-white hover:bg-gray-50 text-[#0F1B4C] border-2 border-[#0F1B4C] px-8 py-3 rounded-lg font-semibold transition-colors">
                <i class="fas fa-bullseye mr-2"></i>Aims & Scope
            </a>
            <a href="{{ route('journals.open-access-policy', $journal) }}" 
               class="btn bg-white hover:bg-gray-50 text-[#0F1B4C] border-2 border-[#0F1B4C] px-8 py-3 rounded-lg font-semibold transition-colors">
                <i class="fas fa-unlock mr-2"></i>Open Access Policy
            </a>
        </div>
    </div>
</section>
@endsection

