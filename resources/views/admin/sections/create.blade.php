@extends('layouts.admin')

@section('title', 'Create Section - ' . $journal->name)
@section('page-title', 'Create New Section')
@section('page-subtitle', $journal->name)

@section('content')
<div class="max-w-4xl mx-auto">
    <form method="POST" action="{{ route('admin.sections.store', $journal) }}" class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-8 space-y-6">
        @csrf
        
        <!-- Title -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Section Title <span class="text-red-500">*</span>
            </label>
            <input type="text" name="title" required
                   value="{{ old('title') }}"
                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF]"
                   placeholder="e.g., Research Articles, Review Articles, Case Studies">
            @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Description
            </label>
            <textarea name="description" rows="4"
                      class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF]"
                      placeholder="Describe the scope and purpose of this section...">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Section Editor -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Section Editor
            </label>
            <select name="section_editor_id"
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF]">
                <option value="">No Section Editor</option>
                @foreach($editors as $editor)
                <option value="{{ $editor->id }}" {{ old('section_editor_id') == $editor->id ? 'selected' : '' }}>
                    {{ $editor->full_name }} ({{ $editor->email }})
                </option>
                @endforeach
            </select>
            <p class="text-xs text-gray-500 mt-1">Assign a section editor to manage submissions in this section</p>
            @error('section_editor_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Word Limits -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Minimum Word Limit
                </label>
                <input type="number" name="word_limit_min" min="0"
                       value="{{ old('word_limit_min') }}"
                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF]"
                       placeholder="0">
                @error('word_limit_min')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Maximum Word Limit
                </label>
                <input type="number" name="word_limit_max" min="0"
                       value="{{ old('word_limit_max') }}"
                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF]"
                       placeholder="No limit">
                @error('word_limit_max')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Review Type -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Review Type <span class="text-red-500">*</span>
            </label>
            <select name="review_type" required
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF]">
                <option value="double_blind" {{ old('review_type', 'double_blind') === 'double_blind' ? 'selected' : '' }}>
                    Double-Blind Review (Recommended)
                </option>
                <option value="single_blind" {{ old('review_type') === 'single_blind' ? 'selected' : '' }}>
                    Single-Blind Review
                </option>
                <option value="open" {{ old('review_type') === 'open' ? 'selected' : '' }}>
                    Open Review
                </option>
            </select>
            <p class="text-xs text-gray-500 mt-1">
                <strong>Double-Blind:</strong> Reviewer and author identities are hidden<br>
                <strong>Single-Blind:</strong> Reviewer identity is hidden from author<br>
                <strong>Open:</strong> Both identities are visible
            </p>
            @error('review_type')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Order -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Display Order
            </label>
            <input type="number" name="order" min="0"
                   value="{{ old('order', 0) }}"
                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF]"
                   placeholder="0">
            <p class="text-xs text-gray-500 mt-1">Lower numbers appear first. Default: 0</p>
            @error('order')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Active Status -->
        <div class="flex items-center">
            <input type="checkbox" name="is_active" id="is_active" value="1" 
                   {{ old('is_active', true) ? 'checked' : '' }}
                   class="h-5 w-5 text-[#0056FF] focus:ring-[#0056FF] border-gray-300 rounded">
            <label for="is_active" class="ml-3 block text-sm font-semibold text-gray-700">
                Active Section
            </label>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
            <a href="{{ route('admin.sections.index', $journal) }}" 
               class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-semibold transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Cancel
            </a>
            <button type="submit" 
                    class="px-6 py-3 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors shadow-lg">
                <i class="fas fa-save mr-2"></i>Create Section
            </button>
        </div>
    </form>
</div>
@endsection

