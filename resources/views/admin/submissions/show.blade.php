@extends('layouts.admin')

@section('title', 'Submission Details - CISA')
@section('page-title', 'Submission Details')
@section('page-subtitle', 'Review and manage submission workflow')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Main Content Column -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Submission Header Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <div class="flex flex-col gap-4">
                    <div class="flex items-start justify-between">
                        <span class="px-3 py-1 rounded-full text-xs font-bold border 
                            @if($submission->status == 'published') bg-emerald-50 text-emerald-600 border-emerald-100
                            @elseif($submission->status == 'submitted') bg-orange-50 text-orange-600 border-orange-100
                            @elseif($submission->status == 'under_review') bg-blue-50 text-blue-600 border-blue-100
                            @elseif($submission->status == 'accepted') bg-green-50 text-green-600 border-green-100
                            @elseif($submission->status == 'rejected') bg-red-50 text-red-600 border-red-100
                            @else bg-gray-50 text-gray-600 border-gray-100
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $submission->status)) }}
                        </span>
                        <span class="text-xs text-gray-400 font-mono">ID: #{{ $submission->id }}</span>
                    </div>

                    <h1 class="text-2xl md:text-3xl font-bold text-cisa-base font-serif leading-tight">
                        {{ $submission->title }}
                    </h1>

                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 border-t border-gray-100 pt-4 mt-2">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-cisa-base font-bold text-xs">
                                {{ substr($submission->author->first_name ?? 'A', 0, 1) }}
                            </div>
                            <span
                                class="font-medium text-cisa-base">{{ $submission->author->full_name ?? 'Unknown Author' }}</span>
                        </div>
                        <span class="text-gray-300">|</span>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-book-open text-cisa-accent"></i>
                            <span class="font-medium">{{ $submission->journal->name ?? 'N/A' }}</span>
                        </div>
                        <span class="text-gray-300">|</span>
                        <div class="flex items-center gap-2">
                            <i class="far fa-calendar text-gray-400"></i>
                            <span>{{ $submission->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Abstract -->
            @if($submission->abstract)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                    <h3 class="text-lg font-bold text-cisa-base mb-4 flex items-center gap-2">
                        <i class="fas fa-align-left text-cisa-accent"></i> Abstract
                    </h3>
                    <div class="prose prose-slate max-w-none text-gray-600 leading-relaxed">
                        {{ $submission->abstract }}
                    </div>
                    @if($submission->keywords)
                        <div class="mt-6 pt-4 border-t border-gray-100">
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Keywords</h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach(explode(',', $submission->keywords) as $keyword)
                                    <span class="px-3 py-1 bg-slate-50 text-cisa-base text-sm rounded-lg border border-gray-100">
                                        {{ trim($keyword) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Files -->
            @if($submission->files->count() > 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                    <h3 class="text-lg font-bold text-cisa-base mb-4 flex items-center gap-2">
                        <i class="fas fa-paperclip text-cisa-accent"></i> Submission Files
                    </h3>
                    <div class="space-y-3">
                        @foreach($submission->files as $file)
                            <div
                                class="flex items-center justify-between p-4 bg-slate-50 rounded-xl border border-gray-100 hover:border-cisa-accent/30 transition-colors group">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-lg bg-white border border-gray-200 flex items-center justify-center text-red-500 shadow-sm">
                                        <i class="fas fa-file-pdf text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-cisa-base text-sm mb-0.5">{{ $file->original_name }}</h4>
                                        <p class="text-xs text-gray-500">{{ ucfirst($file->file_type) }} • Version
                                            {{ $file->version }}</p>
                                    </div>
                                </div>
                                <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank"
                                    class="w-10 h-10 flex items-center justify-center rounded-lg bg-white border border-gray-200 text-gray-400 hover:text-cisa-accent hover:border-cisa-accent shadow-sm transition-all">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Activity Log -->
            @if($submission->logs->count() > 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                    <h3 class="text-lg font-bold text-cisa-base mb-6 flex items-center gap-2">
                        <i class="fas fa-history text-cisa-accent"></i> Activity Log
                    </h3>
                    <div class="relative pl-4 border-l-2 border-gray-100 space-y-8">
                        @foreach($submission->logs as $log)
                            <div class="relative">
                                <div
                                    class="absolute -left-[21px] top-1 w-3 h-3 rounded-full bg-gray-200 border-2 border-white ring-1 ring-gray-100">
                                </div>
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-1">
                                    <span
                                        class="font-bold text-cisa-base text-sm">{{ ucfirst(str_replace('_', ' ', $log->action)) }}</span>
                                    <span
                                        class="text-xs text-gray-400 font-mono">{{ $log->created_at->format('M d, Y H:i') }}</span>
                                </div>
                                <div class="text-sm text-gray-600 bg-slate-50 p-3 rounded-lg border border-gray-100">
                                    @if($log->user)
                                        <div class="flex items-center gap-2 mb-1 border-b border-gray-200/50 pb-1">
                                            <i class="fas fa-user-circle text-gray-400"></i>
                                            <span class="font-semibold text-xs text-gray-700">{{ $log->user->full_name }}</span>
                                        </div>
                                    @endif
                                    <p class="text-gray-600">{{ $log->message }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar / Actions Column -->
        <div class="space-y-6">
            <!-- Plagiarism Check Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-100 bg-slate-50 flex items-center justify-between">
                    <h3 class="font-bold text-cisa-base text-sm flex items-center gap-2">
                        <i class="fas fa-shield-alt text-cisa-accent"></i> Anti-Plagiarism
                    </h3>
                    @if($submission->plagiarismReport && $submission->plagiarismReport->status === 'completed')
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider {{ $submission->plagiarismReport->similarity_percentage > 30 ? 'bg-red-50 text-red-600' : ($submission->plagiarismReport->similarity_percentage > 15 ? 'bg-orange-50 text-orange-600' : 'bg-green-50 text-green-600') }}">
                            {{ $submission->plagiarismReport->similarity_percentage }}% Match
                        </span>
                    @endif
                </div>
                <div class="p-5">
                    @if(!$submission->plagiarismReport)
                        <div class="text-center py-4">
                            <i class="fas fa-search text-gray-200 text-3xl mb-3"></i>
                            <p class="text-xs text-gray-500 mb-4 px-4">Initial screening for internal similarity matches.</p>
                            <form action="{{ route('submissions.plagiarism.check', $submission) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full py-3 cisa-gradient text-white rounded-lg text-sm font-black uppercase tracking-widest shadow-lg shadow-cisa-base/20 hover:scale-[1.02] transition-all">
                                    Run Similarity Check
                                </button>
                            </form>
                        </div>
                    @elseif($submission->plagiarismReport->status === 'processing')
                        <div class="text-center py-4">
                            <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-cisa-accent border-t-transparent mb-3"></div>
                            <p class="text-xs text-gray-500">Processing manuscript...</p>
                        </div>
                    @elseif($submission->plagiarismReport->status === 'completed')
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg border border-gray-100">
                                <div>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Similarity Score</p>
                                    <p class="text-lg font-black text-cisa-base leading-none">{{ $submission->plagiarismReport->similarity_percentage }}%</p>
                                </div>
                                <a href="{{ route('submissions.plagiarism.report', $submission) }}" class="p-2 bg-white rounded-lg border border-gray-200 text-cisa-accent hover:border-cisa-accent transition-all shadow-sm">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            </div>
                            <form action="{{ route('submissions.plagiarism.check', $submission) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full py-2 text-gray-500 hover:text-cisa-base text-xs font-bold transition-colors">
                                    <i class="fas fa-sync-alt mr-1"></i> Re-run Check
                                </button>
                            </form>
                        </div>
                    @elseif($submission->plagiarismReport->status === 'failed')
                        <div class="p-3 bg-red-50 rounded-lg border border-red-100 mb-4">
                            <p class="text-[10px] text-red-600 font-bold uppercase mb-1">Check Failed</p>
                            <p class="text-xs text-red-500">{{ Str::limit($submission->plagiarismReport->error_message, 50) }}</p>
                        </div>
                        <form action="{{ route('submissions.plagiarism.check', $submission) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full py-2.5 bg-cisa-base text-white rounded-lg text-sm font-bold hover:bg-slate-800 transition-all">
                                Retry Check
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            <!-- Status & Workflow Actions -->
            @if($submission->status === 'submitted')
                <div class="bg-white rounded-xl shadow-lg border border-cisa-accent/20 overflow-hidden">
                    <div class="bg-gradient-to-r from-cisa-base to-slate-800 px-6 py-4 border-b border-gray-800">
                        <h3 class="text-white font-bold flex items-center gap-2">
                            <i class="fas fa-tasks text-cisa-accent"></i> Workflow Actions
                        </h3>
                    </div>

                    <div class="p-6 space-y-6">
                        @if(auth()->user()->role === 'admin')
                            <div class="bg-amber-50 border border-amber-100 rounded-lg p-4 flex gap-3 text-sm text-amber-800">
                                <i class="fas fa-lock mt-0.5"></i>
                                <p><strong>Site Administrator Access:</strong> Editorial decisions (Approve/Reject) should be made
                                    by Editors. However, you have override permissions below.</p>
                            </div>
                        @endif

                        <!-- Review Status Info -->
                        <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-lg border border-gray-100">
                            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                                <i class="fas fa-info text-xs"></i>
                            </div>
                            <div class="text-sm">
                                <span class="block font-bold text-gray-700">Review Policy</span>
                                @if($submission->journal->requires_review ?? true)
                                    <span class="text-gray-500 text-xs">Peer review required</span>
                                @else
                                    <span class="text-gray-500 text-xs text-emerald-600">Direct approval allowed</span>
                                @endif
                            </div>
                        </div>

                        <div class="space-y-3">
                            <!-- Direct Approval -->
                            <form method="POST" action="{{ route('admin.submissions.approve', $submission) }}" class="block"
                                onsubmit="return confirm('Skip review and approve directly?');">
                                @csrf
                                <input type="hidden" name="action" value="approve_direct">
                                <button type="submit"
                                    class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-bold shadow-sm transition-all text-sm group">
                                    <i class="fas fa-check-double group-hover:scale-110 transition-transform"></i>
                                    Approve Directly
                                </button>
                            </form>

                            <!-- Send to Review -->
                            <form method="POST" action="{{ route('admin.submissions.approve', $submission) }}" class="block">
                                @csrf
                                <input type="hidden" name="action" value="approve_review">
                                <button type="submit"
                                    class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-cisa-accent hover:bg-amber-600 text-white rounded-lg font-bold shadow-sm transition-all text-sm group">
                                    <i
                                        class="fas fa-paper-plane group-hover:-translate-y-0.5 group-hover:translate-x-0.5 transition-transform"></i>
                                    Send to Review
                                </button>
                            </form>

                            <!-- Reject -->
                            <div x-data="{ open: false }">
                                <button @click="open = !open" type="button"
                                    class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-white border border-red-200 text-red-600 hover:bg-red-50 rounded-lg font-bold transition-all text-sm">
                                    <i class="fas fa-times"></i> Reject Submission
                                </button>

                                <div x-show="open" class="mt-4 p-4 bg-red-50 rounded-xl border border-red-100" x-transition>
                                    <form method="POST" action="{{ route('admin.submissions.reject', $submission) }}"
                                        onsubmit="return confirm('Confirm rejection?');">
                                        @csrf
                                        <label class="block text-xs font-bold text-red-800 mb-2">Rejection Reason</label>
                                        <textarea name="reason" rows="3" required
                                            class="w-full px-3 py-2 bg-white border border-red-200 rounded-lg text-sm text-gray-700 focus:outline-none focus:border-red-400 mb-3"
                                            placeholder="Reason for rejection..."></textarea>
                                        <button type="submit"
                                            class="w-full py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs font-bold shadow-sm">
                                            Confirm Rejection
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @endif

            <!-- Authors Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">
                    Author Details
                </h3>
                <div class="space-y-4">
                    @foreach($submission->authors as $author)
                        <div class="flex items-start gap-3">
                            <div
                                class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-gray-500 text-xs">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-bold text-cisa-base text-sm">{{ $author->full_name }}</p>
                                <p class="text-xs text-gray-500 break-all">{{ $author->email }}</p>
                                @if($author->is_corresponding)
                                    <span
                                        class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-blue-50 text-blue-600 mt-1">
                                        Corresponding
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection