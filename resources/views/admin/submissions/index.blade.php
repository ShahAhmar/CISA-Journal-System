@extends('layouts.admin')

@section('title', 'Articles / Submissions - EMANP')
@section('page-title', 'Articles / Submissions')
@section('page-subtitle', 'Manage all article submissions')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4 mb-6">
    <a href="{{ route('admin.submissions.index', ['status' => 'all']) }}" class="bg-white rounded-lg p-4 border-2 border-gray-200 hover:border-[#0056FF] transition-colors">
        <div class="text-2xl font-bold text-[#0F1B4C]">{{ $stats['total'] }}</div>
        <div class="text-xs text-gray-600">Total</div>
    </a>
    <a href="{{ route('admin.submissions.index', ['status' => 'submitted']) }}" class="bg-white rounded-lg p-4 border-2 border-gray-200 hover:border-orange-500 transition-colors">
        <div class="text-2xl font-bold text-orange-600">{{ $stats['submitted'] }}</div>
        <div class="text-xs text-gray-600">Submitted</div>
    </a>
    <a href="{{ route('admin.submissions.index', ['status' => 'under_review']) }}" class="bg-white rounded-lg p-4 border-2 border-gray-200 hover:border-blue-500 transition-colors">
        <div class="text-2xl font-bold text-blue-600">{{ $stats['under_review'] }}</div>
        <div class="text-xs text-gray-600">Under Review</div>
    </a>
    <a href="{{ route('admin.submissions.index', ['status' => 'revision_required']) }}" class="bg-white rounded-lg p-4 border-2 border-gray-200 hover:border-yellow-500 transition-colors">
        <div class="text-2xl font-bold text-yellow-600">{{ $stats['revision_required'] }}</div>
        <div class="text-xs text-gray-600">Revisions</div>
    </a>
    <a href="{{ route('admin.submissions.index', ['status' => 'accepted']) }}" class="bg-white rounded-lg p-4 border-2 border-gray-200 hover:border-green-500 transition-colors">
        <div class="text-2xl font-bold text-green-600">{{ $stats['accepted'] }}</div>
        <div class="text-xs text-gray-600">Accepted</div>
    </a>
    <a href="{{ route('admin.submissions.index', ['status' => 'published']) }}" class="bg-white rounded-lg p-4 border-2 border-gray-200 hover:border-green-600 transition-colors">
        <div class="text-2xl font-bold text-green-700">{{ $stats['published'] }}</div>
        <div class="text-xs text-gray-600">Published</div>
    </a>
    <a href="{{ route('admin.submissions.index', ['status' => 'rejected']) }}" class="bg-white rounded-lg p-4 border-2 border-gray-200 hover:border-red-500 transition-colors">
        <div class="text-2xl font-bold text-red-600">{{ $stats['rejected'] }}</div>
        <div class="text-xs text-gray-600">Rejected</div>
    </a>
</div>

<!-- Filters -->
<div class="bg-white rounded-xl border-2 border-gray-200 p-6 mb-6">
    <form method="GET" action="{{ route('admin.submissions.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
            <select name="status" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Statuses</option>
                <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Submitted</option>
                <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>Under Review</option>
                <option value="revision_required" {{ request('status') == 'revision_required' ? 'selected' : '' }}>Revision Required</option>
                <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Journal</label>
            <select name="journal_id" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                <option value="">All Journals</option>
                @foreach($journals as $journal)
                    <option value="{{ $journal->id }}" {{ request('journal_id') == $journal->id ? 'selected' : '' }}>{{ $journal->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-end">
            <button type="submit" class="w-full bg-[#0056FF] hover:bg-[#0044CC] text-white px-6 py-2 rounded-lg font-semibold transition-colors">
                <i class="fas fa-filter mr-2"></i>Filter
            </button>
        </div>
    </form>
</div>

<!-- Submissions Table -->
<div class="bg-white rounded-xl border-2 border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-[#0F1B4C] text-white">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Title</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Author</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Journal</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Submitted</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($submissions as $submission)
                    <tr class="hover:bg-[#F7F9FC] transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-[#0F1B4C]">{{ Str::limit($submission->title, 50) }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $submission->author->full_name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $submission->journal->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold 
                                @if($submission->status == 'published') bg-green-100 text-green-700
                                @elseif($submission->status == 'submitted') bg-orange-100 text-orange-700
                                @elseif($submission->status == 'under_review') bg-blue-100 text-blue-700
                                @elseif($submission->status == 'accepted') bg-green-100 text-green-700
                                @elseif($submission->status == 'rejected') bg-red-100 text-red-700
                                @else bg-gray-100 text-gray-700
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $submission->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $submission->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.submissions.show', $submission) }}" class="text-[#0056FF] hover:text-[#0044CC] transition-colors">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-file-alt text-4xl mb-3"></i>
                            <p>No submissions found</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($submissions->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $submissions->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection

