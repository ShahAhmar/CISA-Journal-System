@extends('layouts.admin')

@section('title', 'Issues & Volumes - EMANP')
@section('page-title', 'Issues & Volumes')
@section('page-subtitle', 'Manage journal issues and volumes')

@section('content')
<div class="bg-white rounded-xl border-2 border-gray-200 p-6 mb-6 flex justify-between items-center">
    <div>
        <h3 class="text-lg font-bold text-[#0F1B4C]">All Issues</h3>
        <p class="text-sm text-gray-600">Create and manage journal issues</p>
    </div>
    <a href="{{ route('admin.issues.create') }}" class="bg-[#0056FF] hover:bg-[#0044CC] text-white px-6 py-3 rounded-lg font-semibold transition-colors">
        <i class="fas fa-plus mr-2"></i>Create New Issue
    </a>
</div>

<div class="bg-white rounded-xl border-2 border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-[#0F1B4C] text-white">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Journal</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Volume</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Issue</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Year</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Title</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($issues as $issue)
                    <tr class="hover:bg-[#F7F9FC] transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $issue->journal->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm font-semibold text-[#0F1B4C]">{{ $issue->volume }}</td>
                        <td class="px-6 py-4 text-sm font-semibold text-[#0F1B4C]">{{ $issue->issue_number }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $issue->year }}</td>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-[#0F1B4C]">{{ $issue->display_title }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $issue->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                {{ $issue->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.issues.edit', $issue) }}" class="text-[#0056FF] hover:text-[#0044CC] transition-colors">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-bookmark text-4xl mb-3"></i>
                            <p>No issues found</p>
                            <a href="{{ route('admin.issues.create') }}" class="text-[#0056FF] hover:text-[#0044CC] text-sm font-semibold mt-2 inline-block">
                                Create First Issue
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($issues->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $issues->links() }}
        </div>
    @endif
</div>
@endsection

