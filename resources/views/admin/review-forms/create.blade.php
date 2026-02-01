@extends('layouts.admin')

@section('title', 'Create Review Form - EMANP')
@section('page-title', 'Create Review Form')
@section('page-subtitle', 'Create a new custom review form')

@section('content')
<div class="bg-white rounded-xl border-2 border-gray-200 p-6 max-w-4xl mx-auto">
    <form method="POST" action="{{ route('admin.review-forms.store') }}">
        @csrf
        
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Journal *</label>
                <select name="journal_id" required class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                    <option value="">Select Journal</option>
                    @foreach($journals as $journal)
                        <option value="{{ $journal->id }}" {{ old('journal_id') == $journal->id ? 'selected' : '' }}>
                            {{ $journal->name }}
                        </option>
                    @endforeach
                </select>
                @error('journal_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Form Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" required 
                       class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]"
                       placeholder="e.g., Standard Review Form">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                <textarea name="description" rows="3" 
                          class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]"
                          placeholder="Brief description of this review form">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Questions (JSON Format) *</label>
                <textarea name="questions" rows="10" required 
                          class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] font-mono text-sm"
                          placeholder='[{"type":"text","question":"Overall assessment","required":true},{"type":"rating","question":"Rate the quality","required":true}]'>{{ old('questions', '[]') }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Enter questions as JSON array. Each question should have: type, question, required fields.</p>
                @error('questions')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center space-x-4">
                <label class="flex items-center">
                    <input type="checkbox" name="is_default" value="1" {{ old('is_default') ? 'checked' : '' }}
                           class="w-4 h-4 text-[#0056FF] border-gray-300 rounded focus:ring-[#0056FF]">
                    <span class="ml-2 text-sm text-gray-700">Set as default form for this journal</span>
                </label>
            </div>

            <div class="flex items-center space-x-4">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                           class="w-4 h-4 text-[#0056FF] border-gray-300 rounded focus:ring-[#0056FF]">
                    <span class="ml-2 text-sm text-gray-700">Active</span>
                </label>
            </div>

            <div class="flex space-x-3 pt-4">
                <button type="submit" class="px-6 py-3 bg-[#0056FF] text-white rounded-lg hover:bg-[#0044CC] transition-colors font-semibold">
                    <i class="fas fa-save mr-2"></i>Create Review Form
                </button>
                <a href="{{ route('admin.review-forms.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-semibold">
                    Cancel
                </a>
            </div>
        </div>
    </form>
</div>
@endsection

