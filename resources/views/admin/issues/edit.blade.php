@extends('layouts.admin')

@section('title', 'Edit Issue - EMANP')
@section('page-title', 'Edit Issue')
@section('page-subtitle', 'Update issue information and assign articles')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl border-2 border-gray-200 p-8 mb-6">
            <form method="POST" action="{{ route('admin.issues.update', $issue) }}">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Volume *</label>
                        <input type="number" name="volume" required value="{{ old('volume', $issue->volume) }}"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Issue Number *</label>
                        <input type="number" name="issue_number" required value="{{ old('issue_number', $issue->issue_number) }}"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Year *</label>
                        <input type="number" name="year" required value="{{ old('year', $issue->year) }}"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                    </div>
                </div>
                
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Display Title *</label>
                    <input type="text" name="display_title" required value="{{ old('display_title', $issue->display_title) }}"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                </div>
                
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="4"
                              class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">{{ old('description', $issue->description) }}</textarea>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Published Date</label>
                        <input type="date" name="published_date" value="{{ old('published_date', $issue->published_date ? (is_string($issue->published_date) ? $issue->published_date : $issue->published_date->format('Y-m-d')) : '') }}"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                    </div>
                    <div class="flex items-center">
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="is_published" value="1" {{ old('is_published', $issue->is_published) ? 'checked' : '' }}
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
                        Update Issue
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <div>
        <div class="bg-white rounded-xl border-2 border-gray-200 p-6">
            <h3 class="text-lg font-bold text-[#0F1B4C] mb-4">Assign Articles</h3>
            @if($articles->count() > 0)
                <div class="space-y-3">
                    @foreach($articles as $article)
                        <div class="p-3 bg-[#F7F9FC] rounded-lg">
                            <p class="text-sm font-semibold text-[#0F1B4C] mb-1">{{ Str::limit($article->title, 40) }}</p>
                            <button class="text-xs text-[#0056FF] hover:text-[#0044CC]">Assign to Issue</button>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-600">No published articles available</p>
            @endif
        </div>
    </div>
</div>
@endsection

