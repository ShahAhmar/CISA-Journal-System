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
        background: #0056FF;
        color: white;
        font-weight: bold;
        display: flex;
        items-center;
        justify-content: space-between;
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
    
    .preview-content ul, .preview-content ol {
        margin-bottom: 1rem;
        padding-left: 2rem;
    }
    
    .preview-content li {
        margin-bottom: 0.5rem;
        line-height: 1.6;
    }
    
    .preview-content a {
        color: #0056FF;
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
        
        .editor-panel, .preview-panel {
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
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl p-6">
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
                <a href="{{ route($pageTypes[$pageType]['route'], $journal) }}" 
                   target="_blank"
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
                <div class="panel-content" style="position: relative; min-height: 500px; background: white; padding: 0 !important;">
                    <div id="editor" style="min-height: 500px; background: white;"></div>
                    <textarea name="content" id="content" style="display: none;">{!! old('content', $pageData['content'] ?? '') !!}</textarea>
                    <div id="editor-status" style="position: absolute; top: 10px; right: 10px; background: rgba(0,0,0,0.7); color: white; padding: 5px 10px; border-radius: 4px; font-size: 12px; z-index: 1000; display: none;">
                        Initializing...
                    </div>
                </div>
                <div class="toolbar-actions">
                    <button type="submit" 
                            class="flex-1 bg-[#0056FF] hover:bg-[#0044CC] text-white px-6 py-2 rounded-lg font-semibold transition-colors">
                        <i class="fas fa-save mr-2"></i>Save Changes
                    </button>
                    <button type="button" 
                            onclick="resetContent()"
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
                    <button type="button" 
                            onclick="togglePreviewMode('desktop')"
                            class="px-4 py-2 bg-blue-100 text-blue-700 rounded-lg font-semibold transition-colors preview-mode-btn active">
                        <i class="fas fa-desktop mr-2"></i>Desktop
                    </button>
                    <button type="button" 
                            onclick="togglePreviewMode('tablet')"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-semibold transition-colors preview-mode-btn">
                        <i class="fas fa-tablet-alt mr-2"></i>Tablet
                    </button>
                    <button type="button" 
                            onclick="togglePreviewMode('mobile')"
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
(function() {
    'use strict';
    
    // Prevent multiple initializations
    if (window.editorInitialized) {
        console.log('Editor already initialized, skipping...');
        return;
    }
    
    let quill;
    let originalContent = `{!! addslashes($pageData['content'] ?? '') !!}`;
    let initAttempts = 0;
    const maxAttempts = 100;
    let isInitializing = false;

    console.log('=== EDITOR SCRIPT LOADING ===');
    console.log('Quill available:', typeof Quill !== 'undefined');
    console.log('Document ready state:', document.readyState);
    
    // Show status indicator
    function showStatus(msg) {
        const statusEl = document.getElementById('editor-status');
        if (statusEl) {
            statusEl.style.display = 'block';
            statusEl.textContent = msg;
        }
    }
    
    showStatus('Loading Quill...');

    // Wait for both DOM and Quill to be ready
    function initializeEditor() {
        // Prevent multiple simultaneous initializations
        if (isInitializing || window.editorInitialized) {
            console.log('Initialization already in progress or completed, skipping...');
            return;
        }
        
        isInitializing = true;
        initAttempts++;
        console.log('=== INITIALIZATION ATTEMPT ' + initAttempts + ' ===');
        showStatus('Attempt ' + initAttempts + '...');
        
        if (initAttempts > maxAttempts) {
            console.error('Failed to initialize editor after ' + maxAttempts + ' attempts');
            showStatus('Failed!');
            isInitializing = false;
            const editorEl = document.getElementById('editor');
            if (editorEl) {
                editorEl.innerHTML = '<div style="padding: 20px; color: red; border: 2px solid red;"><strong>Error:</strong> Editor failed to load. Quill available: ' + (typeof Quill !== 'undefined') + '<br>Please check browser console (F12) for details.</div>';
            }
            return;
        }

        // Check if editor element exists
        const editorElement = document.getElementById('editor');
        if (!editorElement) {
            console.log('❌ Editor element not found, retrying...');
            showStatus('Waiting for editor element...');
            isInitializing = false;
            setTimeout(initializeEditor, 50);
            return;
        }
        console.log('✅ Editor element found');

        // Check if already initialized
        if (editorElement.querySelector('.ql-container')) {
            console.log('✅ Editor already initialized (found .ql-container)');
            window.editorInitialized = true;
            isInitializing = false;
            showStatus('Ready!');
            setTimeout(function() {
                const statusEl = document.getElementById('editor-status');
                if (statusEl) statusEl.style.display = 'none';
            }, 1000);
            return;
        }

        // Check if Quill is loaded
        if (typeof Quill === 'undefined') {
            console.log('❌ Quill is not loaded yet, retrying...');
            showStatus('Waiting for Quill.js...');
            isInitializing = false;
            setTimeout(initializeEditor, 50);
            return;
        }
        console.log('✅ Quill is available');

        // Initialize Quill editor
        try {
            // Check if already initialized
            if (editorElement.querySelector('.ql-container')) {
                console.log('Editor already initialized');
                return;
            }

            // Clear any existing content
            editorElement.innerHTML = '';

            console.log('🚀 Creating Quill instance...');
            showStatus('Creating editor...');
            quill = new Quill('#editor', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                        [{ 'font': [] }],
                        [{ 'size': [] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'script': 'sub'}, { 'script': 'super' }],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'indent': '-1'}, { 'indent': '+1' }],
                        [{ 'direction': 'rtl' }],
                        [{ 'align': [] }],
                        ['link', 'image', 'video'],
                        ['blockquote', 'code-block'],
                        ['clean']
                    ]
                },
                placeholder: 'Start typing your content here...'
            });

            console.log('✅✅✅ Quill editor created successfully!', quill);
            console.log('Editor element:', editorElement);
            console.log('Quill root:', quill.root);
            console.log('Quill container:', editorElement.querySelector('.ql-container'));
            
            // Mark as initialized
            window.editorInitialized = true;
            isInitializing = false;
            
            // Hide status indicator
            showStatus('Ready!');
            setTimeout(function() {
                const statusEl = document.getElementById('editor-status');
                if (statusEl) {
                    statusEl.style.display = 'none';
                }
            }, 1000);

            const contentTextarea = document.getElementById('content');
            const previewDiv = document.getElementById('live-preview');
            
            if (!contentTextarea || !previewDiv) {
                console.error('Required elements not found!', {contentTextarea, previewDiv});
                return;
            }
            
            // Set initial content
            let initialContent = contentTextarea.value || '';
            console.log('=== CONTENT LOADING DEBUG ===');
            console.log('Initial content length:', initialContent.length);
            console.log('Initial content (first 500 chars):', initialContent.substring(0, 500));
            console.log('Initial content (full):', initialContent);
            
            // Clean up the content - remove any extra whitespace
            initialContent = initialContent.trim();
            
            // Check if content has actual text (not just HTML tags)
            const textContent = initialContent.replace(/<[^>]*>/g, '').trim();
            console.log('Text content (without HTML):', textContent);
            console.log('Text content length:', textContent.length);
            
            if (initialContent && initialContent !== '' && initialContent !== '<p><br></p>' && initialContent !== '<p></p>' && textContent.length > 0) {
                // Set content in editor
                console.log('Setting content in Quill editor...');
                quill.root.innerHTML = initialContent;
                // Update preview
                previewDiv.innerHTML = initialContent;
                console.log('✅ Content loaded successfully in editor');
                console.log('Quill root innerHTML length:', quill.root.innerHTML.length);
            } else {
                // Set empty content
                console.log('⚠️ No valid content found, showing empty editor');
                quill.root.innerHTML = '<p><br></p>';
                previewDiv.innerHTML = '<p class="text-gray-400 italic">Start typing to see live preview...</p>';
            }

            // Live preview update on content change
            quill.on('text-change', function() {
                const html = quill.root.innerHTML;
                contentTextarea.value = html;
                previewDiv.innerHTML = html;
            });

            // Form submission - ensure content is updated
            const form = document.getElementById('pageForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const html = quill.root.innerHTML;
                    contentTextarea.value = html;
                    console.log('Form submitting with content');
                });
            }

            // Make editor focusable and clickable
            setTimeout(function() {
                try {
                    quill.focus();
                    const editorContainer = editorElement.querySelector('.ql-editor');
                    if (editorContainer) {
                        editorContainer.style.cursor = 'text';
                        editorContainer.setAttribute('contenteditable', 'true');
                        console.log('Editor focused and made editable');
                    }
                } catch (e) {
                    console.error('Error focusing editor:', e);
                }
            }, 200);
            
            console.log('Editor initialization complete!');
            
        } catch (error) {
            console.error('Error initializing Quill:', error);
            console.error('Error stack:', error.stack);
            const editorEl = document.getElementById('editor');
            if (editorEl) {
                editorEl.innerHTML = '<div style="padding: 20px; color: red; border: 2px solid red;"><strong>Error:</strong> ' + error.message + '<br><small>' + error.stack + '</small></div>';
            }
        }
    }

    // Start initialization - only once
    console.log('=== STARTING INITIALIZATION PROCESS ===');
    
    // Single initialization function
    function tryInit() {
        // Check if already initialized
        if (window.editorInitialized || isInitializing) {
            console.log('Skipping - already initialized or initializing');
            return;
        }
        
        console.log('Trying to initialize...');
        console.log('- Document ready:', document.readyState);
        console.log('- Quill available:', typeof Quill !== 'undefined');
        console.log('- Editor exists:', !!document.getElementById('editor'));
        
        const editorEl = document.getElementById('editor');
        if (editorEl && typeof Quill !== 'undefined') {
            // Check if already has Quill
            if (editorEl.querySelector('.ql-container')) {
                console.log('Editor already has Quill container');
                window.editorInitialized = true;
                return;
            }
            console.log('✅ All requirements met, initializing now!');
            initializeEditor();
        } else {
            console.log('⏳ Waiting for requirements...');
            setTimeout(tryInit, 100);
        }
    }
    
    // Use a single event listener
    let initStarted = false;
    function startInit() {
        if (initStarted) {
            console.log('Init already started, skipping...');
            return;
        }
        initStarted = true;
        console.log('Starting initialization...');
        setTimeout(tryInit, 300);
    }
    
    // Wait for DOM and Quill
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            console.log('📄 DOMContentLoaded event');
            startInit();
        }, { once: true });
    } else {
        console.log('📄 DOM already ready');
        startInit();
    }
    
    // Backup: window load (only if DOMContentLoaded didn't fire)
    window.addEventListener('load', function() {
        console.log('🌐 Window load event');
        if (!window.editorInitialized && !isInitializing) {
            startInit();
        }
    }, { once: true });
    
    console.log('=== INITIALIZATION SETUP COMPLETE ===');
})();

function resetContent() {
    if (confirm('Are you sure you want to reset to original content? All unsaved changes will be lost.')) {
        quill.root.innerHTML = originalContent;
        document.getElementById('content').value = originalContent;
        document.getElementById('live-preview').innerHTML = originalContent;
    }
}

function togglePreviewMode(mode) {
    const previewDiv = document.getElementById('live-preview');
    const buttons = document.querySelectorAll('.preview-mode-btn');
    
    // Remove active class from all buttons
    buttons.forEach(btn => {
        btn.classList.remove('active', 'bg-blue-100', 'text-blue-700');
        btn.classList.add('bg-gray-100', 'text-gray-700');
    });
    
    // Add active class to clicked button
    event.target.closest('button').classList.add('active', 'bg-blue-100', 'text-blue-700');
    event.target.closest('button').classList.remove('bg-gray-100', 'text-gray-700');
    
    // Apply preview mode styles
    previewDiv.className = 'preview-content';
    
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
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + S to save
    if ((e.ctrlKey || e.metaKey) && e.key === 's') {
        e.preventDefault();
        document.getElementById('pageForm').submit();
    }
});
</script>
@endpush
@endsection

