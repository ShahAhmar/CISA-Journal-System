@extends('layouts.admin')

@section('title', 'Edit ' . $pageData['name'] . ' - ' . $journal->name)
@section('page-title', 'Edit ' . $pageData['name'] . ' (Live Editor)')
@section('page-subtitle', $pageData['description'] ?? 'Edit page content with live preview')

@push('styles')
    <style>
        .editor-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            height: calc(100vh - 200px);
        }

        .editor-panel {
            display: flex;
            flex-direction: column;
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .preview-panel {
            display: flex;
            flex-direction: column;
            background: #f9fafb;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .panel-header {
            padding: 16px;
            background: #0f172a;
            /* cisa-base */
            color: white;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #f59e0b;
            /* cisa-accent */
        }

        .panel-content {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
        }

        .editor-panel .panel-content {
            padding: 0;
        }

        .panel-content:has(#editor) {
            padding: 0;
        }

        #editor {
            height: 100%;
            min-height: 500px;
            background: white;
            border: none;
        }

        #editor .ql-toolbar {
            border: none;
            border-bottom: 1px solid #e5e7eb;
            padding: 12px;
            background: #f9fafb;
        }

        #editor .ql-container {
            min-height: calc(100vh - 400px);
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            background: white;
            border: none;
        }

        #editor .ql-editor {
            min-height: calc(100vh - 450px);
            background: white;
            cursor: text;
            padding: 20px;
        }

        #editor .ql-editor:focus {
            outline: none;
        }

        #editor .ql-editor.ql-blank::before {
            color: #9ca3af;
            font-style: italic;
        }

        .preview-content {
            background: white;
            padding: 40px;
            min-height: 100%;
            font-family: 'Inter', sans-serif;
        }

        .preview-content h1 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
            color: #0F1B4C;
        }

        .preview-content h2 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 0.75rem;
            margin-top: 2rem;
            color: #0F1B4C;
        }

        .preview-content h3 {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            margin-top: 1.5rem;
            color: #0F1B4C;
        }

        .preview-content p {
            margin-bottom: 1rem;
            line-height: 1.7;
            color: #374151;
        }

        .preview-content ul,
        .preview-content ol {
            margin-bottom: 1rem;
            padding-left: 2rem;
        }

        .preview-content li {
            margin-bottom: 0.5rem;
            line-height: 1.6;
        }

        .preview-content a {
            color: #f59e0b;
            text-decoration: underline;
        }

        .preview-content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 1rem 0;
        }

        .preview-content blockquote {
            border-left: 4px solid #0056FF;
            padding-left: 1rem;
            margin: 1rem 0;
            font-style: italic;
            color: #6b7280;
        }

        .preview-content code {
            background: #f3f4f6;
            padding: 2px 6px;
            border-radius: 4px;
            font-family: monospace;
            font-size: 0.9em;
        }

        .preview-content pre {
            background: #1f2937;
            color: #f9fafb;
            padding: 1rem;
            border-radius: 8px;
            overflow-x: auto;
            margin: 1rem 0;
        }

        .preview-content pre code {
            background: transparent;
            color: inherit;
            padding: 0;
        }

        @media (max-width: 1024px) {
            .editor-container {
                grid-template-columns: 1fr;
                height: auto;
            }

            .editor-panel,
            .preview-panel {
                min-height: 500px;
            }
        }

        .toolbar-actions {
            display: flex;
            gap: 10px;
            padding: 12px 16px;
            background: #f9fafb;
            border-top: 1px solid #e5e7eb;
        }
    </style>
@endpush

