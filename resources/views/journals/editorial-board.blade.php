@extends('layouts.app')

@section('title', $journal->name . ' - Editorial Board | EMANP')

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
            <h2 class="text-2xl md:text-3xl font-semibold text-blue-200 mb-2">Editorial Board</h2>
            <p class="text-lg text-blue-100 max-w-3xl mx-auto">
                Meet our distinguished team of editors and reviewers
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
            <span class="text-gray-600">Editorial Board</span>
        </nav>
    </div>
</div>

<!-- Main Content -->
<section class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Editor-in-Chief (from Journal Content) -->
        @if($journal->editor_in_chief)
        <div class="mb-12">
            <div class="text-center mb-8">
                <h2 class="text-3xl md:text-4xl font-bold text-[#0F1B4C] mb-2">Editor-in-Chief</h2>
                <div class="w-24 h-1 bg-[#0056FF] mx-auto rounded-full"></div>
            </div>
            <div class="bg-white rounded-xl border-2 border-gray-200 p-8 max-w-4xl mx-auto">
                <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                    {!! $journal->editor_in_chief !!}
                </div>
            </div>
        </div>
        @endif

        <!-- Managing Editor (from Journal Content) -->
        @if($journal->managing_editor)
        <div class="mb-12">
            <div class="text-center mb-8">
                <h2 class="text-3xl md:text-4xl font-bold text-[#0F1B4C] mb-2">Managing Editor</h2>
                <div class="w-24 h-1 bg-[#0056FF] mx-auto rounded-full"></div>
            </div>
            <div class="bg-white rounded-xl border-2 border-gray-200 p-8 max-w-4xl mx-auto">
                <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                    {!! $journal->managing_editor !!}
                </div>
            </div>
        </div>
        @endif

        <!-- Section Editors (from Journal Content) -->
        @if($journal->section_editors)
        <div class="mb-12">
            <div class="text-center mb-8">
                <h2 class="text-3xl md:text-4xl font-bold text-[#0F1B4C] mb-2">Section Editors</h2>
                <div class="w-24 h-1 bg-[#0056FF] mx-auto rounded-full"></div>
            </div>
            <div class="bg-white rounded-xl border-2 border-gray-200 p-8 max-w-4xl mx-auto">
                <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                    {!! $journal->section_editors !!}
                </div>
            </div>
        </div>
        @endif

        <!-- Editorial Board Members (from Journal Content) -->
        @if($journal->editorial_board_members)
        <div class="mb-12">
            <div class="text-center mb-8">
                <h2 class="text-3xl md:text-4xl font-bold text-[#0F1B4C] mb-2">Editorial Board Members</h2>
                <div class="w-24 h-1 bg-[#0056FF] mx-auto rounded-full"></div>
            </div>
            <div class="bg-white rounded-xl border-2 border-gray-200 p-8 max-w-4xl mx-auto">
                <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                    {!! $journal->editorial_board_members !!}
                </div>
            </div>
        </div>
        @endif

        <!-- Editors Section (from Users) -->
        @if($editors->count() > 0)
            <div class="mb-12">
                <div class="text-center mb-8">
                    <h2 class="text-3xl md:text-4xl font-bold text-[#0F1B4C] mb-2">Editors-in-Chief</h2>
                    <div class="w-24 h-1 bg-[#0056FF] mx-auto rounded-full"></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($editors as $editor)
                        <div class="bg-white rounded-xl border-2 border-gray-200 hover:border-[#0056FF] hover:shadow-xl transition-all duration-300 p-6 text-center">
                            <div class="w-24 h-24 bg-gradient-to-br from-[#0056FF] to-[#1D72B8] rounded-full flex items-center justify-center mx-auto mb-4">
                                @if($editor->profile_image)
                                    <img src="{{ asset('storage/' . $editor->profile_image) }}" 
                                         alt="{{ $editor->full_name }}" 
                                         class="w-full h-full object-cover rounded-full"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="w-full h-full flex items-center justify-center hidden">
                                        <i class="fas fa-user text-white text-3xl"></i>
                                    </div>
                                @else
                                    <i class="fas fa-user text-white text-3xl"></i>
                                @endif
                            </div>
                            <h3 class="text-xl font-bold text-[#0F1B4C] mb-2">{{ $editor->full_name }}</h3>
                            @if($editor->pivot->section)
                                <p class="text-sm font-semibold text-[#0056FF] mb-2">{{ $editor->pivot->section }}</p>
                            @endif
                            @if($editor->affiliation)
                                <p class="text-sm text-gray-600 mb-2">{{ $editor->affiliation }}</p>
                            @endif
                            @if($editor->orcid)
                                <a href="https://orcid.org/{{ $editor->orcid }}" target="_blank" 
                                   class="text-xs text-[#0056FF] hover:text-[#0044CC] inline-flex items-center">
                                    <i class="fab fa-orcid mr-1"></i> ORCID
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Section Editors -->
        @if($sectionEditors->count() > 0)
            <div class="mb-12">
                <div class="text-center mb-8">
                    <h2 class="text-3xl md:text-4xl font-bold text-[#0F1B4C] mb-2">Section Editors</h2>
                    <div class="w-24 h-1 bg-[#0056FF] mx-auto rounded-full"></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($sectionEditors as $editor)
                        <div class="bg-white rounded-xl border-2 border-gray-200 hover:border-[#0056FF] hover:shadow-xl transition-all duration-300 p-6 text-center">
                            <div class="w-20 h-20 bg-gradient-to-br from-[#1D72B8] to-[#0056FF] rounded-full flex items-center justify-center mx-auto mb-4">
                                @if($editor->profile_image)
                                    <img src="{{ asset('storage/' . $editor->profile_image) }}" 
                                         alt="{{ $editor->full_name }}" 
                                         class="w-full h-full object-cover rounded-full"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="w-full h-full flex items-center justify-center hidden">
                                        <i class="fas fa-user text-white text-2xl"></i>
                                    </div>
                                @else
                                    <i class="fas fa-user text-white text-2xl"></i>
                                @endif
                            </div>
                            <h3 class="text-lg font-bold text-[#0F1B4C] mb-2">{{ $editor->full_name }}</h3>
                            @if($editor->pivot->section)
                                <p class="text-sm font-semibold text-[#0056FF] mb-2">{{ $editor->pivot->section }}</p>
                            @endif
                            @if($editor->affiliation)
                                <p class="text-sm text-gray-600 mb-2">{{ $editor->affiliation }}</p>
                            @endif
                            @if($editor->orcid)
                                <a href="https://orcid.org/{{ $editor->orcid }}" target="_blank" 
                                   class="text-xs text-[#0056FF] hover:text-[#0044CC] inline-flex items-center">
                                    <i class="fab fa-orcid mr-1"></i> ORCID
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Reviewers -->
        @if($reviewers->count() > 0)
            <div class="mb-12">
                <div class="text-center mb-8">
                    <h2 class="text-3xl md:text-4xl font-bold text-[#0F1B4C] mb-2">Reviewers</h2>
                    <div class="w-24 h-1 bg-[#0056FF] mx-auto rounded-full"></div>
                    <p class="text-gray-600 mt-2">Our panel of expert reviewers</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach($reviewers->take(12) as $reviewer)
                        <div class="bg-[#F7F9FC] rounded-lg border border-gray-200 hover:border-[#0056FF] hover:shadow-lg transition-all duration-300 p-4 text-center">
                            <div class="w-16 h-16 bg-gradient-to-br from-gray-400 to-gray-600 rounded-full flex items-center justify-center mx-auto mb-3">
                                @if($reviewer->profile_image)
                                    <img src="{{ asset('storage/' . $reviewer->profile_image) }}" 
                                         alt="{{ $reviewer->full_name }}" 
                                         class="w-full h-full object-cover rounded-full"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="w-full h-full flex items-center justify-center hidden">
                                        <i class="fas fa-user text-white text-xl"></i>
                                    </div>
                                @else
                                    <i class="fas fa-user text-white text-xl"></i>
                                @endif
                            </div>
                            <h4 class="text-sm font-bold text-[#0F1B4C] mb-1">{{ $reviewer->full_name }}</h4>
                            @if($reviewer->affiliation)
                                <p class="text-xs text-gray-600 line-clamp-2">{{ Str::limit($reviewer->affiliation, 40) }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
                @if($reviewers->count() > 12)
                    <div class="text-center mt-6">
                        <p class="text-gray-600">And {{ $reviewers->count() - 12 }} more reviewers...</p>
                    </div>
                @endif
            </div>
        @endif

        <!-- Additional Editorial Board Info -->
        @if($journal->editorial_board)
            <div class="bg-[#F7F9FC] rounded-2xl p-8 border-2 border-gray-200">
                <h3 class="text-2xl font-bold text-[#0F1B4C] mb-4">Editorial Board Information</h3>
                <div class="prose max-w-none text-gray-700 leading-relaxed">
                    {!! $journal->editorial_board !!}
                </div>
            </div>
        @endif

        <!-- Editorial Team (from Journal Content) -->
        @if($journal->editorial_team)
            <div class="bg-[#F7F9FC] rounded-2xl p-8 border-2 border-gray-200 mt-8">
                <h3 class="text-2xl font-bold text-[#0F1B4C] mb-4">Editorial Team</h3>
                <div class="prose max-w-none text-gray-700 leading-relaxed">
                    {!! $journal->editorial_team !!}
                </div>
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="mt-12 flex flex-wrap justify-center gap-4">
            <a href="{{ route('journals.show', $journal) }}" 
               class="btn bg-[#0F1B4C] hover:bg-[#0A1538] text-white px-8 py-3 rounded-lg font-semibold transition-colors shadow-lg">
                <i class="fas fa-arrow-left mr-2"></i>Back to Journal
            </a>
            <a href="{{ route('author.submissions.create', $journal) }}" 
               class="btn bg-[#0056FF] hover:bg-[#0044CC] text-white px-8 py-3 rounded-lg font-semibold transition-colors shadow-lg">
                <i class="fas fa-file-upload mr-2"></i>Submit Article
            </a>
        </div>
    </div>
</section>
@endsection
