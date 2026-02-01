@extends('layouts.app')

@section('title', $journal->name . ' - Editorial Board | CISA')

@section('content')
    <!-- Hero Section -->
    <div class="relative bg-cisa-base text-white overflow-hidden min-h-[350px] flex items-center">
        <!-- Dynamic Background Layer -->
        <div class="absolute inset-0 z-0">
            @if($journal->cover_image)
                <div class="absolute inset-0 bg-cover bg-center blur-3xl opacity-30 transform scale-110"
                    style="background-image: url('{{ asset('storage/' . $journal->cover_image) }}');">
                </div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-r from-cisa-base via-cisa-base/90 to-transparent"></div>
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10">
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full py-16">
            <nav class="flex mb-6 text-sm text-gray-300" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2">
                    <li><a href="{{ route('journals.index') }}" class="hover:text-cisa-accent transition-colors">Home</a>
                    </li>
                    <li><i class="fas fa-chevron-right text-xs opacity-50"></i></li>
                    <li><a href="{{ route('journals.show', $journal) }}"
                            class="hover:text-cisa-accent transition-colors">{{ $journal->name }}</a></li>
                    <li><i class="fas fa-chevron-right text-xs opacity-50"></i></li>
                    <li class="text-white font-semibold">Editorial Board</li>
                </ol>
            </nav>

            <div class="max-w-4xl">
                <h1 class="text-3xl md:text-5xl font-serif font-bold leading-tight mb-4 text-white text-shadow-sm">
                    Editorial Board
                </h1>
                <p class="text-blue-100 text-lg font-light max-w-2xl">
                    Meet the distinguished scholars and experts guiding the scientific direction of this journal.
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-slate-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Editors-in-Chief (Text Content) -->
            @if($journal->editor_in_chief)
                <section class="mb-16">
                    <div class="flex items-center mb-8 justify-center">
                        <span class="w-12 h-1 bg-cisa-accent rounded-full mr-4"></span>
                        <h2 class="text-3xl font-serif font-bold text-cisa-base">Editor-in-Chief</h2>
                        <span class="w-12 h-1 bg-cisa-accent rounded-full ml-4"></span>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-10 max-w-4xl mx-auto text-center">
                        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed font-serif">
                            {!! $journal->editor_in_chief !!}
                        </div>
                    </div>
                </section>
            @endif

            <!-- Managing Editor (Text Content) -->
            @if($journal->managing_editor)
                <section class="mb-16">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-serif font-bold text-cisa-base">Managing Editor</h2>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-3xl mx-auto text-center">
                        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                            {!! $journal->managing_editor !!}
                        </div>
                    </div>
                </section>
            @endif

            <!-- Section Editors (Text Content) -->
            @if($journal->section_editors)
                <section class="mb-16">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-serif font-bold text-cisa-base">Section Editors</h2>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-4xl mx-auto">
                        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                            {!! $journal->section_editors !!}
                        </div>
                    </div>
                </section>
            @endif

            <!-- Database Editors Grid -->
            @if($editors->count() > 0)
                <section class="mb-16">
                    <div class="flex items-center mb-8">
                        <span class="w-1 h-8 bg-cisa-accent mr-3 rounded-full"></span>
                        <h2 class="text-2xl font-serif font-bold text-cisa-base">Editorial Team</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($editors as $editor)
                            <div
                                class="bg-white rounded-xl border border-gray-100 p-6 flex items-start gap-4 hover:shadow-lg transition-all group hover:border-cisa-accent/30">
                                <div class="flex-shrink-0">
                                    @if($editor->profile_image)
                                        <img src="{{ asset('storage/' . $editor->profile_image) }}" alt="{{ $editor->full_name }}"
                                            class="w-16 h-16 object-cover rounded-full border-2 border-white shadow-sm group-hover:scale-105 transition-transform"
                                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div
                                            class="w-16 h-16 bg-cisa-light text-white rounded-full flex items-center justify-center border-2 border-white shadow-sm hidden">
                                            <span class="font-bold text-lg">{{ substr($editor->first_name, 0, 1) }}</span>
                                        </div>
                                    @else
                                        <div
                                            class="w-16 h-16 bg-gradient-to-br from-cisa-base to-cisa-light text-white rounded-full flex items-center justify-center border-2 border-white shadow-sm">
                                            <span class="font-bold text-lg">{{ substr($editor->first_name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h3
                                        class="font-bold text-cisa-base text-lg leading-tight mb-1 group-hover:text-cisa-accent transition-colors">
                                        {{ $editor->full_name }}</h3>
                                    @if($editor->pivot->section)
                                        <p class="text-xs font-bold text-cisa-accent uppercase tracking-wider mb-1">
                                            {{ $editor->pivot->section }}</p>
                                    @endif
                                    @if($editor->affiliation)
                                        <p class="text-sm text-gray-500 italic leading-snug">{{ $editor->affiliation }}</p>
                                    @endif
                                    @if($editor->orcid)
                                        <a href="https://orcid.org/{{ $editor->orcid }}" target="_blank"
                                            class="inline-flex items-center text-xs text-green-600 mt-2 hover:underline">
                                            <i class="fab fa-orcid mr-1"></i> ORCID
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            <!-- Database Section Editors Grid -->
            @if($sectionEditors->count() > 0)
                <section class="mb-16">
                    <div class="flex items-center mb-8">
                        <span class="w-1 h-8 bg-cisa-accent mr-3 rounded-full"></span>
                        <h2 class="text-2xl font-serif font-bold text-cisa-base">Associate Editors</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($sectionEditors as $editor)
                            <div
                                class="bg-white rounded-xl border border-gray-100 p-6 flex items-start gap-4 hover:shadow-lg transition-all group hover:border-cisa-accent/30">
                                <div class="flex-shrink-0">
                                    @if($editor->profile_image)
                                        <img src="{{ asset('storage/' . $editor->profile_image) }}" alt="{{ $editor->full_name }}"
                                            class="w-14 h-14 object-cover rounded-full border-2 border-white shadow-sm group-hover:scale-105 transition-transform"
                                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div
                                            class="w-14 h-14 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center border-2 border-white shadow-sm hidden">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    @else
                                        <div
                                            class="w-14 h-14 bg-gray-100 text-gray-500 rounded-full flex items-center justify-center border-2 border-white shadow-sm">
                                            <span class="font-bold">{{ substr($editor->first_name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="font-bold text-cisa-base text-base leading-tight mb-1">{{ $editor->full_name }}</h3>
                                    @if($editor->pivot->section)
                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">
                                            {{ $editor->pivot->section }}</p>
                                    @endif
                                    @if($editor->affiliation)
                                        <p class="text-sm text-gray-500 leading-snug">{{ $editor->affiliation }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            <!-- Reviewers -->
            @if($reviewers->count() > 0)
                <section class="mb-16">
                    <div class="bg-white rounded-xl p-8 border border-gray-100 shadow-sm">
                        <div class="flex items-center mb-8">
                            <span class="w-1 h-8 bg-cisa-accent mr-3 rounded-full"></span>
                            <h2 class="text-2xl font-serif font-bold text-cisa-base">Reviewer Panel</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($reviewers->take(20) as $reviewer)
                                <div class="flex items-center p-3 rounded-lg hover:bg-slate-50 transition-colors">
                                    <div class="w-2 h-2 bg-cisa-accent rounded-full mr-3"></div>
                                    <div>
                                        <h4 class="font-bold text-gray-800 text-sm">{{ $reviewer->full_name }}</h4>
                                        @if($reviewer->affiliation)
                                            <p class="text-xs text-gray-500">{{ Str::limit($reviewer->affiliation, 50) }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if($reviewers->count() > 20)
                            <div class="text-center mt-8 pt-6 border-t border-gray-100">
                                <span class="text-sm text-gray-500">And {{ $reviewers->count() - 20 }} more expert reviewers
                                    contribute to our rigorous peer review process.</span>
                            </div>
                        @endif
                    </div>
                </section>
            @endif

            <!-- Additional Information -->
            @if($journal->editorial_board || $journal->editorial_team || $journal->editorial_board_members)
                <section class="max-w-4xl mx-auto space-y-8">
                    @if($journal->editorial_board_members)
                        <div class="bg-white rounded-xl p-8 border border-gray-100">
                            <h3 class="text-xl font-bold text-cisa-base mb-4 font-serif">Board Members</h3>
                            <div class="prose max-w-none text-gray-600">
                                {!! $journal->editorial_board_members !!}
                            </div>
                        </div>
                    @endif

                    @if($journal->editorial_board)
                        <div class="bg-white rounded-xl p-8 border border-gray-100">
                            <h3 class="text-xl font-bold text-cisa-base mb-4 font-serif">Board Policy</h3>
                            <div class="prose max-w-none text-gray-600">
                                {!! $journal->editorial_board !!}
                            </div>
                        </div>
                    @endif

                    @if($journal->editorial_team)
                        <div class="bg-white rounded-xl p-8 border border-gray-100">
                            <h3 class="text-xl font-bold text-cisa-base mb-4 font-serif">Executive Team</h3>
                            <div class="prose max-w-none text-gray-600">
                                {!! $journal->editorial_team !!}
                            </div>
                        </div>
                    @endif
                </section>
            @endif

        </div>
    </div>
@endsection