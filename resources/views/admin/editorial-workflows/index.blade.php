@extends('layouts.admin')

@section('title', 'Editorial Workflows - EMANP')
@section('page-title', 'Editorial Workflows')
@section('page-subtitle', 'Manage manuscript statuses and review processes')

@section('content')
<!-- Workflow Stats -->
<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
    <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
        <div class="text-2xl font-bold text-orange-600">{{ $workflowStats['submitted'] }}</div>
        <div class="text-xs text-gray-600">Submitted</div>
    </div>
    <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
        <div class="text-2xl font-bold text-blue-600">{{ $workflowStats['under_review'] }}</div>
        <div class="text-xs text-gray-600">Under Review</div>
    </div>
    <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
        <div class="text-2xl font-bold text-yellow-600">{{ $workflowStats['revision_required'] }}</div>
        <div class="text-xs text-gray-600">Revisions</div>
    </div>
    <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
        <div class="text-2xl font-bold text-green-600">{{ $workflowStats['accepted'] }}</div>
        <div class="text-xs text-gray-600">Accepted</div>
    </div>
    <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
        <div class="text-2xl font-bold text-red-600">{{ $workflowStats['rejected'] }}</div>
        <div class="text-xs text-gray-600">Rejected</div>
    </div>
</div>

<div class="bg-white rounded-xl border-2 border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-[#0F1B4C] text-white">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Title</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Author</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Journal</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Assigned Editor</th>
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
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $submission->assignedEditor->full_name ?? 'Unassigned' }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('editor.submissions.show', [$submission->journal, $submission]) }}" class="text-[#0056FF] hover:text-[#0044CC] transition-colors mr-3" title="View Details">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if(in_array($submission->status, ['submitted', 'under_review']))
                                <a href="{{ route('editor.submissions.show', [$submission->journal, $submission]) }}#assign-reviewer" class="text-[#0056FF] hover:text-[#0044CC] transition-colors" title="Assign Reviewer">
                                    <i class="fas fa-user-plus"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-tasks text-4xl mb-3"></i>
                            <p>No submissions in workflow</p>
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

