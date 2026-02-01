@extends('layouts.admin')

@section('title', 'Edit Widget - ' . $widget->name)
@section('page-title', 'Edit Widget')
@section('page-subtitle', 'Update widget content and settings')

@section('content')
<div class="max-w-4xl mx-auto">
    <form method="POST" action="{{ route('admin.page-builder.widgets.update', $widget) }}" id="widgetForm" x-data="widgetEditor()">
        @csrf
        @method('PUT')
        
        <div class="bg-white rounded-xl border-2 border-gray-200 p-6 space-y-6">
            <!-- Widget Type -->
            <div>
                <label for="type" class="block text-sm font-semibold text-gray-700 mb-2">
                    Widget Type <span class="text-red-500">*</span>
                </label>
                <select id="type" 
                        name="type" 
                        required
                        x-model="widgetType"
                        @change="updateForm()"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors">
                    @foreach($types as $key => $name)
                    <option value="{{ $key }}" {{ $widget->type === $key ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Widget Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                    Widget Name <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       required
                       value="{{ old('name', $widget->name) }}"
                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors">
            </div>

            <!-- Location -->
            <div>
                <label for="location" class="block text-sm font-semibold text-gray-700 mb-2">
                    Location
                </label>
                <select id="location" 
                        name="location" 
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF] transition-colors">
                    <option value="">Select Location</option>
                    <option value="homepage" {{ $widget->location === 'homepage' ? 'selected' : '' }}>Homepage</option>
                    <option value="sidebar" {{ $widget->location === 'sidebar' ? 'selected' : '' }}>Sidebar</option>
                    <option value="footer" {{ $widget->location === 'footer' ? 'selected' : '' }}>Footer</option>
                    <option value="header" {{ $widget->location === 'header' ? 'selected' : '' }}>Header</option>
                </select>
            </div>

            <!-- Widget Content -->
            <div>
                <h3 class="text-lg font-bold text-[#0F1B4C] mb-4">
                    <i class="fas fa-edit mr-2 text-[#0056FF]"></i>Widget Content
                </h3>
                <div x-html="widgetForm"></div>
            </div>

            <!-- Status -->
            <div class="flex items-center">
                <input type="checkbox" 
                       id="is_active" 
                       name="is_active" 
                       value="1"
                       {{ old('is_active', $widget->is_active) ? 'checked' : '' }}
                       class="h-5 w-5 text-[#0056FF] focus:ring-[#0056FF] border-gray-300 rounded">
                <label for="is_active" class="ml-3 block text-sm text-gray-700 cursor-pointer">
                    Active
                </label>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.page-builder.widgets.index', $widget->journal) }}" 
                   class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-semibold transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors shadow-lg">
                    <i class="fas fa-save mr-2"></i>Update Widget
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
function widgetEditor() {
    return {
        widgetType: '{{ $widget->type }}',
        widgetForm: '',
        
        init() {
            this.updateForm();
        },
        
        updateForm() {
            this.widgetForm = this.generateFormForType(this.widgetType);
        },
        
        generateFormForType(type) {
            const content = @json($widget->content);
            const forms = {
                hero: `
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Title</label>
                            <input type="text" name="content[title]" value="${content.title || ''}" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Subtitle</label>
                            <input type="text" name="content[subtitle]" value="${content.subtitle || ''}" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Button Text</label>
                            <input type="text" name="content[buttonText]" value="${content.buttonText || ''}" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Button Link</label>
                            <input type="text" name="content[buttonLink]" value="${content.buttonLink || '#'}" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg">
                        </div>
                    </div>
                `,
                text: `
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Content</label>
                        <textarea name="content[content]" rows="8" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg">${content.content || ''}</textarea>
                    </div>
                `
            };
            
            return forms[type] || `
                <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <p class="text-sm text-yellow-800 mb-2">Advanced widget configuration (JSON format):</p>
                    <textarea name="content[json]" rows="10" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg font-mono text-xs">${JSON.stringify(content, null, 2)}</textarea>
                </div>
            `;
        }
    }
}
</script>
@endpush
@endsection

