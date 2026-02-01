@extends('layouts.admin')

@section('title', $journal->name . ' - EMANP')
@section('page-title', $journal->name)
@section('page-subtitle', 'Journal details and statistics')

@section('content')
<!-- Header Actions -->
<div class="bg-white rounded-xl border-2 border-gray-200 p-6 mb-6 flex justify-between items-center">
    <div class="flex items-center space-x-4">
        @if($journal->logo)
            <img src="{{ asset('storage/' . $journal->logo) }}" 
                 alt="{{ $journal->name }}" 
                 class="w-16 h-16 object-contain bg-white p-2 rounded-lg border-2 border-gray-200">
        @else
            <div class="w-16 h-16 bg-[#0056FF] rounded-lg flex items-center justify-center">
                <i class="fas fa-book text-white text-2xl"></i>
            </div>
        @endif
        <div>
            <h3 class="text-xl font-bold text-[#0F1B4C]" style="font-family: 'Playfair Display', serif;">{{ $journal->name }}</h3>
            <p class="text-sm text-gray-600">{{ $journal->slug }}</p>
        </div>
    </div>
    <div class="flex space-x-3">
        <a href="{{ route('journals.show', $journal->slug) }}" 
           target="_blank"
           class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-semibold transition-colors">
            <i class="fas fa-external-link-alt mr-2"></i>View Public Page
        </a>
        <a href="{{ route('admin.journals.edit', $journal) }}" 
           class="px-6 py-3 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors">
            <i class="fas fa-edit mr-2"></i>Edit Journal
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Journal Information -->
        <div class="bg-white rounded-xl border-2 border-gray-200 p-8">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-info-circle text-white text-xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-[#0F1B4C]" style="font-family: 'Playfair Display', serif;">
                    Journal Information
                </h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-500 mb-1" style="font-family: 'Inter', sans-serif; font-weight: 600;">
                        Journal Name
                    </label>
                    <p class="text-lg font-semibold text-[#0F1B4C]" style="font-family: 'Inter', sans-serif;">{{ $journal->name }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-500 mb-1" style="font-family: 'Inter', sans-serif; font-weight: 600;">
                        Slug
                    </label>
                    <p class="text-lg text-gray-700" style="font-family: 'Inter', sans-serif;">/{{ $journal->slug }}</p>
                </div>
                
                @if($journal->issn)
                    <div>
                        <label class="block text-sm font-bold text-gray-500 mb-1" style="font-family: 'Inter', sans-serif; font-weight: 600;">
                            ISSN
                        </label>
                        <p class="text-lg text-gray-700" style="font-family: 'Inter', sans-serif;">{{ $journal->issn }}</p>
                    </div>
                @endif
                
                @if($journal->doi_prefix)
                    <div>
                        <label class="block text-sm font-bold text-gray-500 mb-1" style="font-family: 'Inter', sans-serif; font-weight: 600;">
                            DOI Prefix
                        </label>
                        <p class="text-lg text-gray-700" style="font-family: 'Inter', sans-serif;">{{ $journal->doi_prefix }}</p>
                    </div>
                @endif
                
                <div>
                    <label class="block text-sm font-bold text-gray-500 mb-1" style="font-family: 'Inter', sans-serif; font-weight: 600;">
                        Status
                    </label>
                    <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $journal->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                        {{ $journal->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-500 mb-1" style="font-family: 'Inter', sans-serif; font-weight: 600;">
                        Created Date
                    </label>
                    <p class="text-lg text-gray-700" style="font-family: 'Inter', sans-serif;">{{ $journal->created_at->format('F d, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Description -->
        @if($journal->description)
            <div class="bg-white rounded-xl border-2 border-gray-200 p-8">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-align-left text-white text-xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-[#0F1B4C]" style="font-family: 'Playfair Display', serif;">
                        Description
                    </h2>
                </div>
                <div class="prose max-w-none text-gray-700" style="font-family: 'Inter', sans-serif; line-height: 1.8;">
                    {!! nl2br(e($journal->description)) !!}
                </div>
            </div>
        @endif

        <!-- Cover Image -->
        @if($journal->cover_image)
            <div class="bg-white rounded-xl border-2 border-gray-200 p-8">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-image text-white text-xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-[#0F1B4C]" style="font-family: 'Playfair Display', serif;">
                        Cover Image
                    </h2>
                </div>
                <img src="{{ asset('storage/' . $journal->cover_image) }}" 
                     alt="{{ $journal->name }} Cover" 
                     class="w-full h-auto rounded-lg border-2 border-gray-200">
            </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Statistics -->
        <div class="bg-white rounded-xl border-2 border-gray-200 p-6">
            <h3 class="text-lg font-bold text-[#0F1B4C] mb-4" style="font-family: 'Playfair Display', serif;">
                Statistics
            </h3>
            <div class="space-y-4">
                <div class="p-4 bg-[#F7F9FC] rounded-lg">
                    <label class="block text-sm font-semibold text-gray-600 mb-1" style="font-family: 'Inter', sans-serif;">
                        Total Submissions
                    </label>
                    <p class="text-3xl font-bold text-[#0056FF]" style="font-family: 'Inter', sans-serif;">
                        {{ $journal->submissions->count() }}
                    </p>
                </div>
                
                <div class="p-4 bg-[#F7F9FC] rounded-lg">
                    <label class="block text-sm font-semibold text-gray-600 mb-1" style="font-family: 'Inter', sans-serif;">
                        Published Articles
                    </label>
                    <p class="text-3xl font-bold text-green-600" style="font-family: 'Inter', sans-serif;">
                        {{ $journal->submissions->where('status', 'published')->count() }}
                    </p>
                </div>
                
                <div class="p-4 bg-[#F7F9FC] rounded-lg">
                    <label class="block text-sm font-semibold text-gray-600 mb-1" style="font-family: 'Inter', sans-serif;">
                        Total Issues
                    </label>
                    <p class="text-3xl font-bold text-blue-600" style="font-family: 'Inter', sans-serif;">
                        {{ $journal->issues->count() }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl border-2 border-gray-200 p-6">
            <h3 class="text-lg font-bold text-[#0F1B4C] mb-4" style="font-family: 'Playfair Display', serif;">
                Quick Actions
            </h3>
            <div class="space-y-3">
                <a href="{{ route('admin.journals.edit', $journal) }}" 
                   class="block w-full bg-[#F7F9FC] hover:bg-[#0056FF] hover:text-white text-[#0F1B4C] px-4 py-3 rounded-lg font-semibold transition-colors text-center">
                    <i class="fas fa-edit mr-2"></i>Edit Journal
                </a>
                <a href="{{ route('admin.submissions.index', ['journal_id' => $journal->id]) }}" 
                   class="block w-full bg-[#F7F9FC] hover:bg-[#0056FF] hover:text-white text-[#0F1B4C] px-4 py-3 rounded-lg font-semibold transition-colors text-center">
                    <i class="fas fa-file-alt mr-2"></i>View Submissions
                </a>
                <a href="{{ route('admin.issues.index') }}" 
                   class="block w-full bg-[#F7F9FC] hover:bg-[#0056FF] hover:text-white text-[#0F1B4C] px-4 py-3 rounded-lg font-semibold transition-colors text-center">
                    <i class="fas fa-bookmark mr-2"></i>Manage Issues
                </a>
                <a href="{{ route('journals.show', $journal->slug) }}" 
                   target="_blank"
                   class="block w-full bg-[#F7F9FC] hover:bg-[#0056FF] hover:text-white text-[#0F1B4C] px-4 py-3 rounded-lg font-semibold transition-colors text-center">
                    <i class="fas fa-external-link-alt mr-2"></i>View Public Page
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
