@extends('layouts.admin')

@section('title', 'Custom Pages - EMANP')
@section('page-title', 'Custom Pages')
@section('page-subtitle', 'Create and manage custom pages for your website')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="bg-white rounded-xl border-2 border-gray-200 p-6 flex justify-between items-center">
        <div>
            <h3 class="text-lg font-bold text-[#0F1B4C]">Custom Pages</h3>
            <p class="text-sm text-gray-600">Total: {{ $pages->total() }} pages</p>
        </div>
        <a href="{{ route('admin.page-builder.pages.create', $journal ?? null) }}" 
           class="bg-[#0056FF] hover:bg-[#0044CC] text-white px-6 py-3 rounded-lg font-semibold transition-colors shadow-lg transform hover:scale-105">
            <i class="fas fa-plus mr-2"></i>Create New Page
        </a>
    </div>

    <!-- Pages Table -->
    <div class="bg-white rounded-xl border-2 border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-[#0056FF] to-[#1D72B8]">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Title</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Slug</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">In Menu</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Created</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($pages as $page)
                <tr class="hover:bg-blue-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-[#0056FF] rounded-lg flex items-center justify-center text-white mr-3">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-gray-900">{{ $page->title }}</div>
                                @if($page->journal)
                                <div class="text-xs text-gray-500">{{ $page->journal->name }}</div>
                                @else
                                <div class="text-xs text-gray-500">Global Page</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <code class="text-xs bg-gray-100 px-2 py-1 rounded">{{ $page->slug }}</code>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($page->is_published)
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">
                            <i class="fas fa-check-circle mr-1"></i>Published
                        </span>
                        @else
                        <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-semibold">
                            <i class="fas fa-clock mr-1"></i>Draft
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($page->show_in_menu)
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                            <i class="fas fa-check mr-1"></i>Yes
                        </span>
                        @else
                        <span class="text-gray-400 text-xs">No</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $page->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end space-x-2">
                            <a href="{{ route('admin.page-builder.pages.edit', $page) }}" 
                               class="text-blue-600 hover:text-blue-800 p-2 hover:bg-blue-50 rounded-lg transition-colors"
                               title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if($page->is_published)
                            <a href="{{ $page->journal ? route('journals.custom-page', [$page->journal->slug, $page->slug]) : '#' }}" 
                               target="_blank"
                               class="text-green-600 hover:text-green-800 p-2 hover:bg-green-50 rounded-lg transition-colors"
                               title="View">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                            @endif
                            <form action="{{ route('admin.page-builder.pages.destroy', $page) }}" 
                                  method="POST" 
                                  class="inline"
                                  onsubmit="return confirm('Are you sure you want to delete this page?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-600 hover:text-red-800 p-2 hover:bg-red-50 rounded-lg transition-colors"
                                        title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <i class="fas fa-file-alt text-6xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500 text-lg font-semibold mb-2">No custom pages yet</p>
                        <p class="text-gray-400 mb-4">Create your first custom page to get started</p>
                        <a href="{{ route('admin.page-builder.pages.create', $journal ?? null) }}" 
                           class="inline-block bg-[#0056FF] hover:bg-[#0044CC] text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                            <i class="fas fa-plus mr-2"></i>Create First Page
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($pages->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $pages->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

