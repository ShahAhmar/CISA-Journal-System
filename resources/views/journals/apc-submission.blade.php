@extends('layouts.app')

@section('title', 'APC & Submission - ' . $journal->name)

@section('content')
    <!-- Hero Section -->
    <div class="bg-cisa-base text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10">
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <h1 class="text-5xl md:text-6xl font-serif font-bold mb-6">APC & Submissions</h1>
            <p class="text-xl text-gray-300 max-w-3xl leading-relaxed">
                Transparent publishing costs, mandatory submission fees, and our streamlined author process.
            </p>
        </div>
    </div>

    <!-- Content Section -->
    <div class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-20">

                <!-- Mandatory Submission Fee -->
                <div
                    class="bg-white rounded-3xl border-2 border-slate-50 p-10 shadow-sm relative overflow-hidden group hover:border-cisa-accent/20 transition-all">
                    <div
                        class="absolute top-0 right-0 bg-slate-100 px-4 py-1 text-[10px] font-bold uppercase tracking-widest text-slate-500 rounded-bl-xl">
                        Phase 1</div>
                    <h3 class="text-2xl font-bold text-cisa-base mb-6">Mandatory Submission Fee</h3>
                    <div class="flex items-baseline gap-2 mb-8">
                        <span class="text-5xl font-serif font-bold text-cisa-base">$25</span>
                        <span class="text-gray-400 font-medium">USD</span>
                    </div>
                    <ul class="space-y-4 mb-10">
                        <li class="flex items-start text-gray-600">
                            <i class="fas fa-check-circle text-cisa-accent mt-1 mr-3"></i>
                            <span>Payable immediately upon manuscript entry.</span>
                        </li>
                        <li class="flex items-start text-gray-600">
                            <i class="fas fa-check-circle text-cisa-accent mt-1 mr-3"></i>
                            <span>Covers preliminary screening & plagiarism checks.</span>
                        </li>
                        <li class="flex items-start text-gray-600">
                            <i class="fas fa-times-circle text-red-400 mt-1 mr-3"></i>
                            <span>Non-refundable (does not guarantee review or acceptance).</span>
                        </li>
                    </ul>
                    <div class="pt-6 border-t border-slate-50">
                        <p class="text-xs text-gray-400 font-medium italic">Required for all submissions prior to editorial
                            review.</p>
                    </div>
                </div>

                <!-- Article Processing Charge (APC) -->
                <div
                    class="bg-cisa-base rounded-3xl p-10 shadow-2xl relative overflow-hidden group border border-cisa-base">
                    <div
                        class="absolute top-0 right-0 bg-cisa-accent px-4 py-1 text-[10px] font-bold uppercase tracking-widest text-cisa-base rounded-bl-xl">
                        Phase 2</div>
                    <h3 class="text-2xl font-bold text-white mb-6">Article Processing Charge (APC)</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                        <div>
                            <span class="block text-[10px] font-bold text-cisa-accent uppercase tracking-widest mb-1">Africa
                                Based</span>
                            <span class="text-4xl font-serif font-bold text-white">$120</span>
                            <span class="text-white/40 text-xs ml-1">USD</span>
                        </div>
                        <div>
                            <span
                                class="block text-[10px] font-bold text-cisa-accent uppercase tracking-widest mb-1">International</span>
                            <span class="text-4xl font-serif font-bold text-white">$180</span>
                            <span class="text-white/40 text-xs ml-1">USD</span>
                        </div>
                    </div>

                    <ul class="space-y-4 mb-10 text-white/80">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-cisa-accent mt-1 mr-3"></i>
                            <span>Invoiced <strong>only after</strong> formal acceptance.</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-cisa-accent mt-1 mr-3"></i>
                            <span>Includes professional copyediting & PDF production.</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-cisa-accent mt-1 mr-3"></i>
                            <span>Covers permanent open-access hosting & DOI.</span>
                        </li>
                    </ul>
                    <div class="pt-6 border-t border-white/10">
                        <p class="text-xs text-white/40 font-medium italic">Wait for acceptance notification before making
                            this payment.</p>
                    </div>
                </div>

            </div>

            <!-- Content Area -->
            <div class="max-w-4xl mx-auto space-y-16">
                <!-- Payment Policies -->
                <section>
                    <h2 class="text-3xl font-serif font-bold text-cisa-base mb-8 flex items-center">
                        <span class="w-1.5 h-8 bg-cisa-accent mr-4 rounded-full"></span>
                        Payment Rules & Policies
                    </h2>
                    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed font-sans">
                        @if($journal->apc_policy)
                            {!! $journal->apc_policy !!}
                        @else
                            <p>We believe in transparent pricing to support sustainable gold open-access publishing. All fees
                                are used to offset the costs of peer review management, production, and permanent archival.</p>
                            <ul>
                                <li><strong>Waivers:</strong> Partial waivers may be available for authors from low-income
                                    countries. Please contact the Editor-in-Chief before submission.</li>
                                <li><strong>Payment Methods:</strong> We accept major credit/debit cards and bank transfers via
                                    our secure payment gateway.</li>
                                <li><strong>Author Choice:</strong> Authors select "Pay Now" for immediate processing or "Pay
                                    Later" (where applicable) during the submission flow.</li>
                            </ul>
                        @endif
                    </div>
                </section>

                <!-- Submission Process -->
                <section class="bg-slate-50 rounded-3xl p-10 border border-slate-100">
                    <h2 class="text-3xl font-serif font-bold text-cisa-base mb-8">Author Submission Process</h2>
                    <div class="space-y-6">
                        <div class="flex gap-4 items-start">
                            <div
                                class="w-10 h-10 bg-white rounded-xl shadow-sm border border-gray-100 flex items-center justify-center shrink-0 font-bold text-cisa-base">
                                1</div>
                            <p class="text-gray-600 pt-2">Register/Login to the CIJ Author Portal and start "New
                                Submission".</p>
                        </div>
                        <div class="flex gap-4 items-start">
                            <div
                                class="w-10 h-10 bg-white rounded-xl shadow-sm border border-gray-100 flex items-center justify-center shrink-0 font-bold text-cisa-base">
                                2</div>
                            <p class="text-gray-600 pt-2">Enter metadata, upload manuscript, and pay the <strong>$25
                                    Submission Fee</strong>.</p>
                        </div>
                        <div class="flex gap-4 items-start">
                            <div
                                class="w-10 h-10 bg-white rounded-xl shadow-sm border border-gray-100 flex items-center justify-center shrink-0 font-bold text-cisa-base">
                                3</div>
                            <p class="text-gray-600 pt-2">Manuscript undergoes Editorial Screening and Double-Blind Peer
                                Review.</p>
                        </div>
                        <div class="flex gap-4 items-start border-t border-slate-200 pt-6">
                            <div
                                class="w-10 h-10 bg-cisa-base text-white rounded-xl shadow-lg flex items-center justify-center shrink-0 font-bold">
                                4</div>
                            <p class="text-cisa-base font-bold pt-2">Upon successful acceptance, pay the <strong>APC
                                    Charge</strong> to move to production.</p>
                        </div>
                    </div>
                </section>

                <!-- Final CTA -->
                <div class="text-center pt-10">
                    <h3 class="text-3xl font-serif font-bold text-cisa-base mb-8">Ready to publish your research?</h3>
                    <div class="flex flex-wrap justify-center gap-6">
                        <a href="{{ route('author.submissions.create', $journal) }}"
                            class="px-12 py-5 bg-cisa-base text-white font-bold rounded-full hover:bg-cisa-accent hover:text-cisa-base transition-all shadow-xl shadow-cisa-base/20 uppercase tracking-wider text-sm">
                            Submit Manuscript
                        </a>
                        <a href="{{ route('journals.contact', $journal) }}"
                            class="px-12 py-5 bg-white border-2 border-slate-200 text-gray-500 font-bold rounded-full hover:border-cisa-base hover:text-cisa-base transition-all uppercase tracking-wider text-sm">
                            Contact Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    </div>
@endsection