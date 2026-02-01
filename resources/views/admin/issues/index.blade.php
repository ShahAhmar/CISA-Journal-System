@extends('layouts.admin')

@section('title', 'Issues & Volumes - CISA')
@section('page-title', 'Issues & Volumes')
@section('page-subtitle', 'Manage journal issues, volumes, and publication status')

@section('content')
    <!-- Actions & Search -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div class="relative max-w-md w-full">
            <i class="fas fa-search absolute left-3 top-3 text-gray-300"></i>
            <input type="text"
                class="block w-full pl-10 pr-3 py-2.5 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-cisa-accent/50 focus:border-cisa-accent text-sm placeholder-gray-400 transition-all shadow-sm"
                placeholder="Search issues by title, volume, or journal...">
        </div>

        <a href="{{ route('admin.issues.create') }}"
            class="inline-flex items-center justify-center px-4 py-2.5 bg-cisa-accent hover:bg-amber-600 text-white font-bold rounded-lg shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all text-sm group">
            <i class="fas fa-plus mr-2 group-hover:rotate-90 transition-transform"></i>
            <span>Create New Issue</span>
        </a>
    </div>

    <!-- Issues Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 border-b border-gray-100">
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Issue Details</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Journal</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Volume/Issue</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Items</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($issues as $issue)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-start gap-3">
                                    <div
                                        class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-sm shadow-sm border border-indigo-100">
                                        {{ $issue->year }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-cisa-base text-sm">
                                            {{ $issue->display_title ?: 'Vol ' . $issue->volume . ', No ' . $issue->issue_number }}
                                        </div>
                                        @if($issue->title)
                                            <div class="text-xs text-gray-500 italic">{{ $issue->title }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium text-gray-700">{{ $issue->journal->name ?? 'N/A' }}</span>
                                <div class="text-[10px] text-gray-400 font-mono mt-0.5">
                                    {{ $issue->journal->journal_initials ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="px-2 py-1 bg-slate-100 rounded text-xs font-mono font-semibold text-slate-600">Vol
                                        {{ $issue->volume }}</span>
                                    <span class="text-gray-300">/</span>
                                    <span
                                        class="px-2 py-1 bg-slate-100 rounded text-xs font-mono font-semibold text-slate-600">No
                                        {{ $issue->issue_number }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($issue->is_published)
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Published
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-600 border border-amber-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Draft
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1 text-xs text-gray-500">
                                    <i class="fas fa-file-alt"></i>
                                    <span>{{ $issue->articles_count ?? 0 }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div
                                    class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    @if(!$issue->is_published)
                                        <form action="{{ route('admin.issues.publish', $issue) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Publish this issue?');">
                                            @csrf
                                            <button type="submit"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 transition-all font-bold"
                                                title="Publish Issue">
                                                <i class="fas fa-upload"></i>
                                            </button>
                                        </form>
                                    @endif

                                    <a href="{{ route('admin.issues.edit', $issue) }}"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-cisa-accent hover:bg-amber-50 transition-all font-bold"
                                        title="Edit Issue">
                                        <i class="fas fa-pen"></i>
                                    </a>

                                    <form action="{{ route('admin.issues.destroy', $issue) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Delete this issue? Items will be unassigned.');">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-all"
                                            title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div
                                    class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                                    <i class="fas fa-layer-group text-3xl"></i>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-1">No issues created</h3>
                                <p class="text-gray-500 text-sm mb-4">Create your first issue to categorize articles.</p>
                                <a href="{{ route('admin.issues.create') }}"
                                    class="text-cisa-accent hover:underline font-bold text-sm">Create Issue &rarr;</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($issues->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-slate-50">
                {{ $issues->links() }}
            </div>
        @endif
    </div>
@endsection