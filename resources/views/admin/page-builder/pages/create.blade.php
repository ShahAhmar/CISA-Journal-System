@extends('layouts.admin')

@section('title', 'Create Custom Page - EMANP')
@section('page-title', 'Create Custom Page')
@section('page-subtitle', 'Add a new custom page to your website')

@push('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    .quill-editor {
        border: 2px solid #e5e7eb;
        border-radius: 0.5rem;
    }
    .quill-editor:focus-within {
        border-color: #0056FF;
    }
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto">
    <form method="POST" action="{{ route('admin.page-builder.pages.store', $journal ?? null) }}" id="pageForm">
        @csrf
        
        <div class="bg-white rounded-xl border-2 border-gray-200 p-6 space-y-6">
            <!-- Basic Information -->
            <div>
                <h3 class="text-lg font-bold text-[#0F1B4C] mb-4">
                    <i class="fas fa-info-circle mr-2 text-[#0056FF]"></i>Basic Information
                </h3>
                
                <div class="space-y-4">
                    <div>
                        <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                            Page Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               required
                               value="{{ old('title') }}"
                               class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors"
                               placeholder="Enter page title">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="slug" class="block text-sm font-semibold text-gray-700 mb-2">
                            URL Slug
                            <span class="text-xs text-gray-500 font-normal">(Auto-generated if left empty)</span>
                        </label>
                        <input type="text" 
                               id="slug" 
                               name="slug" 
                               value="{{ old('slug') }}"
                               class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors"
                               placeholder="page-url-slug">
                        @error('slug')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   id="is_published" 
                                   name="is_published" 
                                   value="1"
                                   {{ old('is_published', true) ? 'checked' : '' }}
                                   class="h-5 w-5 text-[#0056FF] focus:ring-[#0056FF] border-gray-300 rounded">
                            <label for="is_published" class="ml-3 block text-sm text-gray-700 cursor-pointer">
                                Publish immediately
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" 
                                   id="show_in_menu" 
                                   name="show_in_menu" 
                                   value="1"
                                   {{ old('show_in_menu') ? 'checked' : '' }}
                                   class="h-5 w-5 text-[#0056FF] focus:ring-[#0056FF] border-gray-300 rounded">
                            <label for="show_in_menu" class="ml-3 block text-sm text-gray-700 cursor-pointer">
                                Show in navigation menu
                            </label>
                        </div>
                    </div>

                    <div id="menu_label_container" style="display: none;">
                        <label for="menu_label" class="block text-sm font-semibold text-gray-700 mb-2">
                            Menu Label
                        </label>
                        <input type="text" 
                               id="menu_label" 
                               name="menu_label" 
                               value="{{ old('menu_label') }}"
                               class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors"
                               placeholder="Label to show in menu">
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <div>
                <h3 class="text-lg font-bold text-[#0F1B4C] mb-4">
                    <i class="fas fa-file-alt mr-2 text-[#0056FF]"></i>Page Content
                </h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Content <span class="text-xs text-gray-500 font-normal">(Use Page Builder below for widgets)</span>
                        </label>
                        <div id="editor" class="quill-editor" style="min-height: 300px;"></div>
                        <textarea name="content" id="content" style="display: none;">{{ old('content') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- SEO Settings -->
            <div>
                <h3 class="text-lg font-bold text-[#0F1B4C] mb-4">
                    <i class="fas fa-search mr-2 text-[#0056FF]"></i>SEO Settings
                </h3>
                
                <div class="space-y-4">
                    <div>
                        <label for="meta_title" class="block text-sm font-semibold text-gray-700 mb-2">
                            Meta Title
                        </label>
                        <input type="text" 
                               id="meta_title" 
                               name="meta_title" 
                               value="{{ old('meta_title') }}"
                               class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors"
                               placeholder="SEO title (leave empty to use page title)">
                    </div>

                    <div>
                        <label for="meta_description" class="block text-sm font-semibold text-gray-700 mb-2">
                            Meta Description
                        </label>
                        <textarea id="meta_description" 
                                  name="meta_description" 
                                  rows="3"
                                  class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors"
                                  placeholder="SEO description">{{ old('meta_description') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.page-builder.pages.index', $journal ?? null) }}" 
                   class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-semibold transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors shadow-lg">
                    <i class="fas fa-save mr-2"></i>Create Page
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Quill editor
    const quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'color': [] }, { 'background': [] }],
                ['link', 'image'],
                ['clean']
            ]
        }
    });

    // Set initial content
    const contentTextarea = document.getElementById('content');
    if (contentTextarea.value) {
        quill.root.innerHTML = contentTextarea.value;
    }

    // Update textarea on content change
    quill.on('text-change', function() {
        contentTextarea.value = quill.root.innerHTML;
    });

    // Form submission
    document.getElementById('pageForm').addEventListener('submit', function(e) {
        contentTextarea.value = quill.root.innerHTML;
    });

    // Show/hide menu label field
    document.getElementById('show_in_menu').addEventListener('change', function() {
        document.getElementById('menu_label_container').style.display = this.checked ? 'block' : 'none';
    });
    if (document.getElementById('show_in_menu').checked) {
        document.getElementById('menu_label_container').style.display = 'block';
    }

    // Auto-generate slug from title
    document.getElementById('title').addEventListener('input', function() {
        const slugInput = document.getElementById('slug');
        if (!slugInput.value || slugInput.dataset.autoGenerated === 'true') {
            slugInput.value = this.value.toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/(^-|-$)/g, '');
            slugInput.dataset.autoGenerated = 'true';
        }
    });
});
</script>
@endpush
@endsection

