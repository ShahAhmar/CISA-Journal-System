@extends('layouts.admin')

@section('title', 'Manage Submissions - CISA')
@section('page-title', 'Recent Submissions')
@section('page-subtitle', 'Track and manage article submissions across all journals')

@section('content')
    <!-- Stats Overview -->
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4 mb-8">
        <a href="{{ route('admin.submissions.index', ['status' => 'all']) }}"
            class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:shadow-md hover:border-cisa-accent/30 transition-all group">
            <div class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Total</div>
            <div class="text-2xl font-bold text-cisa-base group-hover:text-cisa-accent transition-colors">
                {{ $stats['total'] }}</div>
        </a>
        <a href="{{ route('admin.submissions.index', ['status' => 'submitted']) }}"
            class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:shadow-md hover:border-orange-200 transition-all group">
            <div class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Pending</div>
            <div class="text-2xl font-bold text-orange-600 group-hover:scale-105 transition-transform origin-left">
                {{ $stats['submitted'] }}</div>
        </a>
        <a href="{{ route('admin.submissions.index', ['status' => 'under_review']) }}"
            class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:shadow-md hover:border-blue-200 transition-all group">
            <div class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Reviewing</div>
            <div class="text-2xl font-bold text-blue-600 group-hover:scale-105 transition-transform origin-left">
                {{ $stats['under_review'] }}</div>
        </a>
        <a href="{{ route('admin.submissions.index', ['status' => 'revision_required']) }}"
            class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:shadow-md hover:border-amber-200 transition-all group">
            <div class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Revisions</div>
            <div class="text-2xl font-bold text-amber-500 group-hover:scale-105 transition-transform origin-left">
                {{ $stats['revision_required'] }}</div>
        </a>
        <a href="{{ route('admin.submissions.index', ['status' => 'accepted']) }}"
            class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:shadow-md hover:border-green-200 transition-all group">
            <div class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Accepted</div>
            <div class="text-2xl font-bold text-green-600 group-hover:scale-105 transition-transform origin-left">
                {{ $stats['accepted'] }}</div>
        </a>
        <a href="{{ route('admin.submissions.index', ['status' => 'published']) }}"
            class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all group">
            <div class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Published</div>
            <div class="text-2xl font-bold text-emerald-600 group-hover:scale-105 transition-transform origin-left">
                {{ $stats['published'] }}</div>
        </a>
        <a href="{{ route('admin.submissions.index', ['status' => 'rejected']) }}"
            class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:shadow-md hover:border-red-200 transition-all group">
            <div class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Rejected</div>
            <div class="text-2xl font-bold text-red-500 group-hover:scale-105 transition-transform origin-left">
                {{ $stats['rejected'] }}</div>
        </a>
        <a href="{{ route('admin.submissions.index', ['status' => 'disabled']) }}"
            class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:shadow-md hover:border-gray-300 transition-all group">
            <div class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Disabled</div>
            <div class="text-2xl font-bold text-gray-500 group-hover:scale-105 transition-transform origin-left">
                {{ $stats['disabled'] ?? 0 }}</div>
        </a>
    </div>

    <!-- Filters & Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
        <form method="GET" action="{{ route('admin.submissions.index') }}"
            class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
            <div class="md:col-span-2">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-300"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-gray-100 focus:bg-white focus:border-cisa-accent/50 focus:ring-2 focus:ring-cisa-accent/10 rounded-lg transition-all"
                        placeholder="Search by title, author, or ID...">
                </div>
            </div>

            <div>
                <select name="journal_id"
                    class="w-full px-4 py-2.5 bg-slate-50 border border-gray-100 focus:bg-white focus:border-cisa-accent/50 focus:ring-2 focus:ring-cisa-accent/10 rounded-lg transition-all text-sm">
                    <option value="">All Journals</option>
                    @foreach($journals as $journal)
                        <option value="{{ $journal->id }}" {{ request('journal_id') == $journal->id ? 'selected' : '' }}>
                            {{ $journal->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <button type="submit"
                    class="w-full bg-cisa-base hover:bg-slate-800 text-white font-bold py-2.5 rounded-lg shadow-md hover:shadow-lg transition-all text-sm">
                    <i class="fas fa-filter mr-2 text-cisa-accent"></i>Apply Filters
                </button>
            </div>
        </form>
    </div>

    <!-- Submissions List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full leading-normal">
                <thead>
                    <tr class="bg-slate-50 border-b border-gray-100 text-left">
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider w-1/3">Submission
                            Details</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Journal</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Action
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($submissions as $submission)
                        <tr
                            class="hover:bg-slate-50 transition-colors group {{ $submission->status === 'disabled' ? 'opacity-60 bg-gray-50' : '' }}">
                            <td class="px-6 py-4">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0 mt-1">
                                        <span
                                            class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs">
                                            {{ substr($submission->author->first_name ?? 'A', 0, 1) }}
                                        </span>
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.submissions.show', $submission) }}"
                                            class="font-bold text-cisa-base group-hover:text-cisa-accent transition-colors line-clamp-1 mb-1">
                                            {{ $submission->title }}
                                        </a>
                                        <div class="flex items-center gap-2 text-xs text-gray-500">
                                            <span
                                                class="font-medium text-gray-700">{{ $submission->author->full_name ?? 'Unknown Author' }}</span>
                                            <span class="text-gray-300">&bull;</span>
                                            <span class="font-mono">ID: {{ $submission->id }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-700">{{ $submission->journal->name ?? 'N/A' }}</div>
                                <div class="text-xs text-gray-400 font-mono">{{ $submission->journal->journal_initials ?? '' }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColors = [
                                        'submitted' => 'bg-orange-50 text-orange-600 border-orange-100',
                                        'under_review' => 'bg-blue-50 text-blue-600 border-blue-100',
                                        'revision_required' => 'bg-amber-50 text-amber-600 border-amber-100',
                                        'accepted' => 'bg-green-50 text-green-600 border-green-100',
                                        'published' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                        'rejected' => 'bg-red-50 text-red-600 border-red-100',
                                        'disabled' => 'bg-gray-100 text-gray-500 border-gray-200'
                                    ];
                                    $statusClass = $statusColors[$submission->status] ?? 'bg-gray-50 text-gray-600';
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold border {{ $statusClass }}">
                                    {{ ucfirst(str_replace('_', ' ', $submission->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-600 font-medium">{{ $submission->created_at->format('M d, Y') }}
                                </div>
                                <div class="text-xs text-gray-400">{{ $submission->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div
                                    class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.submissions.show', $submission) }}"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-cisa-accent hover:bg-amber-50 transition-all"
                                        title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    @if($submission->status === 'disabled')
                                        <form action="{{ route('admin.submissions.enable', $submission) }}" method="POST"
                                            class="inline" onsubmit="return confirm('Enable submission?');">
                                            @csrf
                                            <button type="submit"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-green-600 hover:bg-green-50 transition-all"
                                                title="Enable">
                                                <i class="fas fa-check-circle"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.submissions.disable', $submission) }}" method="POST"
                                            class="inline" onsubmit="return confirm('Disable submission?');">
                                            @csrf
                                            <button type="submit"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-amber-600 hover:bg-amber-50 transition-all"
                                                title="Disable">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('admin.submissions.destroy', $submission) }}" method="POST"
                                        class="inline" onsubmit="return confirm('Process permanent deletion?');">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-all"
                                            title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div
                                    class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                                    <i class="fas fa-inbox text-3xl"></i>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-1">No submissions found</h3>
                                <p class="text-gray-500 text-sm">Use the filters or wait for new author submissions.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($submissions->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-slate-50">
                {{ $submissions->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
@endsection