@extends('layouts.admin')

@section('title', 'Manage Journals - CISA')
@section('page-title', 'Manage Journals')
@section('page-subtitle', 'Create, edit, and organize your academic journals')

@section('content')
    <!-- Header Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div class="relative max-w-md w-full">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
            <input type="text"
                class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-cisa-accent/50 focus:border-cisa-accent bg-white text-sm placeholder-gray-400 transition-all"
                placeholder="Search journals by name or ISSN...">
        </div>

        <a href="{{ route('admin.journals.create') }}"
            class="inline-flex items-center justify-center px-4 py-2.5 bg-cisa-accent hover:bg-amber-600 text-white font-bold rounded-lg shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all text-sm group">
            <i class="fas fa-plus mr-2 group-hover:rotate-90 transition-transform"></i>
            <span>Create New Journal</span>
        </a>
    </div>

    <!-- Journals Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50 border-b border-gray-100 text-left">
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Journal Details</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">ISSN</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Stats</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($journals as $journal)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0">
                                        @if($journal->logo)
                                            <img src="{{ asset('storage/' . $journal->logo) }}" alt="{{ $journal->name }}"
                                                class="w-12 h-12 object-contain bg-white p-1 rounded-lg border border-gray-200 shadow-sm">
                                        @else
                                            <div
                                                class="w-12 h-12 bg-cisa-base text-white rounded-lg flex items-center justify-center shadow-sm">
                                                <span
                                                    class="font-serif font-bold text-lg">{{ substr(strip_tags($journal->name), 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h4
                                            class="font-bold text-cisa-base text-sm mb-1 group-hover:text-cisa-accent transition-colors">
                                            {{ strip_tags($journal->name) }}
                                        </h4>
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="text-xs text-gray-400 font-mono bg-gray-100 px-1.5 py-0.5 rounded">/{{ $journal->slug }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm font-mono text-gray-600">
                                {{ $journal->issn ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $journal->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                    <span
                                        class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $journal->is_active ? 'bg-green-500' : 'bg-gray-500' }}"></span>
                                    {{ $journal->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4 text-xs text-gray-500">
                                    <div class="flex items-center gap-1" title="Issues">
                                        <i class="fas fa-layer-group text-gray-300"></i>
                                        <span class="font-bold text-gray-700">{{ $journal->issues_count ?? 0 }}</span>
                                    </div>
                                    <div class="flex items-center gap-1" title="Articles">
                                        <i class="fas fa-file-alt text-gray-300"></i>
                                        <span class="font-bold text-gray-700">{{ $journal->submissions_count ?? 0 }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div
                                    class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('journals.show', $journal->slug) }}" target="_blank"
                                        class="p-2 text-gray-400 hover:text-cisa-accent hover:bg-orange-50 rounded"
                                        title="View Live">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                    <a href="{{ route('admin.sections.index', $journal) }}"
                                        class="p-2 text-gray-400 hover:text-purple-600 hover:bg-purple-50 rounded"
                                        title="Manage Sections">
                                        <i class="fas fa-folder-tree"></i>
                                    </a>
                                    <a href="{{ route('admin.journals.edit', $journal) }}"
                                        class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded"
                                        title="Edit Details">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.journals.destroy', $journal) }}" class="inline"
                                        onsubmit="return confirm('Delete this journal? This works will be lost.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div
                                    class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                                    <i class="fas fa-book-open text-3xl"></i>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-1">No journals found</h3>
                                <p class="text-gray-500 text-sm mb-4">Start by creating your first academic journal.</p>
                                <a href="{{ route('admin.journals.create') }}"
                                    class="text-cisa-accent hover:text-amber-600 font-bold text-sm inline-flex items-center">
                                    <i class="fas fa-plus mr-2"></i>Create Journal
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($journals->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-slate-50">
                {{ $journals->links() }}
            </div>
        @endif
    </div>
@endsection