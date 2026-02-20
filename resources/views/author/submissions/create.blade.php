@extends('layouts.app')

@section('title', 'Submit Article - ' . $journal->name . ' | EMANP')

@push('styles')
<style>
    [x-cloak] { display: none !important; }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="bg-[#0F1B4C] text-white py-12 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 20px 20px;"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center">
            <h1 class="text-3xl md:text-4xl font-bold mb-2" style="font-family: 'Playfair Display', serif; font-weight: 700;">
                Submit Article to {{ $journal->name }}
            </h1>
            <p class="text-lg text-blue-200">Complete the form below to submit your manuscript</p>
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
            <span class="text-gray-600">Submit Article</span>
        </nav>
    </div>
</div>

<!-- Form Section -->
<section class="bg-[#F7F9FC] py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('author.submissions.store', $journal) }}" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-xl border-2 border-gray-100 p-8 md:p-12">
            @csrf
            <div class="space-y-8">
                <!-- Article Title -->
                <div>
                    <label for="title" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                        Article Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           required 
                           value="{{ old('title') }}"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900"
                           style="font-family: 'Inter', sans-serif; font-weight: 400;"
                           placeholder="Enter the title of your article">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Abstract -->
                <div>
                    <label for="abstract" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                        Abstract <span class="text-red-500">*</span>
                    </label>
                    <textarea id="abstract" 
                              name="abstract" 
                              rows="8" 
                              required
                              class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors resize-none text-gray-900"
                              style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.6;"
                              placeholder="Provide a comprehensive abstract of your article (200-300 words recommended)">{{ old('abstract') }}</textarea>
                    @error('abstract')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Keywords -->
                <div>
                    <label for="keywords" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                        Keywords <span class="text-gray-500 font-normal text-xs">(comma-separated)</span>
                    </label>
                    <input type="text" 
                           id="keywords" 
                           name="keywords" 
                           value="{{ old('keywords') }}" 
                           placeholder="keyword1, keyword2, keyword3"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900"
                           style="font-family: 'Inter', sans-serif; font-weight: 400;">
                    @error('keywords')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Section -->
                <div>
                    <label for="section" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                        Section
                    </label>
                    <input type="text" 
                           id="section" 
                           name="section" 
                           value="{{ old('section') }}"
                           placeholder="e.g., Research Article, Review Article, Case Study"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900"
                           style="font-family: 'Inter', sans-serif; font-weight: 400;">
                    @error('section')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Authors Section -->
                <div>
                    <label class="block text-sm font-bold text-[#0F1B4C] mb-4" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                        Authors <span class="text-red-500">*</span>
                    </label>
                    <div id="authors-container" class="space-y-4">
                        <div class="author-entry bg-[#F7F9FC] border-2 border-gray-200 rounded-xl p-6 hover:border-[#0056FF] transition-colors">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2" style="font-family: 'Inter', sans-serif; font-weight: 600;">
                                        First Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           name="authors[0][first_name]" 
                                           required 
                                           value="{{ old('authors.0.first_name', auth()->user()->first_name) }}"
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900"
                                           style="font-family: 'Inter', sans-serif; font-weight: 400;">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2" style="font-family: 'Inter', sans-serif; font-weight: 600;">
                                        Last Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           name="authors[0][last_name]" 
                                           required 
                                           value="{{ old('authors.0.last_name', auth()->user()->last_name) }}"
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900"
                                           style="font-family: 'Inter', sans-serif; font-weight: 400;">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2" style="font-family: 'Inter', sans-serif; font-weight: 600;">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" 
                                           name="authors[0][email]" 
                                           required 
                                           value="{{ old('authors.0.email', auth()->user()->email) }}"
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900"
                                           style="font-family: 'Inter', sans-serif; font-weight: 400;">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2" style="font-family: 'Inter', sans-serif; font-weight: 600;">
                                        Affiliation
                                    </label>
                                    <input type="text" 
                                           name="authors[0][affiliation]" 
                                           value="{{ old('authors.0.affiliation', auth()->user()->affiliation) }}"
                                           placeholder="University, Institution, etc."
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900"
                                           style="font-family: 'Inter', sans-serif; font-weight: 400;">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2" style="font-family: 'Inter', sans-serif; font-weight: 600;">
                                    ORCID
                                </label>
                                <input type="text" 
                                       name="authors[0][orcid]" 
                                       value="{{ old('authors.0.orcid', auth()->user()->orcid) }}"
                                       placeholder="0000-0000-0000-0000"
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900"
                                       style="font-family: 'Inter', sans-serif; font-weight: 400;">
                            </div>
                        </div>
                    </div>
                    <button type="button" 
                            id="add-author" 
                            class="mt-4 bg-[#F7F9FC] hover:bg-[#0056FF] hover:text-white text-[#0056FF] border-2 border-[#0056FF] px-6 py-2.5 rounded-lg font-semibold transition-colors text-sm"
                            style="font-family: 'Inter', sans-serif; font-weight: 600;">
                        <i class="fas fa-plus mr-2"></i>Add Another Author
                    </button>
                </div>

                <!-- Manuscript Upload -->
                <div>
                    <label for="manuscript" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                        Manuscript <span class="text-red-500">*</span> <span class="text-gray-500 font-normal text-xs">(PDF, DOC, DOCX)</span>
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-[#0056FF] transition-colors bg-[#F7F9FC]">
                        <input type="file" 
                               id="manuscript" 
                               name="manuscript" 
                               required 
                               accept=".pdf,.doc,.docx"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#0056FF] file:text-white hover:file:bg-[#0044CC] file:cursor-pointer cursor-pointer"
                               style="font-family: 'Inter', sans-serif;">
                        <p class="text-sm text-gray-500 mt-2" style="font-family: 'Inter', sans-serif;">
                            <i class="fas fa-info-circle mr-1"></i>Maximum file size: 10MB
                        </p>
                    </div>
                    @error('manuscript')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Cover Letter Upload -->
                <div>
                    <label for="cover_letter" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                        Cover Letter <span class="text-gray-500 font-normal text-xs">(Optional)</span>
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-[#0056FF] transition-colors bg-[#F7F9FC]">
                        <input type="file" 
                               id="cover_letter" 
                               name="cover_letter" 
                               accept=".pdf,.doc,.docx"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#0056FF] file:text-white hover:file:bg-[#0044CC] file:cursor-pointer cursor-pointer"
                               style="font-family: 'Inter', sans-serif;">
                        <p class="text-sm text-gray-500 mt-2" style="font-family: 'Inter', sans-serif;">
                            <i class="fas fa-info-circle mr-1"></i>Maximum file size: 5MB
                        </p>
                    </div>
                    @error('cover_letter')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex flex-col sm:flex-row justify-end gap-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('journals.show', $journal) }}" 
                       class="px-8 py-3 bg-white hover:bg-gray-50 text-[#0F1B4C] border-2 border-[#0F1B4C] rounded-lg font-semibold text-center transition-colors"
                       style="font-family: 'Inter', sans-serif; font-weight: 600;">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </a>
                    <button type="submit" 
                            class="px-8 py-3 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors shadow-lg transform hover:scale-105"
                            style="font-family: 'Inter', sans-serif; font-weight: 600;">
                        <i class="fas fa-paper-plane mr-2"></i>Submit Article
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
    let authorCount = 1;
    document.getElementById('add-author').addEventListener('click', function() {
        const container = document.getElementById('authors-container');
        const newAuthor = document.createElement('div');
        newAuthor.className = 'author-entry bg-[#F7F9FC] border-2 border-gray-200 rounded-xl p-6 hover:border-[#0056FF] transition-colors';
        newAuthor.innerHTML = `
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2" style="font-family: 'Inter', sans-serif; font-weight: 600;">
                        First Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="authors[${authorCount}][first_name]" required 
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900"
                           style="font-family: 'Inter', sans-serif; font-weight: 400;">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2" style="font-family: 'Inter', sans-serif; font-weight: 600;">
                        Last Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="authors[${authorCount}][last_name]" required 
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900"
                           style="font-family: 'Inter', sans-serif; font-weight: 400;">
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2" style="font-family: 'Inter', sans-serif; font-weight: 600;">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="authors[${authorCount}][email]" required 
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900"
                           style="font-family: 'Inter', sans-serif; font-weight: 400;">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2" style="font-family: 'Inter', sans-serif; font-weight: 600;">
                        Affiliation
                    </label>
                    <input type="text" name="authors[${authorCount}][affiliation]" 
                           placeholder="University, Institution, etc."
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900"
                           style="font-family: 'Inter', sans-serif; font-weight: 400;">
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2" style="font-family: 'Inter', sans-serif; font-weight: 600;">
                    ORCID
                </label>
                <input type="text" name="authors[${authorCount}][orcid]" 
                       placeholder="0000-0000-0000-0000"
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900"
                       style="font-family: 'Inter', sans-serif; font-weight: 400;">
            </div>
            <button type="button" class="remove-author bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-semibold text-sm transition-colors">
                <i class="fas fa-trash mr-2"></i>Remove Author
            </button>
        `;
        container.appendChild(newAuthor);
        authorCount++;
        
        newAuthor.querySelector('.remove-author').addEventListener('click', function() {
            newAuthor.remove();
        });
    });
</script>
@endsection
