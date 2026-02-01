@extends('layouts.app')

@section('title', $journal->name . ' - Author Guidelines | CISA')

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
                    <li class="text-white font-semibold">Author Guidelines</li>
                </ol>
            </nav>

            <div class="max-w-4xl">
                <h1 class="text-3xl md:text-5xl font-serif font-bold leading-tight mb-4 text-white text-shadow-sm">
                    Author Guidelines
                </h1>
                <p class="text-blue-100 text-lg font-light max-w-2xl">
                    Comprehensive guide for preparing and submitting your manuscript to {{ $journal->name }}.
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content Layout -->
    <div class="bg-slate-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

                <!-- Left Column (Guidelines Content) -->
                <div class="lg:col-span-2 space-y-12">

                    <!-- Submission Process -->
                    <section>
                        <div class="flex items-center mb-6">
                            <span class="w-1 h-8 bg-cisa-accent mr-3 rounded-full"></span>
                            <h2 class="text-2xl font-serif font-bold text-cisa-base">Submission Process</h2>
                        </div>

                        <div
                            class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden text-center md:text-left">
                            <div class="p-8 border-b border-gray-100 flex flex-col md:flex-row gap-6">
                                <div
                                    class="w-12 h-12 bg-cisa-base text-white rounded-full flex items-center justify-center flex-shrink-0 text-xl font-bold mx-auto md:mx-0">
                                    1</div>
                                <div>
                                    <h3 class="text-lg font-bold text-cisa-base mb-2">Create Account / Sign In</h3>
                                    <p class="text-gray-600 text-sm leading-relaxed mb-4">
                                        New authors must register to submit. Returning authors can simply sign in.
                                    </p>
                                    <div class="flex flex-wrap gap-2 justify-center md:justify-start">
                                        @auth
                                            <a href="{{ route('author.submissions.create', $journal) }}"
                                                class="btn-cisa-primary px-4 py-2 text-sm">Submit Article</a>
                                        @else
                                            <a href="{{ route('register') }}" class="btn-cisa-primary px-4 py-2 text-sm">Create
                                                Account</a>
                                            <a href="{{ route('login') }}" class="btn-cisa-outline px-4 py-2 text-sm">Sign
                                                In</a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                            <div class="p-8 border-b border-gray-100 flex flex-col md:flex-row gap-6 bg-slate-50/50">
                                <div
                                    class="w-12 h-12 bg-cisa-base text-white rounded-full flex items-center justify-center flex-shrink-0 text-xl font-bold mx-auto md:mx-0">
                                    2</div>
                                <div>
                                    <h3 class="text-lg font-bold text-cisa-base mb-2">Prepare Manuscript</h3>
                                    <p class="text-gray-600 text-sm leading-relaxed">
                                        Ensure your manuscript adheres to our formatting guidelines (PDF format, anonymized
                                        for review).
                                    </p>
                                </div>
                            </div>
                            <div class="p-8 flex flex-col md:flex-row gap-6">
                                <div
                                    class="w-12 h-12 bg-cisa-base text-white rounded-full flex items-center justify-center flex-shrink-0 text-xl font-bold mx-auto md:mx-0">
                                    3</div>
                                <div>
                                    <h3 class="text-lg font-bold text-cisa-base mb-2">Online Submission</h3>
                                    <p class="text-gray-600 text-sm leading-relaxed">
                                        Complete the 5-step wizard: Metadata, Upload, Co-authors, Details, Confirmation.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Detailed Guidelines -->
                    @if($journal->author_guidelines || $journal->submission_requirements)
                        <section>
                            <div class="flex items-center mb-6">
                                <span class="w-1 h-8 bg-cisa-accent mr-3 rounded-full"></span>
                                <h2 class="text-2xl font-serif font-bold text-cisa-base">Formatting & Requirements</h2>
                            </div>

                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 space-y-8">
                                @if($journal->author_guidelines)
                                    <div>
                                        <h3 class="text-xl font-serif font-bold text-cisa-base mb-4 border-b border-gray-100 pb-2">
                                            Manuscript Preparation</h3>
                                        <div class="prose prose-sm text-gray-700 max-w-none">
                                            {!! $journal->author_guidelines !!}
                                        </div>
                                    </div>
                                @endif

                                @if($journal->submission_requirements)
                                    <div>
                                        <h3 class="text-xl font-serif font-bold text-cisa-base mb-4 border-b border-gray-100 pb-2">
                                            Submission Requirements</h3>
                                        <div class="prose prose-sm text-gray-700 max-w-none">
                                            {!! $journal->submission_requirements !!}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </section>
                    @endif

                    <!-- Submission Checklist -->
                    @if($journal->submission_checklist)
                        <section>
                            <div class="bg-blue-50 border border-blue-100 rounded-xl p-8">
                                <div class="flex items-center mb-4">
                                    <i class="fas fa-tasks text-cisa-base text-2xl mr-3"></i>
                                    <h3 class="text-xl font-serif font-bold text-cisa-base">Submission Checklist</h3>
                                </div>
                                <div class="prose prose-sm text-gray-700 max-w-none">
                                    {!! $journal->submission_checklist !!}
                                </div>
                            </div>
                        </section>
                    @endif

                </div>

                <!-- Right Column (Sidebar) -->
                <div class="lg:col-span-1 space-y-8">

                    <!-- Downloads -->
                    <div class="bg-white rounded-xl shadow-glass border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-cisa-base mb-4 font-serif">Resources</h3>
                        <div class="space-y-3">
                            <a href="#"
                                class="flex items-start p-3 bg-slate-50 hover:bg-cisa-base hover:text-white rounded-lg transition-all group">
                                <i class="fas fa-file-word text-blue-600 text-xl mt-1 mr-3 group-hover:text-white"></i>
                                <div>
                                    <span class="font-bold text-sm block">Manuscript Template</span>
                                    <span class="text-xs text-gray-500 group-hover:text-gray-300">Download DOCX</span>
                                </div>
                            </a>
                            <a href="#"
                                class="flex items-start p-3 bg-slate-50 hover:bg-cisa-base hover:text-white rounded-lg transition-all group">
                                <i class="fas fa-file-pdf text-red-600 text-xl mt-1 mr-3 group-hover:text-white"></i>
                                <div>
                                    <span class="font-bold text-sm block">Copyright Agreement</span>
                                    <span class="text-xs text-gray-500 group-hover:text-gray-300">Download PDF</span>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Policies Info -->
                    <div class="bg-white rounded-xl shadow-glass border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-cisa-base mb-4 font-serif">Policies</h3>
                        <div class="space-y-4">
                            @if($journal->competing_interest_statement)
                                <div>
                                    <h4 class="text-sm font-bold text-gray-700 mb-1">Competing Interests</h4>
                                    <p class="text-xs text-gray-500 truncate">
                                        {!! strip_tags($journal->competing_interest_statement) !!}</p>
                                </div>
                            @endif
                            @if($journal->copyright_agreement)
                                <div>
                                    <h4 class="text-sm font-bold text-gray-700 mb-1">Copyright</h4>
                                    <p class="text-xs text-gray-500 truncate">{!! strip_tags($journal->copyright_agreement) !!}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Submit CTA Sidebar -->
                    <div class="bg-cisa-base rounded-xl p-8 text-white text-center shadow-lg relative overflow-hidden">
                        <div
                            class="absolute top-0 right-0 w-32 h-32 bg-cisa-accent rounded-full opacity-10 blur-2xl -mr-10 -mt-10">
                        </div>
                        <h3 class="font-bold font-serif text-xl mb-4 relative z-10">Ready to Publish?</h3>
                        <p class="text-sm text-gray-300 mb-6 relative z-10">
                            Join our community of published authors.
                        </p>
                        <a href="{{ route('author.submissions.create', $journal) }}"
                            class="btn-cisa-accent w-full block py-3 relative z-10">Start Submission</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection