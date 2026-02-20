@extends('layouts.app')

@section('title', 'Submit Article - ' . $journal->name . ' | EMANP')

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
            <p class="text-lg text-blue-200">Follow the steps below to submit your manuscript</p>
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

<!-- Multi-Step Form -->
<section class="bg-[#F7F9FC] py-12" x-data="submissionForm()" x-init="
    // Auto-scroll to form on load if there are errors
    @if($errors->any())
        setTimeout(() => {
            document.getElementById('submission-form-container')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 100);
    @endif
">
    <div id="submission-form-container" class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Progress Steps -->
        <div class="bg-white rounded-2xl shadow-xl border-2 border-gray-100 p-6 mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4 flex-1">
                    <template x-for="(step, index) in steps" :key="index">
                        <div class="flex items-center flex-1">
                            <div class="flex items-center">
                                <div class="flex items-center justify-center w-10 h-10 rounded-full border-2 transition-colors"
                                     :class="currentStep > index ? 'bg-[#0056FF] border-[#0056FF] text-white' : (currentStep === index ? 'border-[#0056FF] text-[#0056FF]' : 'border-gray-300 text-gray-400')">
                                    <span x-show="currentStep > index"><i class="fas fa-check"></i></span>
                                    <span x-show="currentStep <= index" x-text="index + 1"></span>
                                </div>
                                <span class="ml-3 font-semibold text-sm hidden md:block"
                                      :class="currentStep >= index ? 'text-[#0F1B4C]' : 'text-gray-400'"
                                      x-text="step.title"></span>
                            </div>
                            <div x-show="index < steps.length - 1" class="flex-1 mx-4 hidden md:block">
                                <div class="h-1 rounded-full"
                                     :class="currentStep > index ? 'bg-[#0056FF]' : 'bg-gray-200'"></div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('author.submissions.store', $journal) }}" enctype="multipart/form-data" id="submissionForm" @submit.prevent="submitForm">
            @csrf
            
            <!-- Step 1: Start Submission -->
            <div x-show="currentStep === 0" class="bg-white rounded-2xl shadow-xl border-2 border-gray-100 p-8 md:p-12">
                <h2 class="text-2xl font-bold text-[#0F1B4C] mb-6">Step 1: Start Submission</h2>
                
                <!-- Section Selection -->
                <div class="mb-8">
                    <label class="block text-sm font-bold text-[#0F1B4C] mb-4">
                        Select Section <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($sections as $section)
                        <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition-all hover:border-[#0056FF] hover:bg-blue-50"
                               :class="formData.journal_section_id == {{ $section->id }} ? 'border-[#0056FF] bg-blue-50' : 'border-gray-200'">
                            <input type="radio" name="journal_section_id" value="{{ $section->id }}" 
                                   x-model="formData.journal_section_id"
                                   {{ old('journal_section_id') == $section->id ? 'checked' : '' }}
                                   class="mr-3">
                            <div class="flex-1">
                                <div class="font-semibold text-[#0F1B4C]">{{ $section->title }}</div>
                                @if($section->description)
                                <div class="text-sm text-gray-600 mt-1">{{ $section->description }}</div>
                                @endif
                                @if($section->word_limit_min || $section->word_limit_max)
                                <div class="text-xs text-gray-500 mt-1">
                                    Word limit: 
                                    @if($section->word_limit_min){{ $section->word_limit_min }}@endif
                                    @if($section->word_limit_min && $section->word_limit_max) - @endif
                                    @if($section->word_limit_max){{ $section->word_limit_max }}@endif
                                </div>
                                @endif
                            </div>
                        </label>
                        @empty
                        <div class="col-span-2 p-4 bg-gray-50 rounded-lg text-gray-600">
                            <i class="fas fa-info-circle mr-2"></i>No sections available for this journal.
                        </div>
                        @endforelse
                    </div>
                    @error('journal_section_id')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submission Requirements -->
                <div class="mb-8">
                    <label class="block text-sm font-bold text-[#0F1B4C] mb-4">
                        Submission Requirements <span class="text-red-500">*</span>
                    </label>
                    <div class="bg-[#F7F9FC] border-2 border-gray-200 rounded-lg p-6 mb-4">
                        @if(!empty($submissionRequirements) || !empty($submissionChecklist))
                            @if(!empty($submissionRequirements))
                        <div class="mb-4">
                            <h4 class="font-semibold text-[#0F1B4C] mb-2">Requirements:</h4>
                            <div class="prose max-w-none text-sm">
                                {!! $submissionRequirements !!}
                            </div>
                        </div>
                        @endif
                            @if(!empty($submissionChecklist))
                        <div>
                            <h4 class="font-semibold text-[#0F1B4C] mb-2">Checklist:</h4>
                            <div class="prose max-w-none text-sm">
                                {!! $submissionChecklist !!}
                            </div>
                        </div>
                            @endif
                        @else
                            <div class="text-gray-600 text-sm">
                                <i class="fas fa-info-circle mr-2"></i>No specific requirements or checklist available for this journal. Please ensure your manuscript follows standard academic guidelines.
                            </div>
                        @endif
                    </div>
                    <label class="flex items-start">
                        <input type="checkbox" name="requirements_accepted" value="1" required
                               x-model="formData.requirements_accepted"
                               {{ old('requirements_accepted') ? 'checked' : '' }}
                               class="mt-1 mr-3">
                        <span class="text-sm text-gray-700">
                            I confirm that my manuscript meets all the requirements listed above <span class="text-red-500">*</span>
                        </span>
                    </label>
                    @error('requirements_accepted')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Privacy Statement -->
                @if($privacyStatement)
                <div class="mb-8">
                    <label class="block text-sm font-bold text-[#0F1B4C] mb-4">
                        Privacy Statement <span class="text-red-500">*</span>
                    </label>
                    <div class="bg-[#F7F9FC] border-2 border-gray-200 rounded-lg p-6 mb-4 max-h-60 overflow-y-auto">
                        <div class="prose max-w-none text-sm">
                            {!! $privacyStatement !!}
                        </div>
                    </div>
                    <label class="flex items-start">
                        <input type="checkbox" name="privacy_accepted" value="1" required
                               x-model="formData.privacy_accepted"
                               {{ old('privacy_accepted') ? 'checked' : '' }}
                               class="mt-1 mr-3">
                        <span class="text-sm text-gray-700">
                            I have read and agree to the Privacy Statement <span class="text-red-500">*</span>
                        </span>
                    </label>
                    @error('privacy_accepted')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
                @endif

                <!-- Navigation -->
                <div class="flex justify-end mt-8">
                    <button type="button" @click="nextStep()" 
                            :disabled="!canProceed(0)"
                            class="px-8 py-3 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        Next: Upload Files <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </div>

            <!-- Step 2: Upload Files -->
            <div x-show="currentStep === 1" class="bg-white rounded-2xl shadow-xl border-2 border-gray-100 p-8 md:p-12">
                <h2 class="text-2xl font-bold text-[#0F1B4C] mb-6">Step 2: Upload Submission Files</h2>
                
                <!-- Main Manuscript -->
                <div class="mb-6">
                    <label class="block text-sm font-bold text-[#0F1B4C] mb-2">
                        Main Manuscript <span class="text-red-500">*</span>
                        <span class="text-gray-500 font-normal text-xs">(Word Document - DOC/DOCX)</span>
                    </label>
                    <div class="border-2 border-dashed rounded-lg p-6 hover:border-[#0056FF] transition-colors bg-[#F7F9FC] {{ $errors->has('manuscript') ? 'border-red-500' : 'border-gray-300' }}">
                        <input type="file" name="manuscript" id="manuscript" required 
                               accept=".doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                               @change="handleFileSelect($event, 'manuscript'); validateManuscriptFile($event)"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#0056FF] file:text-white hover:file:bg-[#0044CC] file:cursor-pointer cursor-pointer">
                        <p class="text-sm text-gray-500 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>Maximum file size: 10MB. Only DOC/DOCX files are accepted.
                        </p>
                        <div x-show="formData.files.manuscript" class="mt-2 text-sm text-green-600">
                            <i class="fas fa-check-circle mr-1"></i>
                            <span x-text="formData.files.manuscript"></span>
                        </div>
                        <div x-show="formData.manuscriptError" class="mt-2 text-sm text-red-600" x-cloak>
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            <span x-text="formData.manuscriptError"></span>
                        </div>
                    </div>
                    @error('manuscript')
                        <p class="text-red-500 text-sm mt-2">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Title Page (for blind review) -->
                @if($journal->review_method === 'double_blind')
                <div class="mb-6">
                    <label class="block text-sm font-bold text-[#0F1B4C] mb-2">
                        Title Page (Without Author Information) <span class="text-red-500">*</span>
                        <span class="text-gray-500 font-normal text-xs">(For Double-Blind Review)</span>
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-[#0056FF] transition-colors bg-[#F7F9FC]">
                        <input type="file" name="title_page" id="title_page" accept=".doc,.docx,.pdf"
                               @change="handleFileSelect($event, 'title_page')"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#0056FF] file:text-white hover:file:bg-[#0044CC] file:cursor-pointer cursor-pointer">
                        <p class="text-sm text-gray-500 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>Remove author names and affiliations for blind review
                        </p>
                        <div x-show="formData.files.title_page" class="mt-2 text-sm text-green-600">
                            <i class="fas fa-check-circle mr-1"></i>
                            <span x-text="formData.files.title_page"></span>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Figures -->
                <div class="mb-6">
                    <label class="block text-sm font-bold text-[#0F1B4C] mb-2">
                        Figures <span class="text-gray-500 font-normal text-xs">(Optional - PNG, JPG)</span>
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-[#0056FF] transition-colors bg-[#F7F9FC]">
                        <input type="file" name="figures[]" id="figures" multiple accept=".png,.jpg,.jpeg"
                               @change="handleFileSelect($event, 'figures', true)"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#0056FF] file:text-white hover:file:bg-[#0044CC] file:cursor-pointer cursor-pointer">
                        <p class="text-sm text-gray-500 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>You can upload multiple figure files
                        </p>
                        <div x-show="formData.files.figures && formData.files.figures.length > 0" class="mt-2">
                            <div class="text-sm text-green-600 mb-1">
                                <i class="fas fa-check-circle mr-1"></i>Selected files:
                            </div>
                            <ul class="text-sm text-gray-600 list-disc list-inside">
                                <template x-for="(file, index) in formData.files.figures" :key="index">
                                    <li x-text="file"></li>
                                </template>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Tables -->
                <div class="mb-6">
                    <label class="block text-sm font-bold text-[#0F1B4C] mb-2">
                        Tables <span class="text-gray-500 font-normal text-xs">(Optional - DOC, DOCX, XLS, XLSX)</span>
                    </label>
                    <div class="border-2 border-dashed rounded-lg p-6 hover:border-[#0056FF] transition-colors bg-[#F7F9FC] {{ $errors->has('tables.*') || $errors->has('tables.0') ? 'border-red-500' : 'border-gray-300' }}">
                        <input type="file" name="tables[]" id="tables" multiple accept=".doc,.docx,.xls,.xlsx"
                               @change="handleFileSelect($event, 'tables', true)"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#0056FF] file:text-white hover:file:bg-[#0044CC] file:cursor-pointer cursor-pointer">
                        <p class="text-sm text-gray-500 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>You can upload multiple table files. Accepted formats: DOC, DOCX, XLS, XLSX
                        </p>
                        @error('tables.*')
                            <p class="text-red-500 text-sm mt-2">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                        @error('tables.0')
                            <p class="text-red-500 text-sm mt-2">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                        <div x-show="formData.files.tables && formData.files.tables.length > 0" class="mt-2">
                            <div class="text-sm text-green-600 mb-1">
                                <i class="fas fa-check-circle mr-1"></i>Selected files:
                            </div>
                            <ul class="text-sm text-gray-600 list-disc list-inside">
                                <template x-for="(file, index) in formData.files.tables" :key="index">
                                    <li x-text="file"></li>
                                </template>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Supplementary Files -->
                <div class="mb-6">
                    <label class="block text-sm font-bold text-[#0F1B4C] mb-2">
                        Supplementary Files <span class="text-gray-500 font-normal text-xs">(Optional)</span>
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-[#0056FF] transition-colors bg-[#F7F9FC]">
                        <input type="file" name="supplementary[]" id="supplementary" multiple
                               @change="handleFileSelect($event, 'supplementary', true)"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#0056FF] file:text-white hover:file:bg-[#0044CC] file:cursor-pointer cursor-pointer">
                        <p class="text-sm text-gray-500 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>Any additional supporting files
                        </p>
                        <div x-show="formData.files.supplementary && formData.files.supplementary.length > 0" class="mt-2">
                            <div class="text-sm text-green-600 mb-1">
                                <i class="fas fa-check-circle mr-1"></i>Selected files:
                            </div>
                            <ul class="text-sm text-gray-600 list-disc list-inside">
                                <template x-for="(file, index) in formData.files.supplementary" :key="index">
                                    <li x-text="file"></li>
                                </template>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="flex justify-between mt-8">
                    <button type="button" @click="prevStep()" 
                            class="px-8 py-3 bg-white hover:bg-gray-50 text-[#0F1B4C] border-2 border-[#0F1B4C] rounded-lg font-semibold transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Previous
                    </button>
                    <button type="button" @click="nextStep()" 
                            :disabled="!canProceed(1)"
                            class="px-8 py-3 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        Next: Enter Metadata <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </div>

            <!-- Step 3: Enter Metadata -->
            <div x-show="currentStep === 2" class="bg-white rounded-2xl shadow-xl border-2 border-gray-100 p-8 md:p-12">
                <h2 class="text-2xl font-bold text-[#0F1B4C] mb-6">Step 3: Enter Metadata</h2>
                
                <div class="space-y-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-bold text-[#0F1B4C] mb-2">
                            Title of Paper <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="title" name="title" required 
                               x-model="formData.title"
                               value="{{ old('title', '') }}"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900 {{ $errors->has('title') ? 'border-red-500' : '' }}"
                               placeholder="Enter the complete title of your paper">
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Abstract -->
                    <div>
                        <label for="abstract" class="block text-sm font-bold text-[#0F1B4C] mb-2">
                            Abstract <span class="text-red-500">*</span>
                            <span class="text-gray-500 font-normal text-xs">(150-300 words recommended)</span>
                        </label>
                        <textarea id="abstract" name="abstract" rows="8" required
                                  x-model="formData.abstract"
                                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors resize-none text-gray-900 {{ $errors->has('abstract') ? 'border-red-500' : '' }}"
                                  placeholder="Provide a comprehensive abstract of your article">{{ old('abstract', '') }}</textarea>
                        <div class="text-xs text-gray-500 mt-1">
                            Word count: <span x-text="formData.abstract ? formData.abstract.split(/\s+/).filter(word => word.length > 0).length : 0"></span>
                        </div>
                        @error('abstract')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Keywords -->
                    <div>
                        <label for="keywords" class="block text-sm font-bold text-[#0F1B4C] mb-2">
                            Keywords <span class="text-gray-500 font-normal text-xs">(3-10 keywords, comma-separated)</span>
                        </label>
                        <input type="text" id="keywords" name="keywords" 
                               x-model="formData.keywords"
                               value="{{ old('keywords', '') }}"
                               placeholder="keyword1, keyword2, keyword3"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900">
                        @error('keywords')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Authors -->
                    <div>
                        <label class="block text-sm font-bold text-[#0F1B4C] mb-4">
                            Author Details <span class="text-red-500">*</span>
                        </label>
                        <div id="authors-container" class="space-y-4">
                            <template x-for="(author, index) in formData.authors" :key="index">
                                <div class="author-entry bg-[#F7F9FC] border-2 border-gray-200 rounded-xl p-6">
                                    <div class="flex justify-between items-center mb-4">
                                        <h4 class="font-semibold text-[#0F1B4C]">Author <span x-text="index + 1"></span></h4>
                                        <button type="button" @click="removeAuthor(index)" 
                                                x-show="formData.authors.length > 1"
                                                class="text-red-500 hover:text-red-700 text-sm">
                                            <i class="fas fa-trash mr-1"></i>Remove
                                        </button>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                First Name <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" 
                                                   :name="`authors[${index}][first_name]`"
                                                   x-model="author.first_name"
                                                   required
                                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                Last Name <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" 
                                                   :name="`authors[${index}][last_name]`"
                                                   x-model="author.last_name"
                                                   required
                                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900">
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                Email <span class="text-red-500">*</span>
                                            </label>
                                            <input type="email" 
                                                   :name="`authors[${index}][email]`"
                                                   x-model="author.email"
                                                   required
                                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                Country
                                            </label>
                                            <input type="text" 
                                                   :name="`authors[${index}][country]`"
                                                   x-model="author.country"
                                                   placeholder="Country"
                                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900">
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                Affiliation
                                            </label>
                                            <input type="text" 
                                                   :name="`authors[${index}][affiliation]`"
                                                   x-model="author.affiliation"
                                                   placeholder="University, Department, etc."
                                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                ORCID ID <span class="text-gray-500 font-normal text-xs">(Optional)</span>
                                            </label>
                                            <input type="text" 
                                                   :name="`authors[${index}][orcid]`"
                                                   x-model="author.orcid"
                                                   placeholder="0000-0000-0000-0000"
                                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900">
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <button type="button" @click="addAuthor()" 
                                class="mt-4 bg-[#F7F9FC] hover:bg-[#0056FF] hover:text-white text-[#0056FF] border-2 border-[#0056FF] px-6 py-2.5 rounded-lg font-semibold transition-colors text-sm">
                            <i class="fas fa-plus mr-2"></i>Add Another Author
                        </button>
                    </div>

                    <!-- References -->
                    <div>
                        <label class="block text-sm font-bold text-[#0F1B4C] mb-2">
                            References
                            <span class="text-gray-500 font-normal text-xs">(One reference per line, in journal's citation style)</span>
                        </label>
                        <textarea name="references" id="references" rows="10"
                                  x-model="formData.references"
                                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors resize-none text-gray-900 font-mono text-sm"
                                  placeholder="Enter references, one per line:&#10;Author, A. (2023). Title. Journal Name, 10(2), 123-145.&#10;Author, B. (2022). Another Title. Journal Name, 9(1), 45-67.">{{ old('references', '') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="fas fa-info-circle mr-1"></i>Enter each reference on a new line
                        </p>
                    </div>

                    <!-- Supporting Agencies -->
                    <div>
                        <label for="supporting_agencies" class="block text-sm font-bold text-[#0F1B4C] mb-2">
                            Supporting Agencies / Funding
                            <span class="text-gray-500 font-normal text-xs">(Optional)</span>
                        </label>
                        <textarea id="supporting_agencies" name="supporting_agencies" rows="4"
                                  x-model="formData.supporting_agencies"
                                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors resize-none text-gray-900"
                                  placeholder="List any funding agencies, grants, or supporting organizations">{{ old('supporting_agencies', '') }}</textarea>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="flex justify-between mt-8">
                    <button type="button" @click="prevStep()" 
                            class="px-8 py-3 bg-white hover:bg-gray-50 text-[#0F1B4C] border-2 border-[#0F1B4C] rounded-lg font-semibold transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Previous
                    </button>
                    <button type="button" @click="nextStep()" 
                            :disabled="!canProceed(2)"
                            class="px-8 py-3 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        Next: Review & Confirm <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </div>

            <!-- Step 4: Confirmation -->
            <div x-show="currentStep === 3" class="bg-white rounded-2xl shadow-xl border-2 border-gray-100 p-8 md:p-12">
                <h2 class="text-2xl font-bold text-[#0F1B4C] mb-6">Step 4: Review & Confirm</h2>
                
                <div class="space-y-6">
                    <!-- Section -->
                    <div class="bg-[#F7F9FC] rounded-lg p-4">
                        <h3 class="font-semibold text-[#0F1B4C] mb-2">Section</h3>
                        <p x-text="getSectionName()" class="text-gray-700"></p>
                    </div>

                    <!-- Title -->
                    <div class="bg-[#F7F9FC] rounded-lg p-4">
                        <h3 class="font-semibold text-[#0F1B4C] mb-2">Title</h3>
                        <p x-text="formData.title" class="text-gray-700"></p>
                    </div>

                    <!-- Abstract Preview -->
                    <div class="bg-[#F7F9FC] rounded-lg p-4">
                        <h3 class="font-semibold text-[#0F1B4C] mb-2">Abstract</h3>
                        <p x-text="formData.abstract ? formData.abstract.substring(0, 200) + '...' : 'Not provided'" class="text-gray-700"></p>
                    </div>

                    <!-- Authors -->
                    <div class="bg-[#F7F9FC] rounded-lg p-4">
                        <h3 class="font-semibold text-[#0F1B4C] mb-2">Authors</h3>
                        <ul class="list-disc list-inside text-gray-700">
                            <template x-for="(author, index) in formData.authors" :key="index">
                                <li x-text="`${author.first_name} ${author.last_name} (${author.email})`"></li>
                            </template>
                        </ul>
                    </div>

                    <!-- Files -->
                    <div class="bg-[#F7F9FC] rounded-lg p-4">
                        <h3 class="font-semibold text-[#0F1B4C] mb-2">Files</h3>
                        <ul class="list-disc list-inside text-gray-700">
                            <li x-show="formData.files.manuscript" x-text="`Manuscript: ${formData.files.manuscript}`"></li>
                            <li x-show="formData.files.title_page" x-text="`Title Page: ${formData.files.title_page}`"></li>
                            <template x-for="(file, index) in (formData.files.figures || [])" :key="index">
                                <li x-text="`Figure: ${file}`"></li>
                            </template>
                            <template x-for="(file, index) in (formData.files.tables || [])" :key="index">
                                <li x-text="`Table: ${file}`"></li>
                            </template>
                            <template x-for="(file, index) in (formData.files.supplementary || [])" :key="index">
                                <li x-text="`Supplementary: ${file}`"></li>
                            </template>
                        </ul>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="flex justify-between mt-8">
                    <button type="button" @click="prevStep()" 
                            class="px-8 py-3 bg-white hover:bg-gray-50 text-[#0F1B4C] border-2 border-[#0F1B4C] rounded-lg font-semibold transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Previous
                    </button>
                    
                    @auth
                    <button type="submit" 
                            class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition-colors shadow-lg">
                        <i class="fas fa-check mr-2"></i>Finalize Submission
                    </button>
                    @else
                    <div class="flex space-x-4">
                        <button type="button" onclick="window.location.href='{{ route('login') }}?redirect_to=' + window.location.href"
                                class="px-6 py-3 bg-[#0F1B4C] hover:bg-[#1a2b6d] text-white rounded-lg font-semibold transition-colors">
                            Login to Finalize
                        </button>
                        <button type="button" onclick="window.location.href='{{ route('register') }}?redirect_to=' + window.location.href"
                                class="px-6 py-3 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors">
                            Register & Submit
                        </button>
                    </div>
                    @endauth
                </div>
            </div>
        </form>
    </div>
</section>

<script>
function submissionForm() {
    // Get old values from Laravel validation errors
    const oldData = @json(old());
    const oldAuthors = @json(old('authors', []));
    
    // Determine which step has errors based on validation errors
    let errorStep = 0;
    const errors = @json($errors->getMessages());
    
    // Check for file-related errors (Step 2)
    if (errors.manuscript || errors['title_page'] || errors.figures || errors.tables || errors.supplementary || 
        errors['figures.*'] || errors['tables.*'] || errors['supplementary.*'] || errors['tables.0']) {
        errorStep = 1;
    } 
    // Check for metadata errors (Step 3)
    else if (errors.title || errors.abstract || errors.keywords || errors.authors || errors['authors.*'] || 
             errors['authors.0.first_name'] || errors['authors.0.last_name'] || errors['authors.0.email']) {
        errorStep = 2;
    } 
    // Check for step 1 errors
    else if (errors.journal_section_id || errors.requirements_accepted || errors.privacy_accepted) {
        errorStep = 0;
    }
    // If old data exists, determine step from that
    else if (oldData.manuscript || oldData.title_page || oldData.figures || oldData.tables || oldData.supplementary) {
        errorStep = 1;
    } else if (oldData.title || oldData.abstract || oldData.keywords || oldAuthors.length > 0) {
        errorStep = 2;
    } else if (oldData.journal_section_id || oldData.requirements_accepted || oldData.privacy_accepted) {
        errorStep = 0;
    }
    
    // Initialize authors array
    let authors = [
        {
            first_name: oldData.authors?.[0]?.first_name || '{{ auth()->user()->first_name ?? '' }}',
            last_name: oldData.authors?.[0]?.last_name || '{{ auth()->user()->last_name ?? '' }}',
            email: oldData.authors?.[0]?.email || '{{ auth()->user()->email ?? '' }}',
            country: oldData.authors?.[0]?.country || '',
            affiliation: oldData.authors?.[0]?.affiliation || '{{ auth()->user()->affiliation ?? '' }}',
            orcid: oldData.authors?.[0]?.orcid || '{{ auth()->user()->orcid ?? '' }}'
        }
    ];
    
    // Add additional authors from old data
    if (oldAuthors.length > 1) {
        for (let i = 1; i < oldAuthors.length; i++) {
            authors.push({
                first_name: oldAuthors[i].first_name || '',
                last_name: oldAuthors[i].last_name || '',
                email: oldAuthors[i].email || '',
                country: oldAuthors[i].country || '',
                affiliation: oldAuthors[i].affiliation || '',
                orcid: oldAuthors[i].orcid || ''
            });
        }
    }
    
    return {
        currentStep: errorStep,
        steps: [
            { title: 'Start Submission' },
            { title: 'Upload Files' },
            { title: 'Enter Metadata' },
            { title: 'Review & Confirm' }
        ],
        formData: {
            journal_section_id: oldData.journal_section_id || null,
            requirements_accepted: oldData.requirements_accepted || false,
            privacy_accepted: oldData.privacy_accepted || false,
            title: oldData.title || '',
            abstract: oldData.abstract || '',
            keywords: oldData.keywords || '',
            references: oldData.references || '',
            supporting_agencies: oldData.supporting_agencies || '',
            authors: authors,
            files: {
                manuscript: oldData.manuscript ? 'File was selected' : null,
                title_page: oldData.title_page ? 'File was selected' : null,
                figures: oldData.figures ? (Array.isArray(oldData.figures) ? oldData.figures.map(() => 'File was selected') : ['File was selected']) : [],
                tables: oldData.tables ? (Array.isArray(oldData.tables) ? oldData.tables.map(() => 'File was selected') : ['File was selected']) : [],
                supplementary: oldData.supplementary ? (Array.isArray(oldData.supplementary) ? oldData.supplementary.map(() => 'File was selected') : ['File was selected']) : []
            },
            manuscriptError: null
        },
        sections: @json($sections),
        
        nextStep() {
            if (this.canProceed(this.currentStep)) {
                this.currentStep++;
                if (this.currentStep >= this.steps.length) {
                    this.currentStep = this.steps.length - 1;
                }
            }
        },
        
        prevStep() {
            if (this.currentStep > 0) {
                this.currentStep--;
            }
        },
        
        canProceed(step) {
            if (step === 0) {
                return this.formData.journal_section_id && 
                       this.formData.requirements_accepted && 
                       this.formData.privacy_accepted;
            }
            if (step === 1) {
                return this.formData.files.manuscript !== null;
            }
            if (step === 2) {
                return this.formData.title && 
                       this.formData.abstract && 
                       this.formData.authors.length > 0 &&
                       this.formData.authors.every(a => a.first_name && a.last_name && a.email);
            }
            return true;
        },
        
        addAuthor() {
            this.formData.authors.push({
                first_name: '',
                last_name: '',
                email: '',
                country: '',
                affiliation: '',
                orcid: ''
            });
        },
        
        removeAuthor(index) {
            if (this.formData.authors.length > 1) {
                this.formData.authors.splice(index, 1);
            }
        },
        
        handleFileSelect(event, type, multiple = false) {
            const files = event.target.files;
            if (multiple) {
                this.formData.files[type] = Array.from(files).map(f => f.name);
            } else {
                this.formData.files[type] = files[0] ? files[0].name : null;
            }
        },
        
        validateManuscriptFile(event) {
            const file = event.target.files[0];
            this.formData.manuscriptError = null;
            
            if (!file) {
                return;
            }
            
            const fileName = file.name.toLowerCase();
            const extension = fileName.split('.').pop();
            
            // Check extension
            if (!['doc', 'docx'].includes(extension)) {
                this.formData.manuscriptError = `Invalid file type. Only DOC and DOCX files are accepted. Your file: ${file.name}`;
                event.target.value = ''; // Clear the input
                this.formData.files.manuscript = null;
                return;
            }
            
            // Check file size (10MB = 10485760 bytes)
            if (file.size > 10485760) {
                this.formData.manuscriptError = 'File size exceeds 10MB limit.';
                event.target.value = '';
                this.formData.files.manuscript = null;
                return;
            }
        },
        
        getSectionName() {
            const section = this.sections.find(s => s.id == this.formData.journal_section_id);
            return section ? section.title : 'Not selected';
        },
        
        submitForm() {
            if (this.canProceed(3)) {
                document.getElementById('submissionForm').submit();
            }
        }
    }
}
</script>
@endsection

