@extends('layouts.app')

@section('title', $journal->name . ' - Submissions Management')

@section('content')
    <div class="min-h-screen bg-slate-50 pb-12">
        <!-- Hero Section -->
        <div class="bg-cisa-base text-white py-12 mb-8 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 right-0 w-64 h-64 bg-cisa-accent rounded-full -mr-32 -mt-32 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-600 rounded-full -ml-48 -mb-48 blur-3xl"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <h1
                            class="text-3xl md:text-4xl font-black font-serif mb-2 tracking-tight text-white flex items-center gap-3">
                            <i class="fas fa-tasks text-cisa-accent"></i>
                            Submissions Management
                        </h1>
                        <p class="text-slate-400 font-medium text-lg leading-relaxed max-w-2xl">
                            {{ $journal->name }} — Editor Control Center
                        </p>
                    </div>
                    <div>
                        <a href="{{ route('editor.dashboard', $journal->slug) }}"
                            class="px-6 py-3 bg-white/10 hover:bg-white/20 border border-white/20 rounded-xl font-bold text-white transition-all flex items-center gap-2 backdrop-blur-sm">
                            <i class="fas fa-chevron-left text-cisa-accent"></i>
                            Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Stats Grid (Optional but adds value) -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-black text-slate-400 uppercase tracking-widest">Total Active</span>
                        <i class="fas fa-file-alt text-cisa-base opacity-20"></i>
                    </div>
                    <div class="text-3xl font-black text-slate-900">{{ $submissions->total() }}</div>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-black text-slate-400 uppercase tracking-widest">In Review</span>
                        <i class="fas fa-search text-amber-500 opacity-20"></i>
                    </div>
                    <div class="text-3xl font-black text-slate-900">
                        {{ $submissions->where('status', 'in_review')->count() }}
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-black text-slate-400 uppercase tracking-widest">Pending</span>
                        <i class="fas fa-clock text-blue-500 opacity-20"></i>
                    </div>
                    <div class="text-3xl font-black text-slate-900">
                        {{ $submissions->where('status', 'submitted')->count() }}
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-black text-slate-400 uppercase tracking-widest">Published</span>
                        <i class="fas fa-check-double text-green-500 opacity-20"></i>
                    </div>
                    <div class="text-3xl font-black text-slate-900">
                        {{ $submissions->where('status', 'published')->count() }}
                    </div>
                </div>
            </div>

            <!-- Main Table Container -->
            <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="px-6 py-5 text-xs font-black text-slate-400 uppercase tracking-widest">Manuscript
                                    Details</th>
                                <th
                                    class="px-6 py-5 text-xs font-black text-slate-400 uppercase tracking-widest text-center">
                                    Status / Stage</th>
                                <th class="px-6 py-5 text-xs font-black text-slate-400 uppercase tracking-widest">Assignee
                                </th>
                                <th class="px-6 py-5 text-xs font-black text-slate-400 uppercase tracking-widest">Submitted
                                </th>
                                <th
                                    class="px-6 py-5 text-xs font-black text-slate-400 uppercase tracking-widest text-right">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($submissions as $submission)
                                <tr class="hover:bg-slate-50/80 transition-colors group">
                                    <td class="px-6 py-6">
                                        <div class="max-w-md">
                                            <h4
                                                class="font-bold text-slate-900 mb-1 line-clamp-2 leading-snug group-hover:text-cisa-base transition-colors">
                                                {{ $submission->title }}
                                            </h4>
                                            <div class="flex items-center gap-3">
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded bg-slate-100 text-[10px] font-black text-slate-500 uppercase">
                                                    ID: #{{ $submission->id }}
                                                </span>
                                                <span class="text-xs text-slate-400 font-medium">
                                                    By {{ $submission->author->full_name }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6 text-center">
                                        <div class="flex flex-col items-center gap-2">
                                            @php
                                                $statusClasses = [
                                                    'submitted' => 'bg-blue-50 text-blue-700 border-blue-100',
                                                    'in_review' => 'bg-amber-50 text-amber-700 border-amber-100',
                                                    'revision_requested' => 'bg-purple-50 text-purple-700 border-purple-100',
                                                    'published' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                                    'rejected' => 'bg-rose-50 text-rose-700 border-rose-100',
                                                    'desk_rejected' => 'bg-slate-100 text-slate-700 border-slate-200',
                                                ];
                                                $stageClasses = [
                                                    'submission' => 'bg-slate-100 text-slate-600',
                                                    'review' => 'bg-blue-100 text-blue-600',
                                                    'copyediting' => 'bg-indigo-100 text-indigo-600',
                                                    'production' => 'bg-emerald-100 text-emerald-600',
                                                ];
                                            @endphp
                                            <span
                                                class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $statusClasses[$submission->status] ?? 'bg-slate-50 text-slate-600 border-slate-100' }}">
                                                {{ str_replace('_', ' ', $submission->status) }}
                                            </span>
                                            <span
                                                class="px-2 py-0.5 rounded text-[9px] font-bold uppercase {{ $stageClasses[$submission->current_stage] ?? 'bg-slate-50 text-slate-400' }}">
                                                {{ $submission->current_stage }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400">
                                                <i class="fas fa-user-edit text-xs"></i>
                                            </div>
                                            <div class="text-sm font-bold text-slate-700">
                                                {{ $submission->assignedEditor ? $submission->assignedEditor->full_name : 'Unassigned' }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6 whitespace-nowrap">
                                        <div class="text-sm font-bold text-slate-900">
                                            {{ $submission->formatted_submitted_at ?? 'N/A' }}
                                        </div>
                                        <div class="text-[10px] text-slate-400 font-medium uppercase">
                                            {{ $submission->submitted_at && is_object($submission->submitted_at) ? $submission->submitted_at->diffForHumans() : '' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-6 text-right">
                                        <a href="{{ route('editor.submissions.show', [$journal->slug, $submission->id]) }}"
                                            class="inline-flex items-center justify-center px-5 py-2.5 bg-cisa-base hover:bg-cisa-accent text-white rounded-xl text-xs font-black uppercase tracking-widest transition-all shadow-lg shadow-cisa-base/10 hover:-translate-y-0.5">
                                            Manage
                                            <i class="fas fa-chevron-right ml-2 text-[10px]"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-24 text-center">
                                        <div class="max-w-xs mx-auto">
                                            <div
                                                class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-300 mx-auto mb-4">
                                                <i class="fas fa-inbox text-2xl"></i>
                                            </div>
                                            <h3 class="text-lg font-bold text-slate-900 mb-1">No Submissions</h3>
                                            <p class="text-slate-500 text-sm">There are currently no articles in the queue for
                                                this journal.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($submissions->hasPages())
                    <div class="px-6 py-6 bg-slate-50 border-t border-slate-100">
                        {{ $submissions->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection