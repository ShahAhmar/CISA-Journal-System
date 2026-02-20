@extends('layouts.admin')

@section('title', 'Manage Journals - EMANP')
@section('page-title', 'Manage Journals')
@section('page-subtitle', 'View and manage all journals on the platform')

@section('content')
<!-- Header Actions -->
<div class="bg-white rounded-xl border-2 border-gray-200 p-6 mb-6 flex justify-between items-center">
    <div>
        <h3 class="text-lg font-bold text-[#0F1B4C]">All Journals</h3>
        <p class="text-sm text-gray-600">Total: {{ $journals->total() }} journals</p>
    </div>
    <a href="{{ route('admin.journals.create') }}" class="bg-[#0056FF] hover:bg-[#0044CC] text-white px-6 py-3 rounded-lg font-semibold transition-colors shadow-lg transform hover:scale-105">
        <i class="fas fa-plus mr-2"></i>Create New Journal
    </a>
</div>

<!-- Journals Table -->
<div class="bg-white rounded-xl border-2 border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-[#0F1B4C] text-white">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Name</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">ISSN</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Created</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($journals as $journal)
                    <tr class="hover:bg-[#F7F9FC] transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                @if($journal->logo)
                                    <img src="{{ asset('storage/' . $journal->logo) }}" 
                                         alt="{{ $journal->name }}" 
                                         class="w-10 h-10 object-contain bg-white p-1 rounded border border-gray-200">
                                @else
                                    <div class="w-10 h-10 bg-[#0056FF] rounded flex items-center justify-center">
                                        <i class="fas fa-book text-white"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="font-semibold text-[#0F1B4C]" style="font-family: 'Inter', sans-serif; font-weight: 600;">
                                        {{ $journal->name }}
                                    </div>
                                    @if($journal->slug)
                                        <div class="text-xs text-gray-500">/{{ $journal->slug }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $journal->issn ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $journal->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                {{ $journal->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $journal->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('journals.show', $journal->slug) }}" 
                                   target="_blank"
                                   class="text-[#0056FF] hover:text-[#0044CC] transition-colors" 
                                   title="View on Website">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.sections.index', $journal) }}" 
                                   class="text-purple-600 hover:text-purple-700 transition-colors" 
                                   title="Manage Sections">
                                    <i class="fas fa-folder-open"></i>
                                </a>
                                <a href="{{ route('admin.journals.edit', $journal) }}" 
                                   class="text-green-600 hover:text-green-700 transition-colors" 
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" 
                                      action="{{ route('admin.journals.destroy', $journal) }}" 
                                      class="inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this journal? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-700 transition-colors" 
                                            title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-book text-gray-400 text-5xl mb-4"></i>
                                <p class="text-gray-600 text-lg font-semibold mb-2">No journals found</p>
                                <p class="text-gray-500 text-sm mb-4">Get started by creating your first journal</p>
                                <a href="{{ route('admin.journals.create') }}" 
                                   class="bg-[#0056FF] hover:bg-[#0044CC] text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                                    <i class="fas fa-plus mr-2"></i>Create First Journal
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($journals->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $journals->links() }}
        </div>
    @endif
</div>
@endsection
