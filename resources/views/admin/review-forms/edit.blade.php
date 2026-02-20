@extends('layouts.admin')

@section('title', 'Edit Review Form - EMANP')
@section('page-title', 'Edit Review Form')
@section('page-subtitle', 'Update review form details')

@section('content')
<div class="bg-white rounded-xl border-2 border-gray-200 p-6 max-w-4xl mx-auto">
    <form method="POST" action="{{ route('admin.review-forms.update', $reviewForm) }}">
        @csrf
        @method('PUT')
        
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Journal *</label>
                <select name="journal_id" required class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                    <option value="">Select Journal</option>
                    @foreach($journals as $journal)
                        <option value="{{ $journal->id }}" {{ old('journal_id', $reviewForm->journal_id) == $journal->id ? 'selected' : '' }}>
                            {{ $journal->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Form Name *</label>
                <input type="text" name="name" value="{{ old('name', $reviewForm->name) }}" required 
                       class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                <textarea name="description" rows="3" 
                          class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">{{ old('description', $reviewForm->description) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Questions (JSON Format) *</label>
                <textarea name="questions" rows="10" required 
                          class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] font-mono text-sm">{{ old('questions', json_encode($reviewForm->questions ?? [], JSON_PRETTY_PRINT)) }}</textarea>
            </div>

            <div class="flex items-center space-x-4">
                <label class="flex items-center">
                    <input type="checkbox" name="is_default" value="1" {{ old('is_default', $reviewForm->is_default) ? 'checked' : '' }}
                           class="w-4 h-4 text-[#0056FF] border-gray-300 rounded focus:ring-[#0056FF]">
                    <span class="ml-2 text-sm text-gray-700">Set as default form</span>
                </label>
            </div>

            <div class="flex items-center space-x-4">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $reviewForm->is_active) ? 'checked' : '' }}
                           class="w-4 h-4 text-[#0056FF] border-gray-300 rounded focus:ring-[#0056FF]">
                    <span class="ml-2 text-sm text-gray-700">Active</span>
                </label>
            </div>

            <div class="flex space-x-3 pt-4">
                <button type="submit" class="px-6 py-3 bg-[#0056FF] text-white rounded-lg hover:bg-[#0044CC] transition-colors font-semibold">
                    <i class="fas fa-save mr-2"></i>Update Review Form
                </button>
                <a href="{{ route('admin.review-forms.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-semibold">
                    Cancel
                </a>
            </div>
        </div>
    </form>
</div>
@endsection

