@extends('layouts.app')

@section('title', $journal->name . ' - Author Guidelines')

@section('content')
    <!-- Hero Section -->
    <section class="bg-[#0F1B4C] text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0"
                style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 20px 20px;">
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <nav class="text-sm text-blue-200 mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2">
                    <li><a href="{{ route('journals.index') }}" class="hover:text-white transition-colors">Home</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li><a href="{{ route('journals.show', $journal) }}"
                            class="hover:text-white transition-colors">{{ $journal->name }}</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li class="text-white">Author Guidelines</li>
                </ol>
            </nav>

            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4"
                    style="font-family: 'Playfair Display', serif; font-weight: 700; letter-spacing: 0.03em; line-height: 1.2;">
                    Author Guidelines
                </h1>
                <p class="text-xl text-blue-100 max-w-2xl mx-auto"
                    style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.6;">
                    Everything you need to know before submitting your manuscript
                </p>
            </div>
        </div>
    </section>

    <!-- Core Information -->
    <section class="bg-white py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
                <!-- Types of Articles -->
                <div class="bg-purple-50 rounded-2xl p-8 border border-purple-100 shadow-sm">
                    <h3 class="text-2xl font-bold text-purple-900 mb-4 font-display">
                        <i class="fas fa-file-invoice mr-2"></i>Types of Articles
                    </h3>
                    <p class="text-gray-700 mb-4">CIJ accepts the following types of manuscripts:</p>
                    <ul class="space-y-3 text-gray-700">
                        <li class="flex items-center"><i
                                class="fas fa-check-circle text-purple-600 mr-2"></i><strong>Original Research:</strong>
                            Full-length research reports.</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-purple-600 mr-2"></i><strong>Review
                                Articles:</strong> Comprehensive summaries of existing research.</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-purple-600 mr-2"></i><strong>Case
                                Studies:</strong> Detailed examination of specific instances.</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-purple-600 mr-2"></i><strong>Short
                                Communications:</strong> Brief reports of significant findings.</li>
                    </ul>
                </div>

                <!-- Author Fees (APC) -->
                <div class="bg-blue-50 rounded-2xl p-8 border border-blue-100 shadow-sm">
                    <h3 class="text-2xl font-bold text-blue-900 mb-4 font-display">
                        <i class="fas fa-hand-holding-usd mr-2"></i>Author Fees (APC)
                    </h3>
                    <div class="space-y-4 text-gray-700">
                        <div class="p-4 bg-white rounded-xl border border-blue-200">
                            <p class="font-bold text-blue-700">Submission Fee: $25</p>
                            <p class="text-sm">Mandatory non-refundable fee due upon initial submission.</p>
                        </div>
                        <div class="p-4 bg-white rounded-xl border border-blue-200">
                            <p class="font-bold text-blue-700">Publication Fee (APC): $Varies</p>
                            <p class="text-sm">Charged only after the article is accepted for publication.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Plagiarism & AI Policy -->
            <div class="bg-red-50 rounded-2xl p-8 border border-red-100 shadow-sm mb-16">
                <h3 class="text-2xl font-bold text-red-900 mb-4 font-display">
                    <i class="fas fa-exclamation-triangle mr-2"></i>Plagiarism & AI Policy
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h4 class="font-bold text-red-800 mb-2">Zero Tolerance for Plagiarism</h4>
                        <p class="text-gray-700 text-sm leading-relaxed">
                            All submissions are screened using professional tools. Plagiarism exceeding 10% (excluding
                            citations) will result in immediate rejection.
                        </p>
                    </div>
                    <div>
                        <h4 class="font-bold text-red-800 mb-2">AI Usage Policy</h4>
                        <p class="text-gray-700 text-sm leading-relaxed">
                            <strong>No AI usage allowed:</strong> The use of large language models (LLMs) or AI tools to
                            generate manuscript content is strictly prohibited. AI usage must be clearly disclosed if used
                            for basic editing.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Ethical Statements -->
            <div class="bg-gray-50 rounded-2xl p-8 border border-gray-200 shadow-sm mb-16">
                <h3 class="text-2xl font-bold text-gray-900 mb-4 font-display">
                    <i class="fas fa-balance-scale mr-2"></i>Ethics & Malpractice
                </h3>
                <div class="prose prose-purple max-w-none text-gray-700">
                    <p>CIJ follows the COPE (Committee on Publication Ethics) guidelines. Key points include:</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                        <ul class="text-sm">
                            <li><strong>Authorship:</strong> Only those who made significant contributions.</li>
                            <li><strong>Disclosure:</strong> Financial or political conflicts must be stated.</li>
                        </ul>
                        <ul class="text-sm">
                            <li><strong>Data Integrity:</strong> Fabricated or falsified data is grounds for a lifetime ban.
                            </li>
                            <li><strong>Peer Review:</strong> Double-blind process to ensure impartiality.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-[#0F1B4C] mb-4"
                    style="font-family: 'Playfair Display', serif; font-weight: 700;">
                    Submission Process
                </h2>
                <div class="w-24 h-1 bg-[#0056FF] mx-auto rounded-full"></div>
            </div>

            <div class="space-y-6">
                <div class="bg-[#F7F9FC] rounded-xl border-2 border-gray-200 p-8">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center text-white font-bold text-xl flex-shrink-0"
                            style="font-family: 'Inter', sans-serif; font-weight: 700;">
                            1
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-[#0F1B4C] mb-3"
                                style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                Create Account / Sign In
                            </h3>
                            <p class="text-gray-700 leading-relaxed"
                                style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.8;">
                                If you're new to {{ $journal->name }}, you'll need to create an author account. Existing
                                authors can sign in to access their dashboard and manage submissions.
                            </p>
                            <div class="mt-4">
                                @auth
                                    <a href="{{ route('author.submissions.create', $journal) }}"
                                        class="inline-block bg-[#0056FF] hover:bg-[#0044CC] text-white px-6 py-3 rounded-lg font-semibold transition-colors"
                                        style="font-family: 'Inter', sans-serif; font-weight: 600;">
                                        <i class="fas fa-file-upload mr-2"></i>Submit Article
                                    </a>
                                @else
                                    <a href="{{ route('register') }}"
                                        class="inline-block bg-[#0056FF] hover:bg-[#0044CC] text-white px-6 py-3 rounded-lg font-semibold transition-colors mr-3"
                                        style="font-family: 'Inter', sans-serif; font-weight: 600;">
                                        <i class="fas fa-user-plus mr-2"></i>Create Account
                                    </a>
                                    <a href="{{ route('login') }}"
                                        class="inline-block bg-white hover:bg-gray-50 text-[#0056FF] border-2 border-[#0056FF] px-6 py-3 rounded-lg font-semibold transition-colors"
                                        style="font-family: 'Inter', sans-serif; font-weight: 600;">
                                        <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-[#F7F9FC] rounded-xl border-2 border-gray-200 p-8">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center text-white font-bold text-xl flex-shrink-0"
                            style="font-family: 'Inter', sans-serif; font-weight: 700;">
                            2
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-[#0F1B4C] mb-3"
                                style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                Fill Metadata Form
                            </h3>
                            <p class="text-gray-700 leading-relaxed mb-4"
                                style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.8;">
                                Complete the submission form with all required information:
                            </p>
                            <ul class="list-disc list-inside space-y-2 text-gray-700"
                                style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.8;">
                                <li>Article title</li>
                                <li>Abstract (150-300 words)</li>
                                <li>Keywords (5-8 keywords)</li>
                                <li>Article type (Research Article, Review, Case Study, etc.)</li>
                                <li>Subject area</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="bg-[#F7F9FC] rounded-xl border-2 border-gray-200 p-8">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center text-white font-bold text-xl flex-shrink-0"
                            style="font-family: 'Inter', sans-serif; font-weight: 700;">
                            3
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-[#0F1B4C] mb-3"
                                style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                Upload Manuscript PDF
                            </h3>
                            <p class="text-gray-700 leading-relaxed"
                                style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.8;">
                                Upload your manuscript in PDF format. Ensure the file follows our formatting guidelines and
                                is properly anonymized for peer review.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-[#F7F9FC] rounded-xl border-2 border-gray-200 p-8">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center text-white font-bold text-xl flex-shrink-0"
                            style="font-family: 'Inter', sans-serif; font-weight: 700;">
                            4
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-[#0F1B4C] mb-3"
                                style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                Add Co-Authors
                            </h3>
                            <p class="text-gray-700 leading-relaxed"
                                style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.8;">
                                Add all co-authors with their full names, affiliations, and email addresses. Ensure the
                                order of authors is correct as it cannot be changed after submission.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-[#F7F9FC] rounded-xl border-2 border-gray-200 p-8">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center text-white font-bold text-xl flex-shrink-0"
                            style="font-family: 'Inter', sans-serif; font-weight: 700;">
                            5
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-[#0F1B4C] mb-3"
                                style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                Accept Copyright Agreement
                            </h3>
                            <p class="text-gray-700 leading-relaxed"
                                style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.8;">
                                Review and accept the copyright agreement. By submitting, you confirm that the manuscript is
                                original, has not been published elsewhere, and all authors have agreed to the submission.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Formatting Rules -->
    @if($journal->author_guidelines || $journal->submission_requirements)
        <section class="bg-[#F7F9FC] py-16">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-[#0F1B4C] mb-4"
                        style="font-family: 'Playfair Display', serif; font-weight: 700;">
                        Formatting Rules
                    </h2>
                    <div class="w-24 h-1 bg-[#0056FF] mx-auto rounded-full"></div>
                </div>

                @if($journal->author_guidelines)
                    <div class="bg-white rounded-xl border-2 border-gray-200 p-8 mb-6">
                        <h3 class="text-2xl font-bold text-[#0F1B4C] mb-4"
                            style="font-family: 'Playfair Display', serif; font-weight: 700;">
                            <i class="fas fa-file-alt mr-3 text-[#0056FF]"></i>Author Guidelines
                        </h3>
                        <div class="prose max-w-none text-gray-700 leading-relaxed"
                            style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.8;">
                            {!! $journal->author_guidelines !!}
                        </div>
                    </div>
                @endif

                @if($journal->submission_requirements)
                    <div class="bg-white rounded-xl border-2 border-gray-200 p-8 mb-6">
                        <h3 class="text-2xl font-bold text-[#0F1B4C] mb-4"
                            style="font-family: 'Playfair Display', serif; font-weight: 700;">
                            <i class="fas fa-clipboard-check mr-3 text-[#0056FF]"></i>Submission Requirements
                        </h3>
                        <div class="prose max-w-none text-gray-700 leading-relaxed"
                            style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.8;">
                            {!! $journal->submission_requirements !!}
                        </div>
                    </div>
                @endif
            </div>
        </section>
    @endif

    <!-- Citation Guidelines -->
    <section class="bg-white py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-[#0F1B4C] mb-4"
                    style="font-family: 'Playfair Display', serif; font-weight: 700;">
                    Citation Guidelines
                </h2>
                <div class="w-24 h-1 bg-[#0056FF] mx-auto rounded-full"></div>
            </div>

            <div class="bg-[#F7F9FC] rounded-xl border-2 border-gray-200 p-8">
                <p class="text-gray-700 leading-relaxed mb-6"
                    style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.8;">
                    All references should follow a consistent citation style. We recommend using APA, MLA, or Chicago style.
                    Ensure all in-text citations have corresponding entries in the references section.
                </p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
                        <h4 class="font-bold text-[#0F1B4C] mb-2"
                            style="font-family: 'Inter', sans-serif; font-weight: 700;">APA Style</h4>
                        <p class="text-sm text-gray-600" style="font-family: 'Inter', sans-serif; font-weight: 400;">
                            American Psychological Association</p>
                    </div>
                    <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
                        <h4 class="font-bold text-[#0F1B4C] mb-2"
                            style="font-family: 'Inter', sans-serif; font-weight: 700;">MLA Style</h4>
                        <p class="text-sm text-gray-600" style="font-family: 'Inter', sans-serif; font-weight: 400;">Modern
                            Language Association</p>
                    </div>
                    <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
                        <h4 class="font-bold text-[#0F1B4C] mb-2"
                            style="font-family: 'Inter', sans-serif; font-weight: 700;">Chicago Style</h4>
                        <p class="text-sm text-gray-600" style="font-family: 'Inter', sans-serif; font-weight: 400;">Chicago
                            Manual of Style</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Template Download -->
    <section class="bg-[#F7F9FC] py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl border-2 border-gray-200 p-8 text-center">
                <div class="w-20 h-20 bg-[#0056FF] rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-download text-white text-3xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-[#0F1B4C] mb-4"
                    style="font-family: 'Playfair Display', serif; font-weight: 700;">
                    Manuscript Template
                </h2>
                <p class="text-gray-700 mb-6" style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.8;">
                    Download our manuscript template to ensure your submission follows the correct format.
                </p>
                <a href="#"
                    class="inline-block bg-[#0056FF] hover:bg-[#0044CC] text-white px-8 py-4 rounded-lg font-bold text-lg transition-colors shadow-lg transform hover:scale-105"
                    style="font-family: 'Inter', sans-serif; font-weight: 700;">
                    <i class="fas fa-file-word mr-2"></i>Download Template (DOCX)
                </a>
            </div>
        </div>
    </section>

    <!-- Checklist -->
    @if($journal->submission_checklist)
        <section class="bg-white py-16">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-[#0F1B4C] mb-4"
                        style="font-family: 'Playfair Display', serif; font-weight: 700;">
                        Submission Checklist
                    </h2>
                    <div class="w-24 h-1 bg-[#0056FF] mx-auto rounded-full"></div>
                </div>

                <div class="bg-[#F7F9FC] rounded-xl border-2 border-gray-200 p-8">
                    <div class="prose max-w-none text-gray-700 leading-relaxed"
                        style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.8;">
                        {!! $journal->submission_checklist !!}
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Policies -->
    @if($journal->competing_interest_statement || $journal->copyright_agreement)
        <section class="bg-[#F7F9FC] py-16">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-[#0F1B4C] mb-4"
                        style="font-family: 'Playfair Display', serif; font-weight: 700;">
                        Policies
                    </h2>
                    <div class="w-24 h-1 bg-[#0056FF] mx-auto rounded-full"></div>
                </div>

                @if($journal->competing_interest_statement)
                    <div class="bg-white rounded-xl border-2 border-gray-200 p-8 mb-6">
                        <h3 class="text-2xl font-bold text-[#0F1B4C] mb-4"
                            style="font-family: 'Playfair Display', serif; font-weight: 700;">
                            <i class="fas fa-balance-scale mr-3 text-[#0056FF]"></i>Competing Interest Statement
                        </h3>
                        <div class="prose max-w-none text-gray-700 leading-relaxed"
                            style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.8;">
                            {!! $journal->competing_interest_statement !!}
                        </div>
                    </div>
                @endif

                @if($journal->copyright_agreement)
                    <div class="bg-white rounded-xl border-2 border-gray-200 p-8">
                        <h3 class="text-2xl font-bold text-[#0F1B4C] mb-4"
                            style="font-family: 'Playfair Display', serif; font-weight: 700;">
                            <i class="fas fa-copyright mr-3 text-[#0056FF]"></i>Copyright Agreement
                        </h3>
                        <div class="prose max-w-none text-gray-700 leading-relaxed"
                            style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.8;">
                            {!! $journal->copyright_agreement !!}
                        </div>
                    </div>
                @endif
            </div>
        </section>
    @endif

    <!-- CTA -->
    <section class="bg-gradient-to-r from-[#0056FF] to-[#1D72B8] py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6"
                style="font-family: 'Playfair Display', serif; font-weight: 700;">
                Ready to Submit?
            </h2>
            <p class="text-xl text-blue-100 mb-8"
                style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.6;">
                Start your submission process now
            </p>
            @auth
                <a href="{{ route('author.submissions.create', $journal) }}"
                    class="inline-block bg-white hover:bg-gray-50 text-[#0056FF] px-8 py-4 rounded-lg font-bold text-lg transition-colors shadow-lg transform hover:scale-105"
                    style="font-family: 'Inter', sans-serif; font-weight: 700;">
                    <i class="fas fa-file-upload mr-2"></i>Submit Article
                </a>
            @else
                <div class="flex gap-4 justify-center">
                    <a href="{{ route('register') }}"
                        class="inline-block bg-white hover:bg-gray-50 text-[#0056FF] px-8 py-4 rounded-lg font-bold text-lg transition-colors shadow-lg transform hover:scale-105"
                        style="font-family: 'Inter', sans-serif; font-weight: 700;">
                        <i class="fas fa-user-plus mr-2"></i>Create Account
                    </a>
                    <a href="{{ route('login') }}"
                        class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg font-bold text-lg transition-colors shadow-lg transform hover:scale-105"
                        style="font-family: 'Inter', sans-serif; font-weight: 700;">
                        <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                    </a>
                </div>
            @endauth
        </div>
    </section>
@endsection