@extends('layouts.app')

@section('title', 'Submission Successful - ' . $submission->journal->name . ' | EMANP')

@section('content')
    <!-- Hero Section -->
    <section class="bg-cisa-base text-white py-20 relative overflow-hidden">
        <!-- Premium Background Elements -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0"
                style="background-image: radial-gradient(circle, white 0.5px, transparent 0.5px); background-size: 30px 30px;">
            </div>
        </div>
        <div class="absolute -right-20 -bottom-20 w-96 h-96 bg-cisa-accent rounded-full opacity-5 blur-3xl"></div>
        <div class="absolute -left-20 -top-20 w-80 h-80 bg-white rounded-full opacity-5 blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center">
                <div class="inline-block mb-8 relative">
                    <div
                        class="w-32 h-32 bg-white/10 rounded-[2.5rem] flex items-center justify-center mx-auto border border-white/20 shadow-2xl backdrop-blur-sm rotate-3 group hover:rotate-0 transition-transform duration-500">
                        <div
                            class="w-24 h-24 bg-cisa-accent rounded-[2rem] flex items-center justify-center shadow-lg -rotate-6 group-hover:rotate-0 transition-transform duration-500">
                            <i class="fas fa-check text-4xl text-cisa-base"></i>
                        </div>
                    </div>
                    <!-- Sparkle Effects -->
                    <i class="fas fa-sparkles absolute -top-4 -right-4 text-cisa-accent animate-pulse"></i>
                    <i class="fas fa-sparkles absolute -bottom-2 -left-6 text-cisa-accent/50 animate-bounce"></i>
                </div>
                <div class="flex items-center justify-center gap-3 mb-4">
                    <span
                        class="px-3 py-1 bg-white/10 text-white text-[10px] font-black uppercase tracking-widest rounded-full border border-white/20">
                        Submission Milestone
                    </span>
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span>
                    <span class="text-xs font-bold text-slate-300">Journal Archive</span>
                </div>
                <h1 class="text-5xl md:text-6xl font-black mb-6 tracking-tight leading-tight">
                    Paper <span class="text-cisa-accent">Successfully</span> Submitted!
                </h1>
                <p class="text-xl text-slate-300 max-w-2xl mx-auto font-medium leading-relaxed">
                    Your intellectual contribution has been cataloged and transitioned into our elite editorial review
                    workflow.
                </p>
            </div>
        </div>
    </section>

    <!-- Breadcrumb -->
    <div class="bg-white border-b border-slate-100 sticky top-0 z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
            <nav class="flex items-center space-x-3 text-xs font-bold uppercase tracking-widest">
                <a href="{{ route('journals.index') }}"
                    class="text-slate-400 hover:text-cisa-base transition-colors flex items-center">
                    <i class="fas fa-home mr-2"></i> Core
                </a>
                <i class="fas fa-chevron-right text-slate-300 text-[10px]"></i>
                <a href="{{ route('author.submissions.index') }}"
                    class="text-slate-400 hover:text-cisa-base transition-colors">
                    Archival Repository
                </a>
                <i class="fas fa-chevron-right text-slate-300 text-[10px]"></i>
                <span class="text-cisa-base">Confirmation Protocol</span>
            </nav>
        </div>
    </div>

    <!-- Success Content -->
    <section class="bg-slate-50/50 py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="bg-white rounded-[3rem] shadow-2xl shadow-slate-200 p-10 md:p-16 border border-slate-100 relative overflow-hidden">
                <!-- Decorative Background -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-slate-50 rounded-full -mr-32 -mt-32 opacity-50"></div>

                <!-- Summary Header -->
                <div class="relative z-10 text-center mb-16">
                    <div
                        class="inline-flex items-center gap-2 px-6 py-2 bg-emerald-50 text-emerald-700 rounded-full border border-emerald-100 text-xs font-black uppercase tracking-widest mb-6">
                        <span class="relative flex h-2 w-2">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        Archived Successfully
                    </div>
                    <h2 class="text-3xl font-black text-cisa-base tracking-tight mb-4">Transmission Confirmed</h2>
                    <p class="text-slate-500 font-medium max-w-md mx-auto">Reference the identity parameters below to track
                        your manuscript through the peer-review cycle.</p>
                </div>

                <!-- Submission Info Card -->
                <div
                    class="bg-cisa-base rounded-[2rem] p-10 mb-12 border border-slate-800 shadow-2xl shadow-cisa-base/30 transition-all duration-500 relative overflow-hidden">
                    <!-- Gold Accent -->
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-cisa-accent/10 rounded-full -mr-16 -mt-16">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 relative z-10">
                        <div class="space-y-1">
                            <label
                                class="block text-[10px] font-black text-cisa-accent uppercase tracking-widest">Manuscript
                                Token</label>
                            <p
                                class="text-3xl font-black text-white tracking-tighter transition-colors">
                                #<span
                                    class="text-white">{{ str_pad($submission->id, 6, '0', STR_PAD_LEFT) }}</span>
                            </p>
                        </div>
                        <div class="space-y-1">
                            <label
                                class="block text-[10px] font-black text-cisa-accent uppercase tracking-widest">Workflow
                                Status</label>
                            <div
                                class="inline-flex items-center px-4 py-2 bg-white/10 text-white border border-white/20 rounded-xl transition-all shadow-sm">
                                <i class="fas fa-clock mr-2 text-cisa-accent pulse"></i>
                                <span class="text-sm font-black uppercase tracking-tight">Editorial Review</span>
                            </div>
                        </div>
                        <div
                            class="md:col-span-2 pt-6 border-t border-white/10 transition-colors">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                                <div>
                                    <label
                                        class="block text-[10px] font-black text-cisa-accent uppercase tracking-widest mb-2">Target
                                        Journal</label>
                                    <p class="text-lg font-black text-white tracking-tight">
                                        {{ $submission->journal->name }}</p>
                                </div>
                                <div class="text-left md:text-right">
                                    <label
                                        class="block text-[10px] font-black text-cisa-accent uppercase tracking-widest mb-2">Ingestion
                                        Date</label>
                                    <p class="text-sm font-bold text-slate-300">
                                        @if($submission->submitted_at)
                                            {{ \Carbon\Carbon::parse($submission->submitted_at)->format('d M, Y') }} at
                                            {{ \Carbon\Carbon::parse($submission->submitted_at)->format('H:i') }}
                                        @else
                                            {{ \Carbon\Carbon::parse($submission->created_at)->format('d M, Y') }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Primary Metadata -->
                <div class="space-y-10 mb-16 px-4">
                    <div class="relative pl-8 border-l-4 border-slate-100 hover:border-cisa-accent transition-colors py-2">
                        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Academic Title
                        </h3>
                        <p class="text-xl font-black text-cisa-base tracking-tight leading-tight">{{ $submission->title }}
                        </p>
                    </div>

                    @if($submission->journalSection)
                        <div class="relative pl-8 border-l-4 border-slate-100 hover:border-cisa-accent transition-colors py-2">
                            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Research Vertical
                            </h3>
                            <p class="text-lg font-bold text-slate-700 tracking-tight">{{ $submission->journalSection->title }}
                            </p>
                        </div>
                    @endif

                    <div class="relative pl-8 border-l-4 border-slate-100 hover:border-cisa-accent transition-colors py-2">
                        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Editorial Circle
                            (Authors)</h3>
                        <div class="flex flex-wrap gap-3">
                            @foreach($submission->authors as $author)
                                <div
                                    class="flex items-center gap-3 bg-slate-50 border border-slate-200 px-4 py-2 rounded-xl group/author hover:bg-white hover:shadow-lg transition-all">
                                    <div
                                        class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-[10px] font-black text-slate-500 border-2 border-white group-hover/author:bg-cisa-base group-hover/author:text-white transition-colors">
                                        {{ substr($author->first_name, 0, 1) }}{{ substr($author->last_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-cisa-base leading-none mb-1">{{ $author->first_name }}
                                            {{ $author->last_name }}</p>
                                        @if($author->is_corresponding)
                                            <span
                                                class="text-[9px] font-black uppercase tracking-widest text-cisa-accent flex items-center">
                                                <i class="fas fa-paper-plane mr-1 text-[8px]"></i> Corresponding
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Next Steps -->
                <div
                    class="bg-indigo-50/50 rounded-[2.5rem] p-10 mb-16 border border-indigo-100/50 relative overflow-hidden group">
                    <div
                        class="absolute -right-10 -bottom-10 w-40 h-40 bg-indigo-500/5 rounded-full group-hover:scale-110 transition-transform">
                    </div>
                    <h3 class="text-lg font-black text-cisa-base tracking-tight mb-8 flex items-center">
                        <div
                            class="w-10 h-10 bg-indigo-500 text-white rounded-xl flex items-center justify-center mr-4 shadow-lg shadow-indigo-500/20">
                            <i class="fas fa-layer-group text-sm"></i>
                        </div>
                        Editorial Lifecycle Phases
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="flex gap-5">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-white border border-indigo-100 rounded-lg flex items-center justify-center text-indigo-500 shadow-sm">
                                <i class="fas fa-search text-xs"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-black uppercase tracking-widest text-cisa-base mb-1">Qualitative
                                    Screening</h4>
                                <p class="text-xs text-slate-500 font-medium leading-relaxed italic">Initial compliance
                                    check by our lead editorial office.</p>
                            </div>
                        </div>
                        <div class="flex gap-5">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-white border border-indigo-100 rounded-lg flex items-center justify-center text-indigo-500 shadow-sm">
                                <i class="fas fa-users-viewfinder text-xs"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-black uppercase tracking-widest text-cisa-base mb-1">Peer
                                    Correlation</h4>
                                <p class="text-xs text-slate-500 font-medium leading-relaxed italic">Assignment to subject
                                    matter experts for blind review.</p>
                            </div>
                        </div>
                        <div class="flex gap-5">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-white border border-indigo-100 rounded-lg flex items-center justify-center text-indigo-500 shadow-sm">
                                <i class="fas fa-bell text-xs"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-black uppercase tracking-widest text-cisa-base mb-1">Status
                                    Notifications</h4>
                                <p class="text-xs text-slate-500 font-medium leading-relaxed italic">Automated alerts via
                                    your registered archival email.</p>
                            </div>
                        </div>
                        <div class="flex gap-5">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-white border border-indigo-100 rounded-lg flex items-center justify-center text-indigo-500 shadow-sm">
                                <i class="fas fa-chart-line text-xs"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-black uppercase tracking-widest text-cisa-base mb-1">Active
                                    Oversight</h4>
                                <p class="text-xs text-slate-500 font-medium leading-relaxed italic">Real-time tracking
                                    available through your portal.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col md:flex-row items-center justify-center gap-6 pt-10 border-t border-slate-100">
                    <a href="{{ route('author.submissions.show', $submission) }}"
                        class="w-full md:w-auto px-10 py-5 cisa-gradient text-white rounded-[1.5rem] font-black text-sm uppercase tracking-[0.2em] shadow-2xl shadow-cisa-base/40 hover:scale-[1.05] hover:-translate-y-1 transition-all flex items-center justify-center">
                        <i class="fas fa-fingerprint mr-3 text-cisa-accent"></i>Full Audit Log
                    </a>
                    <a href="{{ route('author.submissions.index') }}"
                        class="w-full md:w-auto px-10 py-5 bg-white text-cisa-base border-2 border-slate-100 rounded-[1.5rem] font-black text-sm uppercase tracking-[0.2em] hover:bg-slate-50 hover:border-slate-200 transition-all text-center">
                        Repository Overview
                    </a>
                    <a href="{{ route('journals.show', $submission->journal) }}"
                        class="w-full md:w-auto px-10 py-5 bg-slate-900 text-slate-400 rounded-[1.5rem] font-black text-[10px] uppercase tracking-[0.2em] hover:text-white transition-all text-center">
                        Exit Sequence
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection