@extends('layouts.app')

@section('title', 'Editorial & Ethics - ' . $journal->name)

@section('content')
    <!-- Hero Section -->
    <div class="bg-cisa-base text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <h1 class="text-5xl md:text-6xl font-serif font-bold mb-6">Editorial Board & Ethics</h1>
            <p class="text-xl text-gray-300 max-w-3xl leading-relaxed">
                Academic governance, peer review integrity, and our commitment to the highest ethical standards in scholarly publishing.
            </p>
        </div>
    </div>

    <!-- Content Section -->
    <div class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">

                <!-- Main Content -->
                <div class="lg:col-span-8 space-y-20">

                    <!-- Editorial Board -->
                    <section id="board">
                        <h2 class="text-3xl font-serif font-bold text-cisa-base mb-10 flex items-center">
                            <span class="w-1.5 h-8 bg-cisa-accent mr-4 rounded-full"></span>
                            Editorial Board
                        </h2>

                        <!-- Board Content from Settings -->
                        <div class="space-y-10">
                            @if($journal->editor_in_chief)
                                <div class="bg-slate-50 p-8 rounded-3xl border border-slate-100">
                                    <h3 class="text-xl font-bold text-cisa-base mb-6 flex items-center">
                                        <i class="fas fa-user-tie mr-3 text-cisa-accent"></i>
                                        Editor-in-Chief
                                    </h3>
                                    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                                        {!! $journal->editor_in_chief !!}
                                    </div>
                                </div>
                            @endif

                            @if($journal->editorial_board_members)
                                <div class="bg-white p-8 rounded-3xl border-2 border-slate-50 shadow-sm">
                                    <h3 class="text-xl font-bold text-cisa-base mb-6 flex items-center">
                                        <i class="fas fa-users-cog mr-3 text-cisa-accent"></i>
                                        Editorial Board Members
                                    </h3>
                                    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                                        {!! $journal->editorial_board_members !!}
                                    </div>
                                </div>
                            @endif

                            <!-- Board Members Loop (For Registered Users) -->
                            @if($editors && $editors->count() > 0)
                                <div class="grid grid-cols-1 gap-8">
                                    @foreach($editors as $editor)
                                    <div class="flex flex-col md:flex-row gap-8 items-start bg-slate-50/50 p-8 rounded-3xl border border-slate-100 group hover:bg-white hover:shadow-xl transition-all">
                                        <div class="shrink-0">
                                            @if($editor->profile_image)
                                                <img src="{{ asset('storage/' . $editor->profile_image) }}" alt="{{ $editor->name }}" class="w-24 h-24 rounded-2xl object-cover shadow-lg border-2 border-white group-hover:scale-110 transition-transform">
                                            @else
                                                <div class="w-24 h-24 bg-cisa-base text-cisa-accent rounded-2xl flex items-center justify-center text-3xl shadow-lg border-2 border-white group-hover:scale-110 transition-transform">
                                                    <i class="fas fa-user-graduate"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow">
                                            <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                                                <div>
                                                    <h3 class="text-xl font-bold text-cisa-base">{{ $editor->name }}</h3>
                                                    <p class="text-cisa-accent font-bold text-sm tracking-widest uppercase">{{ $editor->role }}</p>
                                                </div>
                                                @if($editor->orcid)
                                                <a href="https://orcid.org/{{ $editor->orcid }}" target="_blank" class="flex items-center text-xs bg-white px-3 py-1 rounded-full border border-gray-100 hover:text-green-600">
                                                    <i class="fab fa-orcid mr-2 text-green-500"></i> ORCID
                                                </a>
                                                @endif
                                            </div>
                                            <p class="text-gray-600 text-sm leading-relaxed mb-4 font-bold">{{ $editor->affiliation }}</p>
                                            <div class="prose prose-sm text-gray-500 line-clamp-3 italic">
                                                {!! $editor->bio !!}
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @endif

                            @if(!$journal->editor_in_chief && !$journal->editorial_board_members && (!$editors || $editors->count() == 0))
                                <div class="p-12 text-center bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200">
                                    <p class="text-slate-400">Editorial board details are currently being updated.</p>
                                </div>
                            @endif
                        </div>
                    </section>

                    <!-- Ethics Policies -->
                    <section id="ethics" class="bg-white rounded-3xl p-10 border-2 border-slate-50 shadow-sm">
                        <h2 class="text-3xl font-serif font-bold text-cisa-base mb-10 flex items-center">
                            <span class="w-1.5 h-8 bg-cisa-accent mr-4 rounded-full"></span>
                            Ethics & Malpractice
                        </h2>

                        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed space-y-6">
                            @if($journal->ethics_policy)
                                {!! $journal->ethics_policy !!}
                            @else
                                <p>CISA CIJ strictly adheres to the COPE (Committee on Publication Ethics) guidelines. We maintain a zero-tolerance policy towards plagiarism, data falsification, and authorship manipulation.</p>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                                    <div class="p-6 bg-slate-50 rounded-2xl border border-gray-100">
                                        <h4 class="font-bold text-cisa-base mb-3">Authorship</h4>
                                        <p class="text-sm text-gray-600">All authors must have significantly contributed to the research and agreed to the submission.</p>
                                    </div>
                                    <div class="p-6 bg-slate-50 rounded-2xl border border-gray-100">
                                        <h4 class="font-bold text-cisa-base mb-3">Plagiarism</h4>
                                        <p class="text-sm text-gray-600">All manuscripts are screened using professional plagiarism detection software.</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Malpractice Highlight -->
                        <div class="mt-12 bg-red-50 p-8 rounded-3xl border border-red-100 relative overflow-hidden">
                            <div class="absolute top-0 right-0 p-4 opacity-10">
                                <i class="fas fa-shield-alt text-6xl text-red-600"></i>
                            </div>
                            <h4 class="text-xl font-bold text-red-900 mb-4 flex items-center">
                                <i class="fas fa-exclamation-circle mr-3"></i>
                                Malpractice Statement
                            </h4>
                            <p class="text-red-800 text-sm leading-relaxed relative z-10">
                                Proven misconduct, including plagiarism or fraudulent data, will result in immediate rejection or retraction of the article and a permanent ban from future submissions to CIJ.
                            </p>
                        </div>
                    </section>

                </div>

                <!-- Sidebar -> CTAs -->
                <div class="lg:col-span-4">
                    <div class="sticky top-24 space-y-8">
                        <!-- Submit CTA -->
                        <div class="bg-cisa-base text-white p-10 rounded-3xl shadow-2xl relative overflow-hidden">
                            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-cisa-accent rounded-full opacity-10 blur-2xl"></div>
                            <h3 class="text-2xl font-serif font-bold mb-4">Advance Research</h3>
                            <p class="text-gray-300 text-sm mb-8 leading-relaxed">Submit your manuscript today and undergo our rigorous peer review process.</p>
                            <a href="{{ route('author.submissions.create', $journal) }}"
                                class="w-full block text-center bg-cisa-accent text-cisa-base font-bold py-4 rounded-full hover:bg-white transition-all shadow-xl">
                                Submit Your Manuscript
                            </a>
                        </div>

                        <!-- Join Board CTA -->
                        <div class="bg-slate-50 p-10 rounded-3xl border border-slate-100 shadow-sm text-center">
                            <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-sm border border-gray-100">
                                <i class="fas fa-user-plus text-cisa-base"></i>
                            </div>
                            <h3 class="text-xl font-bold text-cisa-base mb-4">Join Our Reviewers</h3>
                            <p class="text-gray-600 text-sm mb-8 leading-relaxed">We are always looking for dedicated scholars to join our peer review community.</p>
                            <a href="{{ route('journals.contact', $journal) }}"
                                class="w-full block font-bold text-cisa-base hover:text-cisa-accent transition-colors">
                                Apply as a Reviewer <i class="fas fa-arrow-right ml-2 text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection