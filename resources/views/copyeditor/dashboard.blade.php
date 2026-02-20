@extends('layouts.app')

@section('title', 'Copyeditor Dashboard - EMANP')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-[#0F1B4C]">
                        <i class="fas fa-edit mr-3 text-[#0056FF]"></i>Copyeditor Dashboard
                    </h1>
                    <p class="text-gray-600 mt-2">Manage copyediting tasks for assigned submissions</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Welcome back,</p>
                    <p class="text-lg font-semibold text-[#0F1B4C]">{{ auth()->user()->full_name }}</p>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-semibold">Pending Tasks</p>
                        <p class="text-3xl font-bold mt-2">{{ $pendingCount ?? 0 }}</p>
                    </div>
                    <i class="fas fa-clock text-4xl opacity-50"></i>
                </div>
            </div>
            
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-semibold">In Progress</p>
                        <p class="text-3xl font-bold mt-2">{{ $inProgressCount ?? 0 }}</p>
                    </div>
                    <i class="fas fa-spinner text-4xl opacity-50"></i>
                </div>
            </div>
            
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-semibold">Completed</p>
                        <p class="text-3xl font-bold mt-2">{{ $completedCount ?? 0 }}</p>
                    </div>
                    <i class="fas fa-check-circle text-4xl opacity-50"></i>
                </div>
            </div>
            
            <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm font-semibold">Total Assigned</p>
                        <p class="text-3xl font-bold mt-2">{{ $totalCount ?? 0 }}</p>
                    </div>
                    <i class="fas fa-file-alt text-4xl opacity-50"></i>
                </div>
            </div>
        </div>

        <!-- Submissions Table -->
        <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-[#0F1B4C]">
                    <i class="fas fa-list mr-2 text-[#0056FF]"></i>Assigned Submissions
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-[#0056FF] to-[#1D72B8]">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Title</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Journal</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Author</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Due Date</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-white uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($submissions ?? [] as $submission)
                        <tr class="hover:bg-blue-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-gray-900">{{ $submission->title }}</div>
                                <div class="text-xs text-gray-500">ID: {{ $submission->id }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $submission->journal->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $submission->author->full_name }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $submission->current_stage === 'copyediting' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($submission->current_stage) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $submission->copyediting_due_date ? $submission->copyediting_due_date->format('M d, Y') : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-medium">
                                <a href="{{ route('copyeditor.submissions.show', $submission) }}" 
                                   class="text-[#0056FF] hover:text-[#0044CC] font-semibold">
                                    <i class="fas fa-eye mr-1"></i>View
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                                <p class="text-gray-500 text-lg font-semibold">No submissions assigned</p>
                                <p class="text-gray-400">You'll see copyediting tasks here when assigned</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

