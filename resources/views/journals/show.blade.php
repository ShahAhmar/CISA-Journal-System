@extends('layouts.app')

@section('title', $journal->name . ' - CISA')

@section('content')
    <!-- Journal Hero Slider Section -->
    <div class="relative bg-cisa-base text-white overflow-hidden py-16 md:py-20">
        <!-- Slider Background -->
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-gradient-to-br from-cisa-base via-cisa-light to-cisa-base opacity-20"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-cisa-base via-cisa-base/80 to-transparent"></div>
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10">
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-9 space-y-4">
                    <h1
                        class="text-3xl md:text-4xl lg:text-5xl font-serif font-bold leading-tight text-white drop-shadow-2xl mb-4">
                        {{ strip_tags($journal->name) }}
                    </h1>

                    <p class="text-base md:text-lg text-gray-200 leading-relaxed max-w-2xl font-light">
                        {{ $journal->description_excerpt ?? 'Promoting interdisciplinary research excellence and academic innovation through rigorous peer-reviewed publications.' }}
                    </p>

                    <div class="flex flex-wrap gap-4 pt-4">
                        <a href="{{ route('author.submissions.create', $journal) }}"
                            class="px-6 py-3 bg-cisa-accent text-cisa-base font-bold rounded-full hover:bg-white hover:text-cisa-base transition-all duration-300 transform hover:-translate-y-1 shadow-2xl shadow-cisa-accent/30 text-sm uppercase tracking-wide">
                            Submit Your Manuscript
                        </a>
                        <a href="{{ route('journals.publications', $journal) }}"
                            class="px-6 py-3 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white border-2 border-white/30 rounded-full font-bold transition-all duration-300 transform hover:-translate-y-1 text-sm uppercase tracking-wide">
                            Browse Publications
                        </a>
                    </div>

                    <div class="flex flex-wrap gap-3 mt-8">
                        <span
                            class="bg-cisa-accent text-cisa-base px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase shadow-lg shadow-cisa-accent/20">
                            {{ $journal->badge_text ?? 'Peer Reviewed & Open Access' }}
                        </span>
                        @if($journal->online_issn)
                            <span
                                class="bg-white/10 backdrop-blur-md border border-white/20 text-white px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase">
                                ISSN: {{ $journal->online_issn }}
                            </span>
                        @endif
                    </div>
                </div>


                <div class="lg:col-span-3 hidden lg:block">
                    <div class="relative group max-w-xs mx-auto">
                        @if($journal->cover_image)
                            <img src="{{ asset('storage/' . $journal->cover_image) }}" alt="{{ $journal->name }}"
                                class="w-full rounded-2xl shadow-[0_40px_80px_rgba(0,0,0,0.6)] border border-white/10 transform group-hover:scale-105 transition-all duration-500">
                        @else
                            <div
                                class="w-full aspect-[3/4] bg-white/5 backdrop-blur-lg rounded-2xl border border-white/10 flex items-center justify-center p-12 text-center transform rotate-2 group-hover:rotate-0 transition-transform duration-500">
                                <div>
                                    <i class="fas fa-scroll text-7xl text-cisa-accent/20 mb-6"></i>
                                    <div class="text-white font-serif text-2xl font-bold opacity-40">CISA CIJ</div>
                                </div>
                            </div>
                        @endif
                        <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-cisa-accent/20 blur-3xl rounded-full"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Sections -->
    <div class="bg-white">
        <!-- Intro & Featured Call -->
        <section class="py-10 border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h2 class="text-xl md:text-2xl font-serif font-bold text-cisa-base mb-3">Introduction to CIJ</h2>
                        <div class="prose prose-lg text-gray-600 leading-relaxed mb-6">
                            {!! Str::limit($journal->description, 400) !!}
                        </div>
                        <a href="{{ route('journals.about', $journal) }}"
                            class="text-cisa-base font-bold flex items-center group">
                            Read More About CIJ
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-2 transition-transform"></i>
                        </a>
                    </div>

                    @if($journal->call_for_papers)
                        <div class="bg-slate-50 rounded-3xl p-8 border border-slate-100 relative overflow-hidden shadow-md">
                            <div class="absolute top-0 right-0 p-4">
                                <span
                                    class="bg-red-500 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-tighter">Open
                                    Call</span>
                            </div>
                            <h3 class="text-xl md:text-2xl font-serif font-bold text-cisa-base mb-3">Featured Call for Papers
                            </h3>
                            <div class="text-gray-600 mb-6 line-clamp-3">
                                {!! strip_tags($journal->call_for_papers) !!}
                            </div>
                            <a href="{{ route('journals.call-for-papers', $journal) }}"
                                class="inline-block px-8 py-3 bg-cisa-base text-white rounded-full font-bold hover:bg-cisa-light transition-colors shadow-lg shadow-cisa-base/10">
                                View Details
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- Why Publish Section -->
        <section class="py-16 bg-slate-50 relative overflow-hidden">
            <div
                class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-cisa-accent/20 to-transparent">
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-serif font-bold text-cisa-base mb-4">Why Publish with CIJ?</h2>
                    <p class="text-gray-500 max-w-2xl mx-auto">We provide a platform that values quality, speed, and
                        visibility for your interdisciplinary research.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div
                        class="bg-white p-10 rounded-3xl shadow-md border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition-all group">
                        <div
                            class="w-16 h-16 bg-cisa-accent/10 text-cisa-base rounded-2xl flex items-center justify-center mb-6 px-4 group-hover:bg-cisa-accent group-hover:text-cisa-base transition-colors">
                            <i class="fas fa-bolt text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-cisa-base mb-3">Rapid Publication</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">Efficient editorial workflow ensuring first
                            decision within 3-4 weeks of submission.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div
                        class="bg-white p-10 rounded-3xl shadow-md border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition-all group">
                        <div
                            class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-6 px-4 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                            <i class="fas fa-globe-africa text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-cisa-base mb-3">Global Visibility</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">Open access model ensuring your research reaches
                            peers and institutions worldwide.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div
                        class="bg-white p-10 rounded-3xl shadow-md border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition-all group">
                        <div
                            class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-6 px-4 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                            <i class="fas fa-shield-halved text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-cisa-base mb-3">Academic Integrity</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">Strict double-blind peer review process maintaining
                            high academic standards and credibility.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Latest Publications -->
        <section class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-end justify-between mb-12">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-serif font-bold text-cisa-base mb-4">Latest Publications</h2>
                        <p class="text-gray-500">Discover recently published interdisciplinary research.</p>
                    </div>
                    <a href="{{ route('journals.publications', $journal) }}"
                        class="px-8 py-3 bg-white border-2 border-cisa-base text-cisa-base font-bold rounded-full hover:bg-cisa-base hover:text-white transition-all shadow-sm">
                        View All Articles
                    </a>
                </div>

                @if($recentArticles->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($recentArticles->take(6) as $article)
                            <div
                                class="flex flex-col h-full bg-white rounded-2xl border border-gray-100 shadow-md hover:shadow-xl transition-all p-8 group overflow-hidden relative">
                                <div class="mb-4">
                                    <span
                                        class="bg-slate-100 text-slate-500 text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">
                                        {{ $article->published_at ? \Carbon\Carbon::parse($article->published_at)->format('d M, Y') : 'Recent' }}
                                    </span>
                                </div>
                                <h3
                                    class="text-lg font-bold text-cisa-base mb-4 font-serif line-clamp-2 leading-tight group-hover:text-cisa-accent transition-colors">
                                    <a
                                        href="{{ route('journals.article', ['journal' => $journal->slug, 'submission' => $article->id]) }}">
                                        {{ $article->title }}
                                    </a>
                                </h3>
                                <div class="text-xs text-slate-400 mb-6 italic line-clamp-1">
                                    @foreach($article->authors as $author)
                                        {{ $author->full_name }}@if(!$loop->last), @endif
                                    @endforeach
                                </div>
                                <div class="mt-auto pt-6 border-t border-slate-50 flex items-center justify-between">
                                    <a href="{{ route('journals.article', ['journal' => $journal->slug, 'submission' => $article->id]) }}"
                                        class="text-cisa-base font-bold text-sm">Read More</a>
                                    <div class="flex gap-3">
                                        <a href="{{ route('journals.article.download', ['journal' => $journal->slug, 'submission' => $article->id]) }}"
                                            class="text-slate-400 hover:text-red-500 transition-colors">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-20 bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200">
                        <i class="fas fa-box-open text-5xl text-slate-200 mb-4 px-4"></i>
                        <p class="text-slate-400 font-medium">No published articles yet.</p>
                    </div>
                @endif
            </div>
        </section>

        <!-- Announcements -->
        <section class="py-16 bg-cisa-base text-white relative overflow-hidden">
            <div
                class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10">
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-16 items-center">
                    <div class="lg:col-span-1">
                        <h2 class="text-3xl md:text-4xl font-serif font-bold mb-4">Latest Updates</h2>
                        <p class="text-gray-400 mb-10 leading-relaxed">Stay informed about journal news, upcoming
                            conferences, and special issues.</p>
                        <a href="{{ route('journals.announcements', $journal) }}"
                            class="inline-block px-10 py-4 bg-cisa-accent text-cisa-base font-bold rounded-full hover:bg-white transition-all shadow-2xl shadow-cisa-accent/20 uppercase tracking-widest text-sm">
                            All Announcements
                        </a>
                    </div>

                    <div class="lg:col-span-2">
                        <div class="space-y-6">
                            @foreach($announcements->take(3) as $announcement)
                                <div
                                    class="bg-white/5 backdrop-blur-md border border-white/10 p-8 rounded-3xl hover:bg-white/10 transition-all group shadow-2xl shadow-black/20">
                                    <span class="text-cisa-accent text-xs font-bold uppercase tracking-widest mb-2 block">
                                        {{ $announcement->published_at ? \Carbon\Carbon::parse($announcement->published_at)->format('d M, Y') : '' }}
                                    </span>
                                    <h3 class="text-xl font-bold mb-4 group-hover:text-cisa-accent transition-colors">
                                        {{ $announcement->title }}
                                    </h3>
                                    <p class="text-gray-400 text-sm line-clamp-2 leading-relaxed">
                                        {{ strip_tags($announcement->content) }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Footer Section -->
        <section class="py-20 bg-white text-center">
            <div class="max-w-4xl mx-auto px-4">
                <h2 class="text-3xl md:text-4xl font-serif font-bold text-cisa-base mb-6">Ready to Share Your Research?</h2>
                <p class="text-lg text-gray-500 mb-8 leading-relaxed">Join our community of interdisciplinary scholars and
                    contribute to global knowledge.</p>
                <div class="flex flex-wrap justify-center gap-6">
                    <a href="{{ route('author.submissions.create', $journal) }}"
                        class="px-12 py-5 bg-cisa-base text-white font-bold rounded-full hover:bg-cisa-accent hover:text-cisa-base transition-all duration-300 transform hover:-translate-y-1 shadow-2xl shadow-cisa-base/20 text-lg uppercase tracking-wider">
                        Start Submission
                    </a>
                    <a href="{{ route('journals.contact', $journal) }}"
                        class="px-12 py-5 bg-slate-100 text-cisa-base border-2 border-slate-100 font-bold rounded-full hover:bg-white hover:border-cisa-base transition-all duration-300 transform hover:-translate-y-1 text-lg uppercase tracking-wider">
                        Contact Us
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection