@extends('layouts.app')

@section('title', $journal->name . ' - Contact Us | EMANP')

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
            <h2 class="text-2xl md:text-3xl font-semibold text-blue-200 mb-2">Contact Us</h2>
            <p class="text-lg text-blue-100 max-w-3xl mx-auto">
                Get in touch with our editorial team
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
            <span class="text-gray-600">Contact Us</span>
        </nav>
    </div>
</div>

<!-- Main Content -->
<section class="bg-white py-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Contact Information -->
            <div class="space-y-6">
                <div class="bg-white rounded-2xl shadow-xl border-2 border-gray-100 p-8">
                    <h2 class="text-2xl font-bold text-[#0F1B4C] mb-6">Contact Information</h2>
                    
                    @if($journal->contact_email)
                        <div class="mb-6 p-4 bg-[#F7F9FC] rounded-lg border border-gray-200 hover:border-[#0056FF] transition-colors">
                            <div class="flex items-center mb-2">
                                <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-envelope text-white text-xl"></i>
                                </div>
                                <h3 class="text-lg font-bold text-[#0F1B4C]">Email</h3>
                            </div>
                            <a href="mailto:{{ $journal->contact_email }}" 
                               class="text-[#0056FF] hover:text-[#0044CC] transition-colors text-lg font-semibold">
                                {{ $journal->contact_email }}
                            </a>
                        </div>
                    @endif

                    @if($journal->contact_phone)
                        <div class="mb-6 p-4 bg-[#F7F9FC] rounded-lg border border-gray-200 hover:border-[#0056FF] transition-colors">
                            <div class="flex items-center mb-2">
                                <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-phone text-white text-xl"></i>
                                </div>
                                <h3 class="text-lg font-bold text-[#0F1B4C]">Phone</h3>
                            </div>
                            <a href="tel:{{ $journal->contact_phone }}" 
                               class="text-[#0056FF] hover:text-[#0044CC] transition-colors text-lg font-semibold">
                                {{ $journal->contact_phone }}
                            </a>
                        </div>
                    @endif

                    @if($journal->contact_address)
                        <div class="mb-6 p-4 bg-[#F7F9FC] rounded-lg border border-gray-200 hover:border-[#0056FF] transition-colors">
                            <div class="flex items-center mb-2">
                                <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-map-marker-alt text-white text-xl"></i>
                                </div>
                                <h3 class="text-lg font-bold text-[#0F1B4C]">Address</h3>
                            </div>
                            <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $journal->contact_address }}</p>
                        </div>
                    @endif

                    @if(!$journal->contact_email && !$journal->contact_phone && !$journal->contact_address)
                        <div class="text-center py-12">
                            <i class="fas fa-envelope text-gray-400 text-6xl mb-4"></i>
                            <h3 class="text-2xl font-bold text-gray-700 mb-2">Contact Information Coming Soon</h3>
                            <p class="text-gray-600">Contact details will be available soon.</p>
                        </div>
                    @endif
                </div>

                <!-- Quick Links -->
                <div class="bg-[#F7F9FC] rounded-2xl p-6 border-2 border-gray-200">
                    <h3 class="text-xl font-bold text-[#0F1B4C] mb-4">Quick Links</h3>
                    <div class="space-y-3">
                        <a href="{{ route('journals.aims-scope', $journal) }}" 
                           class="flex items-center text-[#0056FF] hover:text-[#0044CC] transition-colors">
                            <i class="fas fa-file-alt mr-3"></i>
                            <span>Aims & Scope</span>
                        </a>
                        <a href="{{ route('journals.editorial-board', $journal) }}" 
                           class="flex items-center text-[#0056FF] hover:text-[#0044CC] transition-colors">
                            <i class="fas fa-users mr-3"></i>
                            <span>Editorial Board</span>
                        </a>
                        <a href="{{ route('journals.submission-guidelines', $journal) }}" 
                           class="flex items-center text-[#0056FF] hover:text-[#0044CC] transition-colors">
                            <i class="fas fa-file-upload mr-3"></i>
                            <span>Submission Guidelines</span>
                        </a>
                        <a href="{{ route('author.submissions.create', $journal) }}" 
                           class="flex items-center text-[#0056FF] hover:text-[#0044CC] transition-colors">
                            <i class="fas fa-paper-plane mr-3"></i>
                            <span>Submit Article</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="bg-white rounded-2xl shadow-xl border-2 border-gray-100 p-8">
                <h2 class="text-2xl font-bold text-[#0F1B4C] mb-6">Send us a Message</h2>
                <form action="#" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Your Name</label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               required
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors">
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Your Email</label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               required
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors">
                    </div>
                    
                    <div>
                        <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">Subject</label>
                        <input type="text" 
                               id="subject" 
                               name="subject" 
                               required
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors">
                    </div>
                    
                    <div>
                        <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">Message</label>
                        <textarea id="message" 
                                  name="message" 
                                  rows="6" 
                                  required
                                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors resize-none"></textarea>
                    </div>
                    
                    <button type="submit" 
                            class="w-full bg-[#0056FF] hover:bg-[#0044CC] text-white py-4 rounded-lg font-bold text-lg transition-colors shadow-lg transform hover:scale-[1.02]">
                        <i class="fas fa-paper-plane mr-2"></i>Send Message
                    </button>
                </form>
            </div>
        </div>

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
