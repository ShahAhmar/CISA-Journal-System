@extends('layouts.admin')

@section('title', 'Create New Journal - EMANP')
@section('page-title', 'Create New Journal')
@section('page-subtitle', 'Add a new journal to the EMANP platform')

@push('styles')
<style>
    .quill-editor {
        border: 2px solid #e5e7eb;
        border-radius: 0.5rem;
    }
    .quill-editor:focus-within {
        border-color: #0056FF;
    }
    .ql-toolbar {
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
        border: none;
        border-bottom: 1px solid #e5e7eb;
    }
    .ql-container {
        border-bottom-left-radius: 0.5rem;
        border-bottom-right-radius: 0.5rem;
        border: none;
        border-top: none;
    }
    .tab-button {
        transition: all 0.3s;
    }
    .tab-button.active {
        background: #0056FF;
        color: white;
    }
</style>
@endpush

@section('content')
<div x-data="{ activeTab: 'basic' }">
    <form method="POST" action="{{ route('admin.journals.store') }}" enctype="multipart/form-data" id="journalForm">
        @csrf
        
        <!-- Tabs Navigation -->
        <div class="bg-white rounded-xl border-2 border-gray-200 p-4 mb-6 sticky top-0 z-20">
            <div class="flex flex-wrap gap-2 overflow-x-auto">
                <button type="button" @click="activeTab = 'basic'" 
                        :class="activeTab === 'basic' ? 'tab-button active' : 'tab-button bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        class="px-4 py-2 rounded-lg font-semibold text-sm">
                    <i class="fas fa-info-circle mr-2"></i>Basic Info
                </button>
                <button type="button" @click="activeTab = 'issn'" 
                        :class="activeTab === 'issn' ? 'tab-button active' : 'tab-button bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        class="px-4 py-2 rounded-lg font-semibold text-sm">
                    <i class="fas fa-barcode mr-2"></i>ISSN & Contact
                </button>
                <button type="button" @click="activeTab = 'content'" 
                        :class="activeTab === 'content' ? 'tab-button active' : 'tab-button bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        class="px-4 py-2 rounded-lg font-semibold text-sm">
                    <i class="fas fa-file-text mr-2"></i>Content & Policies
                </button>
                <button type="button" @click="activeTab = 'editorial'" 
                        :class="activeTab === 'editorial' ? 'tab-button active' : 'tab-button bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        class="px-4 py-2 rounded-lg font-semibold text-sm">
                    <i class="fas fa-users mr-2"></i>Editorial Team
                </button>
                <button type="button" @click="activeTab = 'guidelines'" 
                        :class="activeTab === 'guidelines' ? 'tab-button active' : 'tab-button bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        class="px-4 py-2 rounded-lg font-semibold text-sm">
                    <i class="fas fa-clipboard-list mr-2"></i>Author Guidelines
                </button>
                <button type="button" @click="activeTab = 'review'" 
                        :class="activeTab === 'review' ? 'tab-button active' : 'tab-button bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        class="px-4 py-2 rounded-lg font-semibold text-sm">
                    <i class="fas fa-check-circle mr-2"></i>Review Settings
                </button>
                <button type="button" @click="activeTab = 'website'" 
                        :class="activeTab === 'website' ? 'tab-button active' : 'tab-button bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        class="px-4 py-2 rounded-lg font-semibold text-sm">
                    <i class="fas fa-globe mr-2"></i>Website Setup
                </button>
                <button type="button" @click="activeTab = 'settings'" 
                        :class="activeTab === 'settings' ? 'tab-button active' : 'tab-button bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        class="px-4 py-2 rounded-lg font-semibold text-sm">
                    <i class="fas fa-cog mr-2"></i>Advanced Settings
                </button>
            </div>
        </div>

        <div class="space-y-6">
            <!-- Tab 1: Basic Information -->
            <div x-show="activeTab === 'basic'" class="space-y-6">
                <div class="bg-white rounded-xl border-2 border-gray-200 p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-info-circle text-white text-xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-[#0F1B4C]" style="font-family: 'Playfair Display', serif;">
                            Basic Information
                        </h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                Journal Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" required value="{{ old('name') }}"
                                   placeholder="Enter journal name"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900"
                                   style="font-family: 'Inter', sans-serif; font-weight: 400;">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="journal_initials" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                Journal Initials <span class="text-gray-500 font-normal text-xs">(Optional)</span>
                            </label>
                            <input type="text" id="journal_initials" name="journal_initials" value="{{ old('journal_initials') }}"
                                   placeholder="e.g., JRA, IJHS"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900"
                                   style="font-family: 'Inter', sans-serif; font-weight: 400;">
                            <p class="text-xs text-gray-500 mt-2">Short form of journal name</p>
                            @error('journal_initials')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="journal_abbreviation" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                Journal Abbreviation <span class="text-gray-500 font-normal text-xs">(Optional)</span>
                            </label>
                            <input type="text" id="journal_abbreviation" name="journal_abbreviation" value="{{ old('journal_abbreviation') }}"
                                   placeholder="Enter abbreviation"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900"
                                   style="font-family: 'Inter', sans-serif; font-weight: 400;">
                            @error('journal_abbreviation')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="slug" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                Journal URL / Path
                            </label>
                            <input type="text" id="slug" name="slug" value="{{ old('slug') }}"
                                   placeholder="Auto-generated if empty"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900"
                                   style="font-family: 'Inter', sans-serif; font-weight: 400;">
                            <p class="text-xs text-gray-500 mt-2">URL-friendly version (e.g., journal-of-management)</p>
                            @error('slug')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="journal_url" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                Journal URL <span class="text-gray-500 font-normal text-xs">(Optional)</span>
                            </label>
                            <input type="text" id="journal_url" name="journal_url" value="{{ old('journal_url') }}"
                                   placeholder="https://example.com/journal"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900"
                                   style="font-family: 'Inter', sans-serif; font-weight: 400;">
                            @error('journal_url')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="authors" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                <i class="fas fa-user-edit mr-2 text-[#0056FF]"></i>Authors <span class="text-gray-500 font-normal text-xs">(Optional)</span>
                            </label>
                            <input type="text" id="authors" name="authors" value="{{ old('authors') }}"
                                   placeholder="Enter authors name(s)"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900"
                                   style="font-family: 'Inter', sans-serif; font-weight: 400;">
                            <p class="text-xs text-gray-500 mt-2">Enter author names (comma-separated if multiple)</p>
                            @error('authors')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                Journal Description
                            </label>
                            <div id="description-editor" class="quill-editor"></div>
                            <textarea id="description" name="description" style="display:none;">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 2: ISSN & Contact Information -->
            <div x-show="activeTab === 'issn'" class="space-y-6">
                <!-- ISSN Information -->
                <div class="bg-white rounded-xl border-2 border-gray-200 p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-barcode text-white text-xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-[#0F1B4C]" style="font-family: 'Playfair Display', serif;">
                            ISSN Information
                        </h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="print_issn" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                Print ISSN <span class="text-gray-500 font-normal text-xs">(Optional)</span>
                            </label>
                            <input type="text" id="print_issn" name="print_issn" value="{{ old('print_issn') }}"
                                   placeholder="0000-0000"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900"
                                   style="font-family: 'Inter', sans-serif; font-weight: 400;">
                            @error('print_issn')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="online_issn" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                Online ISSN <span class="text-gray-500 font-normal text-xs">(Optional)</span>
                            </label>
                            <input type="text" id="online_issn" name="online_issn" value="{{ old('online_issn') }}"
                                   placeholder="0000-0000"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900"
                                   style="font-family: 'Inter', sans-serif; font-weight: 400;">
                            @error('online_issn')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="bg-white rounded-xl border-2 border-gray-200 p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-address-card text-white text-xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-[#0F1B4C]" style="font-family: 'Playfair Display', serif;">
                            Contact Information
                        </h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="primary_contact_name" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                Primary Contact Name
                            </label>
                            <input type="text" id="primary_contact_name" name="primary_contact_name" value="{{ old('primary_contact_name') }}"
                                   placeholder="Enter contact name"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900"
                                   style="font-family: 'Inter', sans-serif; font-weight: 400;">
                            @error('primary_contact_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="primary_contact_email" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                Primary Contact Email
                            </label>
                            <input type="email" id="primary_contact_email" name="primary_contact_email" value="{{ old('primary_contact_email') }}"
                                   placeholder="contact@journal.com"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900"
                                   style="font-family: 'Inter', sans-serif; font-weight: 400;">
                            @error('primary_contact_email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="contact_phone" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                Phone <span class="text-gray-500 font-normal text-xs">(Optional)</span>
                            </label>
                            <input type="text" id="contact_phone" name="contact_phone" value="{{ old('contact_phone') }}"
                                   placeholder="+1 234 567 8900"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900"
                                   style="font-family: 'Inter', sans-serif; font-weight: 400;">
                            @error('contact_phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="contact_address" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                Mailing Address
                            </label>
                            <textarea id="contact_address" name="contact_address" rows="3"
                                      placeholder="Enter full mailing address"
                                      class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors resize-none text-gray-900"
                                      style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.6;">{{ old('contact_address') }}</textarea>
                            @error('contact_address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="support_contact_name" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                Support Contact Name <span class="text-gray-500 font-normal text-xs">(Optional)</span>
                            </label>
                            <input type="text" id="support_contact_name" name="support_contact_name" value="{{ old('support_contact_name') }}"
                                   placeholder="Enter support contact name"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900"
                                   style="font-family: 'Inter', sans-serif; font-weight: 400;">
                            @error('support_contact_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="support_email" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                Support Email
                            </label>
                            <input type="email" id="support_email" name="support_email" value="{{ old('support_email') }}"
                                   placeholder="support@journal.com"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900"
                                   style="font-family: 'Inter', sans-serif; font-weight: 400;">
                            @error('support_email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 3: Content & Policies -->
            <div x-show="activeTab === 'content'" class="space-y-6">
                <!-- Focus and Scope -->
                <div class="bg-white rounded-xl border-2 border-gray-200 p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-bullseye text-white text-xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-[#0F1B4C]" style="font-family: 'Playfair Display', serif;">
                            Focus and Scope
                        </h2>
                    </div>
                    <div>
                        <label for="focus_scope" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                            Focus and Scope
                        </label>
                        <div id="focus_scope-editor" class="quill-editor"></div>
                        <textarea id="focus_scope" name="focus_scope" style="display:none;">{{ old('focus_scope') }}</textarea>
                        @error('focus_scope')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Peer Review Policy -->
                <div class="bg-white rounded-xl border-2 border-gray-200 p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-check-circle text-white text-xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-[#0F1B4C]" style="font-family: 'Playfair Display', serif;">
                            Peer Review Policy
                        </h2>
                    </div>
                    <div>
                        <label for="peer_review_policy" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                            Peer Review Policy
                        </label>
                        <div id="peer_review_policy-editor" class="quill-editor"></div>
                        <textarea id="peer_review_policy" name="peer_review_policy" style="display:none;">{{ old('peer_review_policy') }}</textarea>
                        @error('peer_review_policy')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Publication Frequency -->
                <div class="bg-white rounded-xl border-2 border-gray-200 p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-calendar-alt text-white text-xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-[#0F1B4C]" style="font-family: 'Playfair Display', serif;">
                            Publication Frequency
                        </h2>
                    </div>
                    <div>
                        <label for="publication_frequency" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                            Publication Frequency
                        </label>
                        <select id="publication_frequency" name="publication_frequency"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900"
                                style="font-family: 'Inter', sans-serif; font-weight: 400;">
                            <option value="">Select frequency</option>
                            <option value="monthly" {{ old('publication_frequency') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="quarterly" {{ old('publication_frequency') == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                            <option value="yearly" {{ old('publication_frequency') == 'yearly' ? 'selected' : '' }}>Yearly</option>
                            <option value="bi-annual" {{ old('publication_frequency') == 'bi-annual' ? 'selected' : '' }}>Bi-Annual</option>
                            <option value="continuous" {{ old('publication_frequency') == 'continuous' ? 'selected' : '' }}>Continuous</option>
                        </select>
                        @error('publication_frequency')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Open Access Policy -->
                <div class="bg-white rounded-xl border-2 border-gray-200 p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-unlock text-white text-xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-[#0F1B4C]" style="font-family: 'Playfair Display', serif;">
                            Open Access Policy
                        </h2>
                    </div>
                    <div>
                        <label for="open_access_policy" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                            Open Access Policy
                        </label>
                        <div id="open_access_policy-editor" class="quill-editor"></div>
                        <textarea id="open_access_policy" name="open_access_policy" style="display:none;">{{ old('open_access_policy') }}</textarea>
                        @error('open_access_policy')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Copyright Notice -->
                <div class="bg-white rounded-xl border-2 border-gray-200 p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-copyright text-white text-xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-[#0F1B4C]" style="font-family: 'Playfair Display', serif;">
                            Copyright Notice
                        </h2>
                    </div>
                    <div>
                        <label for="copyright_notice" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                            Copyright Notice
                        </label>
                        <textarea id="copyright_notice" name="copyright_notice" rows="4"
                                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors resize-none text-gray-900"
                                  style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.6;">{{ old('copyright_notice') }}</textarea>
                        @error('copyright_notice')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Privacy Statement -->
                <div class="bg-white rounded-xl border-2 border-gray-200 p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-shield-alt text-white text-xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-[#0F1B4C]" style="font-family: 'Playfair Display', serif;">
                            Privacy Statement
                        </h2>
                    </div>
                    <div>
                        <label for="privacy_statement" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                            Privacy Statement
                        </label>
                        <div id="privacy_statement-editor" class="quill-editor"></div>
                        <textarea id="privacy_statement" name="privacy_statement" style="display:none;">{{ old('privacy_statement') }}</textarea>
                        @error('privacy_statement')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Tab 4: Editorial Team -->
            <div x-show="activeTab === 'editorial'" class="space-y-6">
                <div class="bg-white rounded-xl border-2 border-gray-200 p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-users text-white text-xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-[#0F1B4C]" style="font-family: 'Playfair Display', serif;">
                            Editorial Team
                        </h2>
                    </div>
                    
                    <div class="space-y-6">
                        <div>
                            <label for="editor_in_chief" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                Editor-in-Chief
                            </label>
                            <div id="editor_in_chief-editor" class="quill-editor"></div>
                            <textarea id="editor_in_chief" name="editor_in_chief" style="display:none;">{{ old('editor_in_chief') }}</textarea>
                            @error('editor_in_chief')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="managing_editor" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                Managing Editor
                            </label>
                            <div id="managing_editor-editor" class="quill-editor"></div>
                            <textarea id="managing_editor" name="managing_editor" style="display:none;">{{ old('managing_editor') }}</textarea>
                            @error('managing_editor')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="section_editors" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                Section Editors
                            </label>
                            <div id="section_editors-editor" class="quill-editor"></div>
                            <textarea id="section_editors" name="section_editors" style="display:none;">{{ old('section_editors') }}</textarea>
                            @error('section_editors')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="editorial_board_members" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                Editorial Board Members
                            </label>
                            <div id="editorial_board_members-editor" class="quill-editor"></div>
                            <textarea id="editorial_board_members" name="editorial_board_members" style="display:none;">{{ old('editorial_board_members') }}</textarea>
                            @error('editorial_board_members')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 5: Author Guidelines -->
            <div x-show="activeTab === 'guidelines'" class="space-y-6">
                <div class="bg-white rounded-xl border-2 border-gray-200 p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-clipboard-list text-white text-xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-[#0F1B4C]" style="font-family: 'Playfair Display', serif;">
                            Author Guidelines
                        </h2>
                    </div>
                    
                    <div class="space-y-6">
                        <div>
                            <label for="author_guidelines" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                Author Guidelines
                            </label>
                            <div id="author_guidelines-editor" class="quill-editor"></div>
                            <textarea id="author_guidelines" name="author_guidelines" style="display:none;">{{ old('author_guidelines') }}</textarea>
                            @error('author_guidelines')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="submission_requirements" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                Submission Requirements
                            </label>
                            <div id="submission_requirements-editor" class="quill-editor"></div>
                            <textarea id="submission_requirements" name="submission_requirements" style="display:none;">{{ old('submission_requirements') }}</textarea>
                            @error('submission_requirements')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="submission_checklist" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                Submission Checklist
                            </label>
                            <div id="submission_checklist-editor" class="quill-editor"></div>
                            <textarea id="submission_checklist" name="submission_checklist" style="display:none;">{{ old('submission_checklist') }}</textarea>
                            <p class="text-xs text-gray-500 mt-2">File format, references, plagiarism requirements, etc.</p>
                            @error('submission_checklist')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="competing_interest_statement" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                Competing Interest Statement
                            </label>
                            <div id="competing_interest_statement-editor" class="quill-editor"></div>
                            <textarea id="competing_interest_statement" name="competing_interest_statement" style="display:none;">{{ old('competing_interest_statement') }}</textarea>
                            @error('competing_interest_statement')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="copyright_agreement" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                Copyright Agreement
                            </label>
                            <div id="copyright_agreement-editor" class="quill-editor"></div>
                            <textarea id="copyright_agreement" name="copyright_agreement" style="display:none;">{{ old('copyright_agreement') }}</textarea>
                            @error('copyright_agreement')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 6: Review Settings -->
            <div x-show="activeTab === 'review'" class="space-y-6">
                <div class="bg-white rounded-xl border-2 border-gray-200 p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-check-double text-white text-xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-[#0F1B4C]" style="font-family: 'Playfair Display', serif;">
                            Review Settings
                        </h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="review_rounds" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                Review Rounds
                            </label>
                            <select id="review_rounds" name="review_rounds"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900"
                                    style="font-family: 'Inter', sans-serif; font-weight: 400;">
                                <option value="1" {{ old('review_rounds', 2) == 1 ? 'selected' : '' }}>1 Round</option>
                                <option value="2" {{ old('review_rounds', 2) == 2 ? 'selected' : '' }}>2 Rounds</option>
                                <option value="3" {{ old('review_rounds', 2) == 3 ? 'selected' : '' }}>3 Rounds</option>
                            </select>
                            @error('review_rounds')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="review_method" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                Review Methods
                            </label>
                            <select id="review_method" name="review_method"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900"
                                    style="font-family: 'Inter', sans-serif; font-weight: 400;">
                                <option value="">Select method</option>
                                <option value="double_blind" {{ old('review_method') == 'double_blind' ? 'selected' : '' }}>Double Blind</option>
                                <option value="single_blind" {{ old('review_method') == 'single_blind' ? 'selected' : '' }}>Single Blind</option>
                                <option value="open" {{ old('review_method') == 'open' ? 'selected' : '' }}>Open Review</option>
                            </select>
                            @error('review_method')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="review_forms" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                Review Forms
                            </label>
                            <textarea id="review_forms" name="review_forms" rows="4"
                                      placeholder="Describe review forms and criteria"
                                      class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors resize-none text-gray-900"
                                      style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.6;">{{ old('review_forms') }}</textarea>
                            @error('review_forms')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 7: Website Setup -->
            <div x-show="activeTab === 'website'" class="space-y-6">
                <!-- Images -->
                <div class="bg-white rounded-xl border-2 border-gray-200 p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-images text-white text-xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-[#0F1B4C]" style="font-family: 'Playfair Display', serif;">
                            Images & Branding
                        </h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="logo" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                <i class="fas fa-image mr-2 text-[#0056FF]"></i>Logo Upload
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-[#0056FF] transition-colors bg-[#F7F9FC]">
                                <input type="file" id="logo" name="logo" accept="image/jpeg,image/jpg,image/png,image/gif,image/webp"
                                       class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#0056FF] file:text-white hover:file:bg-[#0044CC] file:cursor-pointer cursor-pointer"
                                       style="font-family: 'Inter', sans-serif;">
                                <p class="text-xs text-gray-500 mt-3">
                                    <i class="fas fa-info-circle mr-1"></i>Recommended: Square image (500x500px). Max: 5MB
                                </p>
                            </div>
                            @error('logo')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="cover_image" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                <i class="fas fa-image mr-2 text-[#0056FF]"></i>Cover Image
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-[#0056FF] transition-colors bg-[#F7F9FC]">
                                <input type="file" id="cover_image" name="cover_image" accept="image/jpeg,image/jpg,image/png,image/gif,image/webp"
                                       class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#0056FF] file:text-white hover:file:bg-[#0044CC] file:cursor-pointer cursor-pointer"
                                       style="font-family: 'Inter', sans-serif;">
                                <p class="text-xs text-gray-500 mt-3">
                                    <i class="fas fa-info-circle mr-1"></i>Recommended: Banner (1200x400px). Max: 5MB
                                </p>
                            </div>
                            @error('cover_image')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="favicon" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                <i class="fas fa-image mr-2 text-[#0056FF]"></i>Favicon Upload
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-[#0056FF] transition-colors bg-[#F7F9FC]">
                                <input type="file" id="favicon" name="favicon" accept="image/ico,image/png"
                                       class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#0056FF] file:text-white hover:file:bg-[#0044CC] file:cursor-pointer cursor-pointer"
                                       style="font-family: 'Inter', sans-serif;">
                                <p class="text-xs text-gray-500 mt-3">
                                    <i class="fas fa-info-circle mr-1"></i>Recommended: 32x32px or 16x16px. Max: 1MB
                                </p>
                            </div>
                            @error('favicon')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Theme & Content -->
                <div class="bg-white rounded-xl border-2 border-gray-200 p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-palette text-white text-xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-[#0F1B4C]" style="font-family: 'Playfair Display', serif;">
                            Theme & Content
                        </h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="theme" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                Theme Selection
                            </label>
                            <select id="theme" name="theme"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900"
                                    style="font-family: 'Inter', sans-serif; font-weight: 400;">
                                <option value="default" {{ old('theme', 'default') == 'default' ? 'selected' : '' }}>Default</option>
                                <option value="modern" {{ old('theme') == 'modern' ? 'selected' : '' }}>Modern</option>
                                <option value="classic" {{ old('theme') == 'classic' ? 'selected' : '' }}>Classic</option>
                                <option value="minimal" {{ old('theme') == 'minimal' ? 'selected' : '' }}>Minimal</option>
                            </select>
                            @error('theme')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="homepage_content" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                            Homepage Content
                        </label>
                        <div id="homepage_content-editor" class="quill-editor"></div>
                        <textarea id="homepage_content" name="homepage_content" style="display:none;">{{ old('homepage_content') }}</textarea>
                        @error('homepage_content')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-6">
                        <label for="footer_content" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                            Footer Content
                        </label>
                        <textarea id="footer_content" name="footer_content" rows="3"
                                  placeholder="Enter footer content"
                                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors resize-none text-gray-900"
                                  style="font-family: 'Inter', sans-serif; font-weight: 400; line-height: 1.6;">{{ old('footer_content') }}</textarea>
                        @error('footer_content')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Tab 8: Advanced Settings -->
            <div x-show="activeTab === 'settings'" class="space-y-6">
                <!-- DOI Settings -->
                <div class="bg-white rounded-xl border-2 border-gray-200 p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-fingerprint text-white text-xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-[#0F1B4C]" style="font-family: 'Playfair Display', serif;">
                            DOI Settings
                        </h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="doi_prefix" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                DOI Prefix <span class="text-gray-500 font-normal text-xs">(Optional)</span>
                            </label>
                            <input type="text" id="doi_prefix" name="doi_prefix" value="{{ old('doi_prefix') }}"
                                   placeholder="10.xxxxx"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900"
                                   style="font-family: 'Inter', sans-serif; font-weight: 400;">
                            @error('doi_prefix')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center">
                            <label class="flex items-center space-x-3 cursor-pointer">
                                <input type="checkbox" name="doi_enabled" value="1" {{ old('doi_enabled') ? 'checked' : '' }}
                                       class="w-5 h-5 text-[#0056FF] border-gray-300 rounded focus:ring-[#0056FF] cursor-pointer">
                                <span class="text-sm font-bold text-[#0F1B4C]" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                    Enable DOI
                                </span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- License -->
                <div class="bg-white rounded-xl border-2 border-gray-200 p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-certificate text-white text-xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-[#0F1B4C]" style="font-family: 'Playfair Display', serif;">
                            License
                        </h2>
                    </div>
                    
                    <div>
                        <label for="license_type" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                            License Type
                        </label>
                        <select id="license_type" name="license_type"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900"
                                style="font-family: 'Inter', sans-serif; font-weight: 400;">
                            <option value="">Select license</option>
                            <option value="CC BY" {{ old('license_type') == 'CC BY' ? 'selected' : '' }}>CC BY (Creative Commons Attribution)</option>
                            <option value="CC BY-NC" {{ old('license_type') == 'CC BY-NC' ? 'selected' : '' }}>CC BY-NC (Attribution-NonCommercial)</option>
                            <option value="CC BY-SA" {{ old('license_type') == 'CC BY-SA' ? 'selected' : '' }}>CC BY-SA (Attribution-ShareAlike)</option>
                            <option value="CC BY-ND" {{ old('license_type') == 'CC BY-ND' ? 'selected' : '' }}>CC BY-ND (Attribution-NoDerivs)</option>
                            <option value="All Rights Reserved" {{ old('license_type') == 'All Rights Reserved' ? 'selected' : '' }}>All Rights Reserved</option>
                        </select>
                        @error('license_type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Language & Regional -->
                <div class="bg-white rounded-xl border-2 border-gray-200 p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-language text-white text-xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-[#0F1B4C]" style="font-family: 'Playfair Display', serif;">
                            Language & Regional Settings
                        </h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="primary_language" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                Primary Language
                            </label>
                            <select id="primary_language" name="primary_language"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900"
                                    style="font-family: 'Inter', sans-serif; font-weight: 400;">
                                <option value="en" {{ old('primary_language', 'en') == 'en' ? 'selected' : '' }}>English</option>
                                <option value="es" {{ old('primary_language') == 'es' ? 'selected' : '' }}>Spanish</option>
                                <option value="fr" {{ old('primary_language') == 'fr' ? 'selected' : '' }}>French</option>
                                <option value="de" {{ old('primary_language') == 'de' ? 'selected' : '' }}>German</option>
                                <option value="ar" {{ old('primary_language') == 'ar' ? 'selected' : '' }}>Arabic</option>
                                <option value="ur" {{ old('primary_language') == 'ur' ? 'selected' : '' }}>Urdu</option>
                            </select>
                            @error('primary_language')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="timezone" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                Timezone
                            </label>
                            <select id="timezone" name="timezone"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900"
                                    style="font-family: 'Inter', sans-serif; font-weight: 400;">
                                <option value="UTC" {{ old('timezone', 'UTC') == 'UTC' ? 'selected' : '' }}>UTC</option>
                                <option value="America/New_York" {{ old('timezone') == 'America/New_York' ? 'selected' : '' }}>America/New_York</option>
                                <option value="Europe/London" {{ old('timezone') == 'Europe/London' ? 'selected' : '' }}>Europe/London</option>
                                <option value="Asia/Karachi" {{ old('timezone') == 'Asia/Karachi' ? 'selected' : '' }}>Asia/Karachi</option>
                            </select>
                            @error('timezone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="date_format" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                Date Format
                            </label>
                            <select id="date_format" name="date_format"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900"
                                    style="font-family: 'Inter', sans-serif; font-weight: 400;">
                                <option value="Y-m-d" {{ old('date_format', 'Y-m-d') == 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD</option>
                                <option value="d/m/Y" {{ old('date_format') == 'd/m/Y' ? 'selected' : '' }}>DD/MM/YYYY</option>
                                <option value="m/d/Y" {{ old('date_format') == 'm/d/Y' ? 'selected' : '' }}>MM/DD/YYYY</option>
                            </select>
                            @error('date_format')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- File Upload Settings -->
                <div class="bg-white rounded-xl border-2 border-gray-200 p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-upload text-white text-xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-[#0F1B4C]" style="font-family: 'Playfair Display', serif;">
                            File Upload Settings
                        </h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="max_file_size" class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                Max File Size (MB)
                            </label>
                            <input type="number" id="max_file_size" name="max_file_size" value="{{ old('max_file_size', 10) }}"
                                   min="1" max="100"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors text-gray-900"
                                   style="font-family: 'Inter', sans-serif; font-weight: 400;">
                            @error('max_file_size')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center">
                            <label class="flex items-center space-x-3 cursor-pointer">
                                <input type="checkbox" name="plagiarism_check_required" value="1" {{ old('plagiarism_check_required') ? 'checked' : '' }}
                                       class="w-5 h-5 text-[#0056FF] border-gray-300 rounded focus:ring-[#0056FF] cursor-pointer">
                                <span class="text-sm font-bold text-[#0F1B4C]" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                    Plagiarism Check Required <span class="text-gray-500 font-normal text-xs">(Optional)</span>
                                </span>
                            </label>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-[#0F1B4C] mb-2" style="font-family: 'Inter', sans-serif; font-weight: 700;">
                                Allowed Formats
                            </label>
                            <div class="flex flex-wrap gap-4">
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="checkbox" name="allowed_formats[]" value="pdf" checked
                                           class="w-4 h-4 text-[#0056FF] border-gray-300 rounded focus:ring-[#0056FF] cursor-pointer">
                                    <span class="text-sm text-gray-700">PDF</span>
                                </label>
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="checkbox" name="allowed_formats[]" value="docx"
                                           class="w-4 h-4 text-[#0056FF] border-gray-300 rounded focus:ring-[#0056FF] cursor-pointer">
                                    <span class="text-sm text-gray-700">DOCX</span>
                                </label>
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="checkbox" name="allowed_formats[]" value="doc"
                                           class="w-4 h-4 text-[#0056FF] border-gray-300 rounded focus:ring-[#0056FF] cursor-pointer">
                                    <span class="text-sm text-gray-700">DOC</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="bg-white rounded-xl border-2 border-gray-200 p-6 flex justify-between items-center sticky bottom-0 z-10">
                <div class="text-sm text-gray-600">
                    <i class="fas fa-info-circle mr-2"></i>Fill all required fields and save your journal
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('admin.journals.index') }}" 
                       class="px-8 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-semibold transition-colors"
                       style="font-family: 'Inter', sans-serif; font-weight: 600;">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </a>
                    <button type="submit" 
                            class="px-8 py-3 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors shadow-lg transform hover:scale-105"
                            style="font-family: 'Inter', sans-serif; font-weight: 600;">
                        <i class="fas fa-save mr-2"></i>Create Journal
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // Initialize Quill editors
    const editors = {};
    const editorFields = [
        'description',
        'focus_scope',
        'peer_review_policy',
        'open_access_policy',
        'privacy_statement',
        'editor_in_chief',
        'managing_editor',
        'section_editors',
        'editorial_board_members',
        'author_guidelines',
        'submission_requirements',
        'submission_checklist',
        'competing_interest_statement',
        'copyright_agreement',
        'homepage_content'
    ];

    editorFields.forEach(field => {
        const editorId = field + '-editor';
        const textareaId = field;
        
        editors[field] = new Quill('#' + editorId, {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'align': [] }],
                    ['link', 'image'],
                    ['clean']
                ]
            },
            placeholder: 'Start typing...'
        });

        // Set initial content if exists
        const textarea = document.getElementById(textareaId);
        if (textarea && textarea.value) {
            editors[field].root.innerHTML = textarea.value;
        }

        // Update hidden textarea on text change
        editors[field].on('text-change', function() {
            textarea.value = editors[field].root.innerHTML;
        });
    });

    // Auto-generate slug from name
    document.getElementById('name').addEventListener('input', function(e) {
        const slugInput = document.getElementById('slug');
        if (!slugInput.value || slugInput.dataset.autoGenerated === 'true') {
            const slug = e.target.value
                .toLowerCase()
                .trim()
                .replace(/[^\w\s-]/g, '')
                .replace(/[\s_-]+/g, '-')
                .replace(/^-+|-+$/g, '');
            slugInput.value = slug;
            slugInput.dataset.autoGenerated = 'true';
        }
    });

    // Clear auto-generated flag when user manually edits slug
    document.getElementById('slug').addEventListener('input', function() {
        this.dataset.autoGenerated = 'false';
    });

    // File size validation
    document.getElementById('logo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file && file.size > 5 * 1024 * 1024) {
            alert('Logo file size must be less than 5MB. Current size: ' + (file.size / 1024 / 1024).toFixed(2) + 'MB');
            e.target.value = '';
        }
    });

    document.getElementById('cover_image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file && file.size > 5 * 1024 * 1024) {
            alert('Cover image file size must be less than 5MB. Current size: ' + (file.size / 1024 / 1024).toFixed(2) + 'MB');
            e.target.value = '';
        }
    });

    document.getElementById('favicon').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file && file.size > 1 * 1024 * 1024) {
            alert('Favicon file size must be less than 1MB. Current size: ' + (file.size / 1024 / 1024).toFixed(2) + 'MB');
            e.target.value = '';
        }
    });

    // Update all editor content before form submission
    document.getElementById('journalForm').addEventListener('submit', function(e) {
        editorFields.forEach(field => {
            const textarea = document.getElementById(field);
            if (editors[field]) {
                textarea.value = editors[field].root.innerHTML;
            }
        });
    });
</script>
@endsection
