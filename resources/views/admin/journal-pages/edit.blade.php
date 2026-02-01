@extends('layouts.admin')

@section('title', 'Edit ' . $pageData['name'] . ' - ' . $journal->name)
@section('page-title', 'Edit ' . $pageData['name'])
@section('page-subtitle', $pageData['description'] ?? 'Edit page content')

@push('styles')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        .quill-editor {
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            min-height: 400px;
        }

        .quill-editor:focus-within {
            border-color: #f59e0b;
            /* cisa-accent */
        }
    </style>
@endpush

@section('content')
    <div class="max-w-5xl mx-auto">
        <form method="POST" action="{{ route('admin.journal-pages.update', [$journal, $pageType]) }}" id="pageForm">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-xl border-2 border-gray-200 p-6 space-y-6">
                <!-- Page Info -->
                <div class="bg-indigo-50 border-l-4 border-cisa-base p-4 rounded-lg">
                    <div class="flex items-start">
                        <div
                            class="w-12 h-12 bg-cisa-base rounded-lg flex items-center justify-center text-white mr-4 shadow-sm">
                            <i class="{{ $pageTypes[$pageType]['icon'] }} text-xl text-cisa-accent"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-cisa-base mb-1">{{ $pageData['name'] }}</h3>
                            @if($pageData['description'])
                                <p class="text-sm text-slate-600">{{ $pageData['description'] }}</p>
                            @endif
                            @if($pageTypes[$pageType]['route'])
                                <a href="{{ route($pageTypes[$pageType]['route'], $journal) }}" target="_blank"
                                    class="text-sm text-cisa-accent hover:text-cisa-base font-bold mt-2 inline-flex items-center transition-colors">
                                    <i class="fas fa-external-link-alt mr-1"></i>View Page
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Content Editor -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Page Content <span class="text-red-500">*</span>
                    </label>
                    <div id="editor" class="quill-editor">{!! old('content', $pageData['content']) !!}</div>
                    <textarea name="content" id="content"
                        style="display: none;">{{ old('content', $pageData['content']) }}</textarea>
                    <p class="mt-2 text-xs text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i>Use the toolbar above to format your content. HTML is
                        supported.
                    </p>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.journal-pages.index', $journal) }}"
                        class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-semibold transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Pages
                    </a>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.journal-pages.edit', [$journal, $pageType, 'live' => true]) }}"
                            class="px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white rounded-lg font-semibold transition-colors shadow-lg">
                            <i class="fas fa-eye mr-2"></i>Switch to Live Editor
                        </a>
                        <a href="{{ route('admin.journal-pages.index', $journal) }}"
                            class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-semibold transition-colors">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-6 py-3 bg-cisa-accent hover:bg-white hover:text-cisa-base text-cisa-base rounded-lg font-bold transition-all shadow-lg border-2 border-transparent hover:border-cisa-base">
                            <i class="fas fa-save mr-2"></i>Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Initialize Quill editor
                const quill = new Quill('#editor', {
                    theme: 'snow',
                    modules: {
                        toolbar: [
                            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                            [{ 'font': [] }],
                            [{ 'size': [] }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{ 'color': [] }, { 'background': [] }],
                            [{ 'script': 'sub' }, { 'script': 'super' }],
                            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                            [{ 'indent': '-1' }, { 'indent': '+1' }],
                            [{ 'direction': 'rtl' }],
                            [{ 'align': [] }],
                            ['link', 'image', 'video'],
                            ['blockquote', 'code-block'],
                            ['clean']
                        ]
                    }
                });

                const contentTextarea = document.getElementById('content');

                // Set initial content
                if (contentTextarea.value) {
                    quill.root.innerHTML = contentTextarea.value;
                }

                // Update textarea on content change
                quill.on('text-change', function () {
                    contentTextarea.value = quill.root.innerHTML;
                });

                // Form submission
                document.getElementById('pageForm').addEventListener('submit', function (e) {
                    contentTextarea.value = quill.root.innerHTML;
                });
            });
        </script>
    @endpush
@endsection