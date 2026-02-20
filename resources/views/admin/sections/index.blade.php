@extends('layouts.admin')

@section('title', 'Sections Management - ' . $journal->name)
@section('page-title', 'Sections Management')
@section('page-subtitle', $journal->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-xl font-bold text-[#0F1B4C]">{{ $journal->name }} - Sections</h3>
                <p class="text-gray-600 mt-1">Manage journal sections and assign editors</p>
            </div>
            <a href="{{ route('admin.sections.create', $journal) }}" 
               class="px-6 py-3 bg-gradient-to-r from-[#0056FF] to-indigo-600 hover:from-[#0044CC] hover:to-indigo-700 text-white rounded-lg font-semibold transition-colors shadow-lg">
                <i class="fas fa-plus mr-2"></i>Create Section
            </a>
        </div>
    </div>

    <!-- Sections List -->
    <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-[#0F1B4C]">
                <i class="fas fa-list mr-2 text-[#0056FF]"></i>All Sections
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-[#0056FF] to-[#1D72B8]">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Order</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Title</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Section Editor</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Word Limits</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Review Type</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-white uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($sections as $section)
                    <tr class="hover:bg-blue-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm font-semibold">
                                {{ $section->order }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-semibold text-gray-900">{{ $section->title }}</div>
                            @if($section->description)
                            <div class="text-xs text-gray-500 mt-1">{{ Str::limit($section->description, 50) }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($section->sectionEditor)
                            <div class="text-sm text-gray-700">{{ $section->sectionEditor->full_name }}</div>
                            @else
                            <span class="text-gray-400 text-sm">Not assigned</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($section->word_limit_min || $section->word_limit_max)
                            <span class="text-sm text-gray-700">
                                {{ $section->word_limit_min ?? '0' }} - {{ $section->word_limit_max ?? '∞' }} words
                            </span>
                            @else
                            <span class="text-gray-400 text-sm">No limit</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                {{ $section->review_type === 'double_blind' ? 'bg-blue-100 text-blue-800' : 
                                   ($section->review_type === 'single_blind' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800') }}">
                                {{ ucfirst(str_replace('_', ' ', $section->review_type)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                {{ $section->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $section->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right text-sm font-medium">
                            <a href="{{ route('admin.sections.edit', [$journal, $section]) }}" 
                               class="text-[#0056FF] hover:text-[#0044CC] font-semibold mr-4">
                                <i class="fas fa-edit mr-1"></i>Edit
                            </a>
                            <form action="{{ route('admin.sections.destroy', [$journal, $section]) }}" 
                                  method="POST" 
                                  class="inline"
                                  onsubmit="return confirm('Are you sure you want to delete this section?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">
                                    <i class="fas fa-trash mr-1"></i>Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <i class="fas fa-folder-open text-6xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500 text-lg font-semibold">No sections found</p>
                            <p class="text-gray-400 mb-4">Create your first section to organize submissions</p>
                            <a href="{{ route('admin.sections.create', $journal) }}" 
                               class="inline-block bg-[#0056FF] hover:bg-[#0044CC] text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                                <i class="fas fa-plus mr-2"></i>Create First Section
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

