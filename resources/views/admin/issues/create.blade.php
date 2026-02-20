@extends('layouts.admin')

@section('title', 'Create Issue - EMANP')
@section('page-title', 'Create New Issue')
@section('page-subtitle', 'Add a new issue to a journal')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl border-2 border-gray-200 p-8">
        <form method="POST" action="{{ route('admin.issues.store') }}">
            @csrf
            
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Journal *</label>
                <select name="journal_id" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                    <option value="">Select Journal</option>
                    @foreach($journals as $journal)
                        <option value="{{ $journal->id }}" {{ old('journal_id') == $journal->id ? 'selected' : '' }}>{{ $journal->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Volume *</label>
                    <input type="number" name="volume" required value="{{ old('volume') }}"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Issue Number *</label>
                    <input type="number" name="issue_number" required value="{{ old('issue_number') }}"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Year *</label>
                    <input type="number" name="year" required value="{{ old('year', date('Y')) }}"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                </div>
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Display Title *</label>
                <input type="text" name="display_title" required value="{{ old('display_title') }}"
                       placeholder="e.g., Volume 1, Issue 1 (2025)"
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                <textarea name="description" rows="4"
                          class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">{{ old('description') }}</textarea>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Published Date</label>
                    <input type="date" name="published_date" value="{{ old('published_date') }}"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                </div>
                <div class="flex items-center">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}
                               class="w-4 h-4 text-[#0056FF] border-gray-300 rounded focus:ring-[#0056FF]">
                        <span class="text-sm font-semibold text-gray-700">Publish Issue</span>
                    </label>
                </div>
            </div>
            
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.issues.index') }}" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-semibold transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors">
                    Create Issue
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

