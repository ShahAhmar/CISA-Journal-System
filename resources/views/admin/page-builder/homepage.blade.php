@extends('layouts.admin')

@section('title', 'Page Builder - Homepage - ' . $journal->name)
@section('page-title', 'Page Builder - Homepage')
@section('page-subtitle', 'Drag and drop widgets to customize your homepage')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.css" rel="stylesheet">
<style>
    .widget-item {
        cursor: move;
        transition: all 0.3s;
    }
    .widget-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .widget-item.dragging {
        opacity: 0.5;
    }
    .drop-zone {
        min-height: 100px;
        border: 2px dashed #cbd5e0;
        border-radius: 8px;
        padding: 20px;
        transition: all 0.3s;
    }
    .drop-zone.drag-over {
        border-color: #0056FF;
        background-color: #f0f9ff;
    }
    .widget-preview {
        background: white;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 15px;
        border: 2px solid #e5e7eb;
    }
    .widget-preview.selected {
        border-color: #0056FF;
        box-shadow: 0 0 0 3px rgba(0, 86, 255, 0.1);
    }
</style>
@endpush

@section('content')
<div x-data="pageBuilder()" class="space-y-6">
    <!-- Header Actions -->
    <div class="bg-white rounded-xl border-2 border-gray-200 p-6 flex justify-between items-center">
        <div>
            <h3 class="text-lg font-bold text-[#0F1B4C]">Homepage Builder - {{ $journal->name }}</h3>
            <p class="text-sm text-gray-600">Drag widgets from right sidebar and drop them in the preview area</p>
        </div>
        <div class="flex space-x-3">
            <button @click="previewMode = !previewMode" 
                    class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-semibold transition-colors">
                <i class="fas" :class="previewMode ? 'fa-edit' : 'fa-eye'"></i>
                <span class="ml-2" x-text="previewMode ? 'Edit Mode' : 'Preview'"></span>
            </button>
            <button @click="saveLayout()" 
                    :disabled="saving"
                    class="px-6 py-2 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors disabled:opacity-50">
                <i class="fas fa-save mr-2"></i>
                <span x-text="saving ? 'Saving...' : 'Save Layout'"></span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Widget Library Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl border-2 border-gray-200 p-6 sticky top-6">
                <h4 class="text-lg font-bold text-[#0F1B4C] mb-4">
                    <i class="fas fa-cubes mr-2 text-[#0056FF]"></i>Widget Library
                </h4>
                
                <div class="space-y-2 max-h-[600px] overflow-y-auto">
                    <template x-for="widgetType in availableWidgets" :key="widgetType.type">
                        <div @click="addWidget(widgetType.type)" 
                             class="widget-item p-4 bg-gray-50 hover:bg-blue-50 rounded-lg border-2 border-gray-200 hover:border-[#0056FF] cursor-pointer transition-all">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-[#0056FF] rounded-lg flex items-center justify-center text-white">
                                    <i :class="widgetType.icon"></i>
                                </div>
                                <div class="flex-1">
                                    <h5 class="font-semibold text-gray-800" x-text="widgetType.name"></h5>
                                    <p class="text-xs text-gray-500" x-text="widgetType.description"></p>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h5 class="font-semibold text-gray-700 mb-3">Saved Widgets</h5>
                    <div class="space-y-2 max-h-[300px] overflow-y-auto">
                        @foreach($widgets as $widget)
                        <div @click="addSavedWidget({{ $widget->id }})" 
                             class="p-3 bg-gray-50 hover:bg-blue-50 rounded-lg border border-gray-200 hover:border-[#0056FF] cursor-pointer transition-all">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-semibold text-sm text-gray-800">{{ $widget->name }}</p>
                                    <p class="text-xs text-gray-500">{{ ucfirst($widget->type) }}</p>
                                </div>
                                <i class="fas fa-plus-circle text-[#0056FF]"></i>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Preview/Edit Area -->
        <div class="lg:col-span-3">
            <div class="bg-white rounded-xl border-2 border-gray-200 p-6">
                <div class="mb-4 flex items-center justify-between">
                    <h4 class="text-lg font-bold text-[#0F1B4C]">
                        <i class="fas fa-desktop mr-2 text-[#0056FF]"></i>Homepage Preview</i>
                    </h4>
                    <div class="text-sm text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        <span x-text="'Widgets: ' + widgets.length"></span>
                    </div>
                </div>

                <!-- Drop Zone -->
                <div id="widget-container" 
                     class="drop-zone min-h-[400px]"
                     :class="{ 'drag-over': dragOver }"
                     @dragover.prevent="dragOver = true"
                     @dragleave.prevent="dragOver = false"
                     @drop.prevent="handleDrop($event)">
                    
                    <template x-if="widgets.length === 0">
                        <div class="text-center py-20">
                            <i class="fas fa-mouse-pointer text-6xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500 text-lg font-semibold mb-2">No widgets yet</p>
                            <p class="text-gray-400">Click on widgets from the sidebar to add them here</p>
                        </div>
                    </template>

                    <template x-for="(widget, index) in widgets" :key="index">
                        <div class="widget-preview mb-4" 
                             :class="{ 'selected': selectedWidget === index }"
                             @click="selectedWidget = index"
                             :data-index="index">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-[#0056FF] rounded-lg flex items-center justify-center text-white">
                                        <i :class="getWidgetIcon(widget.type)"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-semibold text-gray-800" x-text="getWidgetName(widget.type)"></h5>
                                        <p class="text-xs text-gray-500" x-text="'Widget #' + (index + 1)"></p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <button @click="editWidget(index)" 
                                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                            title="Edit Widget">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button @click="removeWidget(index)" 
                                            class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                            title="Remove Widget">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <div class="p-2 text-gray-400 cursor-move" title="Drag to reorder">
                                        <i class="fas fa-grip-vertical"></i>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Widget Preview Content -->
                            <div class="widget-content" x-html="renderWidgetPreview(widget)"></div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <!-- Widget Editor Modal -->
    <div x-show="showEditor" 
         x-cloak
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
         @click.self="showEditor = false">
        <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-xl font-bold text-[#0F1B4C]">
                    <i class="fas fa-edit mr-2 text-[#0056FF]"></i>Edit Widget
                </h3>
                <button @click="showEditor = false" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div class="p-6">
                <div x-html="widgetEditorForm"></div>
            </div>
            
            <div class="p-6 border-t border-gray-200 flex justify-end space-x-3">
                <button @click="showEditor = false" 
                        class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-semibold transition-colors">
                    Cancel
                </button>
                <button @click="saveWidget()" 
                        class="px-6 py-2 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors">
                    Save Widget
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
function pageBuilder() {
    return {
        widgets: @json($homepageWidgets ?? []),
        availableWidgets: [
            { type: 'hero', name: 'Hero Section', icon: 'fas fa-image', description: 'Large banner with heading' },
            { type: 'text', name: 'Text Block', icon: 'fas fa-align-left', description: 'Rich text content' },
            { type: 'image', name: 'Image', icon: 'fas fa-image', description: 'Single image display' },
            { type: 'gallery', name: 'Gallery', icon: 'fas fa-images', description: 'Image gallery' },
            { type: 'testimonial', name: 'Testimonials', icon: 'fas fa-quote-left', description: 'Customer reviews' },
            { type: 'stats', name: 'Statistics', icon: 'fas fa-chart-bar', description: 'Numbers/stats display' },
            { type: 'latest_articles', name: 'Latest Articles', icon: 'fas fa-newspaper', description: 'Recent publications' },
            { type: 'call_to_action', name: 'Call to Action', icon: 'fas fa-bullhorn', description: 'CTA buttons' },
            { type: 'video', name: 'Video', icon: 'fas fa-video', description: 'Video embed' },
            { type: 'contact_form', name: 'Contact Form', icon: 'fas fa-envelope', description: 'Contact form' },
            { type: 'team', name: 'Team', icon: 'fas fa-users', description: 'Team members' },
            { type: 'features', name: 'Features', icon: 'fas fa-star', description: 'Features grid' },
            { type: 'faq', name: 'FAQ', icon: 'fas fa-question-circle', description: 'FAQ accordion' },
            { type: 'newsletter', name: 'Newsletter', icon: 'fas fa-paper-plane', description: 'Email signup' },
        ],
        selectedWidget: null,
        showEditor: false,
        editingIndex: null,
        widgetEditorForm: '',
        dragOver: false,
        previewMode: false,
        saving: false,

        init() {
            // Initialize Sortable for drag-and-drop
            new Sortable(document.getElementById('widget-container'), {
                animation: 150,
                handle: '.fa-grip-vertical',
                onEnd: (evt) => {
                    const item = this.widgets.splice(evt.oldIndex, 1)[0];
                    this.widgets.splice(evt.newIndex, 0, item);
                }
            });
        },

        addWidget(type) {
            const widget = {
                id: Date.now(),
                type: type,
                content: this.getDefaultContent(type),
                settings: {}
            };
            this.widgets.push(widget);
        },

        addSavedWidget(widgetId) {
            // Fetch widget from server and add
            fetch(`/admin/page-builder/widgets/${widgetId}`)
                .then(res => res.json())
                .then(data => {
                    this.widgets.push({
                        id: Date.now(),
                        type: data.type,
                        content: data.content,
                        settings: data.settings || {}
                    });
                });
        },

        getDefaultContent(type) {
            const defaults = {
                hero: { title: 'Welcome', subtitle: 'Enter your subtitle', buttonText: 'Get Started', buttonLink: '#' },
                text: { content: 'Enter your text content here...' },
                image: { url: '', alt: 'Image' },
                gallery: { images: [] },
                testimonial: { quotes: [] },
                stats: { items: [{ number: '0', label: 'Stat' }] },
                latest_articles: { count: 6, showExcerpt: true },
                call_to_action: { title: 'Call to Action', text: 'Description', buttonText: 'Click Here', buttonLink: '#' },
                video: { url: '', title: 'Video' },
                contact_form: { title: 'Contact Us', fields: ['name', 'email', 'message'] },
                team: { members: [] },
                features: { items: [] },
                faq: { items: [] },
                newsletter: { title: 'Subscribe', text: 'Get updates' }
            };
            return defaults[type] || {};
        },

        editWidget(index) {
            this.editingIndex = index;
            this.showEditor = true;
            this.widgetEditorForm = this.generateEditorForm(this.widgets[index]);
        },

        generateEditorForm(widget) {
            // Generate form based on widget type
            let form = `<input type="hidden" x-model="widgets[${this.editingIndex}].type" value="${widget.type}">`;
            
            if (widget.type === 'hero') {
                form += `
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Title</label>
                            <input type="text" x-model="widgets[${this.editingIndex}].content.title" 
                                   class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-[#0056FF] focus:outline-none"
                                   value="${widget.content.title || ''}">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Subtitle</label>
                            <input type="text" x-model="widgets[${this.editingIndex}].content.subtitle" 
                                   class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-[#0056FF] focus:outline-none"
                                   value="${widget.content.subtitle || ''}">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Button Text</label>
                            <input type="text" x-model="widgets[${this.editingIndex}].content.buttonText" 
                                   class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-[#0056FF] focus:outline-none"
                                   value="${widget.content.buttonText || ''}">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Button Link</label>
                            <input type="text" x-model="widgets[${this.editingIndex}].content.buttonLink" 
                                   class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-[#0056FF] focus:outline-none"
                                   value="${widget.content.buttonLink || '#'}">
                        </div>
                    </div>
                `;
            } else if (widget.type === 'text') {
                form += `
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Content</label>
                        <textarea x-model="widgets[${this.editingIndex}].content.content" 
                                  rows="10"
                                  class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-[#0056FF] focus:outline-none">${widget.content.content || ''}</textarea>
                    </div>
                `;
            } else {
                form += `<p class="text-gray-500">Widget editor for ${widget.type} coming soon. Use JSON editor for now.</p>`;
            }
            
            return form;
        },

        saveWidget() {
            this.showEditor = false;
        },

        removeWidget(index) {
            if (confirm('Are you sure you want to remove this widget?')) {
                this.widgets.splice(index, 1);
                if (this.selectedWidget === index) {
                    this.selectedWidget = null;
                }
            }
        },

        getWidgetIcon(type) {
            const icons = {
                hero: 'fas fa-image',
                text: 'fas fa-align-left',
                image: 'fas fa-image',
                gallery: 'fas fa-images',
                testimonial: 'fas fa-quote-left',
                stats: 'fas fa-chart-bar',
                latest_articles: 'fas fa-newspaper',
                call_to_action: 'fas fa-bullhorn',
                video: 'fas fa-video',
                contact_form: 'fas fa-envelope',
                team: 'fas fa-users',
                features: 'fas fa-star',
                faq: 'fas fa-question-circle',
                newsletter: 'fas fa-paper-plane'
            };
            return icons[type] || 'fas fa-cube';
        },

        getWidgetName(type) {
            const names = {
                hero: 'Hero Section',
                text: 'Text Block',
                image: 'Image',
                gallery: 'Gallery',
                testimonial: 'Testimonials',
                stats: 'Statistics',
                latest_articles: 'Latest Articles',
                call_to_action: 'Call to Action',
                video: 'Video',
                contact_form: 'Contact Form',
                team: 'Team',
                features: 'Features',
                faq: 'FAQ',
                newsletter: 'Newsletter'
            };
            return names[type] || type;
        },

        renderWidgetPreview(widget) {
            if (widget.type === 'hero') {
                return `
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-8 rounded-lg text-center">
                        <h2 class="text-3xl font-bold mb-2">${widget.content.title || 'Welcome'}</h2>
                        <p class="text-lg mb-4">${widget.content.subtitle || 'Enter subtitle'}</p>
                        <button class="bg-white text-blue-600 px-6 py-2 rounded-lg font-semibold">${widget.content.buttonText || 'Get Started'}</button>
                    </div>
                `;
            } else if (widget.type === 'text') {
                return `<div class="prose max-w-none"><p>${widget.content.content || 'Enter text content...'}</p></div>`;
            } else if (widget.type === 'latest_articles') {
                return `<div class="text-center py-8 text-gray-500"><i class="fas fa-newspaper text-4xl mb-2"></i><p>Latest Articles Widget</p></div>`;
            } else {
                return `<div class="text-center py-8 text-gray-500"><i class="${this.getWidgetIcon(widget.type)} text-4xl mb-2"></i><p>${this.getWidgetName(widget.type)} Widget</p></div>`;
            }
        },

        handleDrop(event) {
            this.dragOver = false;
            // Handle drop logic if needed
        },

        async saveLayout() {
            this.saving = true;
            
            try {
                const response = await fetch('{{ route("admin.journal.page-builder.save", $journal) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        widgets: this.widgets.map((w, i) => ({
                            id: w.id,
                            type: w.type,
                            content: w.content,
                            settings: w.settings,
                            order: i
                        }))
                    })
                });

                const data = await response.json();
                
                if (data.success) {
                    alert('Layout saved successfully!');
                } else {
                    alert('Error saving layout');
                }
            } catch (error) {
                alert('Error: ' + error.message);
            } finally {
                this.saving = false;
            }
        }
    }
}
</script>
<style>
[x-cloak] { display: none !important; }
</style>
@endpush
@endsection