@section('content')
    <div class="space-y-6">
        <!-- Page Info Bar -->
        <div class="bg-gradient-to-r from-cisa-base to-slate-800 text-white rounded-xl p-6 border-b-4 border-cisa-accent">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                        <i class="{{ $pageTypes[$pageType]['icon'] }} text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold">{{ $pageData['name'] }}</h3>
                        @if($pageData['description'])
                            <p class="text-blue-100 text-sm mt-1">{{ $pageData['description'] }}</p>
                        @endif
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    @if($pageTypes[$pageType]['route'])
                        <a href="{{ route($pageTypes[$pageType]['route'], $journal) }}" target="_blank"
                            class="px-4 py-2 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-lg font-semibold transition-colors">
                            <i class="fas fa-external-link-alt mr-2"></i>View Live Page
                        </a>
                    @endif
                    <a href="{{ route('admin.journal-pages.edit', [$journal, $pageType]) }}"
                        class="px-4 py-2 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-lg font-semibold transition-colors">
                        <i class="fas fa-edit mr-2"></i>Simple Editor
                    </a>
                    <a href="{{ route('admin.journal-pages.index', $journal) }}"
                        class="px-4 py-2 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-lg font-semibold transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Back
                    </a>
                </div>
            </div>
        </div>

        <!-- Live Editor Container -->
        <form method="POST" action="{{ route('admin.journal-pages.update', [$journal, $pageType]) }}" id="pageForm">
            @csrf
            @method('PUT')

            <div class="editor-container">
                <!-- Editor Panel (Left) -->
                <div class="editor-panel">
                    <div class="panel-header">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-edit"></i>
                            <span>Editor</span>
                        </div>
                        <div class="text-xs bg-white bg-opacity-20 px-2 py-1 rounded">
                            <i class="fas fa-sync-alt mr-1"></i>Live Preview
                        </div>
                    </div>
                    <div class="panel-content"
                        style="position: relative; min-height: 500px; background: white; padding: 0 !important;">
                        <div id="editor" style="min-height: 500px; background: white;"></div>
                        <textarea name="content" id="content"
                            style="display: none;">{!! old('content', $pageData['content'] ?? '') !!}</textarea>
                        <div id="editor-status"
                            style="position: absolute; top: 10px; right: 10px; background: rgba(0,0,0,0.7); color: white; padding: 5px 10px; border-radius: 4px; font-size: 12px; z-index: 1000; display: none;">
                            Initializing...
                        </div>
                    </div>
                    <div class="toolbar-actions">
                        <button type="submit"
                            class="flex-1 bg-cisa-accent hover:bg-white hover:text-cisa-base text-cisa-base px-6 py-2 rounded-lg font-bold transition-all shadow-lg">
                            <i class="fas fa-save mr-2"></i>Save Changes
                        </button>
                        <button type="button" onclick="resetContent()"
                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-semibold transition-colors">
                            <i class="fas fa-undo mr-2"></i>Reset
                        </button>
                    </div>
                </div>

                <!-- Preview Panel (Right) -->
                <div class="preview-panel">
                    <div class="panel-header">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-eye"></i>
                            <span>Live Preview</span>
                        </div>
                        <div class="text-xs bg-white bg-opacity-20 px-2 py-1 rounded">
                            <i class="fas fa-mobile-alt mr-1"></i>Desktop View
                        </div>
                    </div>
                    <div class="panel-content">
                        <div id="live-preview" class="preview-content">
                            {!! old('content', $pageData['content'] ?? '') !!}
                        </div>
                    </div>
                    <div class="toolbar-actions">
                        <button type="button" onclick="togglePreviewMode('desktop')"
                            class="px-4 py-2 bg-cisa-accent/20 text-cisa-base rounded-lg font-semibold transition-colors preview-mode-btn active border border-cisa-accent">
                            <i class="fas fa-desktop mr-2"></i>Desktop
                        </button>
                        <button type="button" onclick="togglePreviewMode('tablet')"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-semibold transition-colors preview-mode-btn">
                            <i class="fas fa-tablet-alt mr-2"></i>Tablet
                        </button>
                        <button type="button" onclick="togglePreviewMode('mobile')"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-semibold transition-colors preview-mode-btn">
                            <i class="fas fa-mobile-alt mr-2"></i>Mobile
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            (function () {
                'use strict';

                let quill;
                        let originalContent = document.getElementById('content')?.value || '';
                        let isInitialized = false;

                        function initializeEditor() {
                            if (isInitialized) return;

                            const editorEl = document.getElementById('editor');
                            if (!editorEl || typeof Quill === 'undefined') return;

                            // Initialize Quill
                            quill = new Quill('#editor', {
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
                                },
                                placeholder: 'Start typing your content here...'
                            });

                            isInitialized = true;
                            console.log('Editor Initialized');

                            const contentTextarea = document.getElementById('content');
                            const previewDiv = document.getElementById('live-preview');

                            // Load initial content
                            if (contentTextarea && contentTextarea.value) {
                                quill.root.innerHTML = contentTextarea.value;
                                previewDiv.innerHTML = contentTextarea.value;
                            }

                            // Live updates
                            quill.on('text-change', function () {
                                const html = quill.root.innerHTML;
                                if (contentTextarea) contentTextarea.value = html;
                                if (previewDiv) previewDiv.innerHTML = html;
                            });

                            // Form sync
                            const form = document.getElementById('pageForm');
                            if (form) {
                                form.addEventListener('submit', function () {
                                    contentTextarea.value = quill.root.innerHTML;
                                });
                            }
                        }

                        // Multiple triggers to ensure initialization
                        document.addEventListener('DOMContentLoaded', initializeEditor);
                        window.addEventListener('load', initializeEditor);
                        setInterval(() => {
                            if (!isInitialized && document.getElementById('editor') && typeof Quill !== 'undefined') {
                                initializeEditor();
                            }
                        }, 500);

                        window.resetContent = function () {
                            if (confirm('Are you sure you want to reset?')) {
                                quill.root.innerHTML = originalContent;
                                document.getElementById('content').value = originalContent;
                                document.getElementById('live-preview').innerHTML = originalContent;
                            }
                        };

                        window.togglePreviewMode = function (mode) {
                            const previewDiv = document.getElementById('live-preview');
                            const buttons = document.querySelectorAll('.preview-mode-btn');

                            buttons.forEach(btn => {
                                btn.classList.remove('active', 'border-cisa-accent', 'bg-cisa-accent/20');
                                btn.classList.add('bg-gray-100', 'text-gray-700');
                            });

                            const clickedBtn = event ? event.target.closest('button') : null;
                            if (clickedBtn) {
                                clickedBtn.classList.add('active', 'border-cisa-accent', 'bg-cisa-accent/20');
                                clickedBtn.classList.remove('bg-gray-100', 'text-gray-700');
                            }

                            if (mode === 'tablet') {
                                previewDiv.style.maxWidth = '768px';
                                previewDiv.style.margin = '0 auto';
                            } else if (mode === 'mobile') {
                                previewDiv.style.maxWidth = '375px';
                                previewDiv.style.margin = '0 auto';
                            } else {
                                previewDiv.style.maxWidth = '100%';
                                previewDiv.style.margin = '0';
                            }
                        };
                    })();

                    // Global shortcut
                    document.addEventListener('keydown', function (e) {
                        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                            e.preventDefault();
                            document.getElementById('pageForm').submit();
                        }
                    });
                </script>
    @endpush
@endsection