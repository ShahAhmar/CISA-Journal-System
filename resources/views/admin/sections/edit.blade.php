@extends('layouts.admin')

@section('title', 'Edit Section - ' . $section->title)
@section('page-title', 'Edit Section')
@section('page-subtitle', $section->title)

@section('content')
<div class="max-w-4xl mx-auto">
    <form method="POST" action="{{ route('admin.sections.update', [$journal, $section]) }}" class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-8 space-y-6">
        @csrf
        @method('PUT')
        
        <!-- Title -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Section Title <span class="text-red-500">*</span>
            </label>
            <input type="text" name="title" required
                   value="{{ old('title', $section->title) }}"
                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF]">
            @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
            <textarea name="description" rows="4"
                      class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF]">{{ old('description', $section->description) }}</textarea>
        </div>

        <!-- Section Editor -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Section Editor</label>
            <select name="section_editor_id"
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF]">
                <option value="">No Section Editor</option>
                @foreach($editors as $editor)
                <option value="{{ $editor->id }}" {{ old('section_editor_id', $section->section_editor_id) == $editor->id ? 'selected' : '' }}>
                    {{ $editor->full_name }} ({{ $editor->email }})
                </option>
                @endforeach
            </select>
        </div>

        <!-- Word Limits -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Minimum Word Limit</label>
                <input type="number" name="word_limit_min" min="0"
                       value="{{ old('word_limit_min', $section->word_limit_min) }}"
                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF]">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Maximum Word Limit</label>
                <input type="number" name="word_limit_max" min="0"
                       value="{{ old('word_limit_max', $section->word_limit_max) }}"
                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF]">
            </div>
        </div>

        <!-- Review Type -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Review Type <span class="text-red-500">*</span></label>
            <select name="review_type" required
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF]">
                <option value="double_blind" {{ old('review_type', $section->review_type) === 'double_blind' ? 'selected' : '' }}>Double-Blind Review</option>
                <option value="single_blind" {{ old('review_type', $section->review_type) === 'single_blind' ? 'selected' : '' }}>Single-Blind Review</option>
                <option value="open" {{ old('review_type', $section->review_type) === 'open' ? 'selected' : '' }}>Open Review</option>
            </select>
        </div>

        <!-- Order -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Display Order</label>
            <input type="number" name="order" min="0"
                   value="{{ old('order', $section->order) }}"
                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF]">
        </div>

        <!-- Active Status -->
        <div class="flex items-center">
            <input type="checkbox" name="is_active" id="is_active" value="1" 
                   {{ old('is_active', $section->is_active) ? 'checked' : '' }}
                   class="h-5 w-5 text-[#0056FF] focus:ring-[#0056FF] border-gray-300 rounded">
            <label for="is_active" class="ml-3 block text-sm font-semibold text-gray-700">Active Section</label>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
            <a href="{{ route('admin.sections.index', $journal) }}" 
               class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-semibold transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Cancel
            </a>
            <button type="submit" 
                    class="px-6 py-3 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors shadow-lg">
                <i class="fas fa-save mr-2"></i>Update Section
            </button>
        </div>
    </form>
</div>
@endsection

