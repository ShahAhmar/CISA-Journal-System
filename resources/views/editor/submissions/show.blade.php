@extends('layouts.app')

@section('title', $submission->title)

@section('content')
    <div class="min-h-screen bg-slate-50 pb-12">
        <!-- Hero Section -->
        <div class="bg-cisa-base text-white py-12 mb-8 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 right-0 w-64 h-64 bg-cisa-accent rounded-full -mr-32 -mt-32 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-600 rounded-full -ml-48 -mb-48 blur-3xl"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="mb-6">
                    <a href="{{ route('editor.submissions.index', $journal) }}"
                        class="inline-flex items-center text-slate-400 hover:text-cisa-accent transition-colors font-bold text-sm">
                        <i class="fas fa-chevron-left mr-2"></i>
                        Back to Submissions
                    </a>
                </div>

                <div class="flex flex-col md:flex-row md:items-start justify-between gap-6">
                    <div class="max-w-4xl">
                        <div class="flex items-center gap-3 mb-3">
                            <span
                                class="px-3 py-1 bg-cisa-accent/10 border border-cisa-accent/20 text-cisa-accent text-[10px] font-black uppercase tracking-widest rounded">
                                Article ID: #{{ $submission->id }}
                            </span>
                            <span
                                class="px-3 py-1 bg-blue-500/10 border border-blue-500/20 text-blue-400 text-[10px] font-black uppercase tracking-widest rounded">
                                {{ strip_tags($submission->journal->journal_initials) }}
                            </span>
                        </div>
                        <h1 class="text-3xl md:text-5xl font-black font-serif mb-4 leading-tight tracking-tight">
                            {{ $submission->title }}
                        </h1>
                        <p class="text-slate-400 font-medium text-lg italic">
                            By {{ $submission->author->full_name }}
                        </p>
                    </div>
                    <div class="flex flex-col items-end gap-3">
                        <div class="flex gap-2">
                            @php
                                $statusMap = [
                                    'submitted' => 'bg-blue-500/20 text-blue-400 border-blue-500/30',
                                    'in_review' => 'bg-amber-500/20 text-amber-400 border-amber-500/30',
                                    'published' => 'bg-emerald-500/20 text-emerald-400 border-emerald-500/30',
                                    'rejected' => 'bg-rose-500/20 text-rose-400 border-rose-500/30',
                                ];
                            @endphp
                            <span
                                class="px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest border {{ $statusMap[$submission->status] ?? 'bg-slate-500/20 text-slate-400 border-slate-500/30' }}">
                                {{ str_replace('_', ' ', $submission->status) }}
                            </span>
                            <span
                                class="px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest border bg-indigo-500/20 text-indigo-400 border-indigo-500/30">
                                {{ str_replace('_', ' ', $submission->current_stage) }}
                            </span>
                        </div>
                        <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">
                            Submitted: {{ $submission->formatted_submitted_at ?? 'N/A' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-200 overflow-hidden">
                        <div class="bg-slate-50 border-b border-slate-100 px-8 py-4">
                            <h2 class="text-sm font-black text-slate-900 uppercase tracking-widest flex items-center gap-2">
                                <i class="fas fa-align-left text-cisa-accent"></i>
                                Abstract
                            </h2>
                        </div>
                        <div class="p-8">
                            <p class="text-slate-600 leading-relaxed text-lg font-medium whitespace-pre-line">
                                {{ $submission->abstract }}
                            </p>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-200 overflow-hidden">
                        <div class="bg-slate-50 border-b border-slate-100 px-8 py-4">
                            <h2 class="text-sm font-black text-slate-900 uppercase tracking-widest flex items-center gap-2">
                                <i class="fas fa-users text-cisa-accent"></i>
                                Authors
                            </h2>
                        </div>
                        <div class="p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($submission->authors as $author)
                                    <div
                                        class="p-6 rounded-2xl border border-slate-100 bg-slate-50 group hover:border-cisa-accent/30 transition-all">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="w-12 h-12 rounded-xl bg-cisa-base flex items-center justify-center text-white text-lg font-bold">
                                                {{ substr($author->first_name, 0, 1) }}{{ substr($author->last_name, 0, 1) }}
                                            </div>
                                            <div>
                                                <h3
                                                    class="font-bold text-slate-900 leading-none mb-1 group-hover:text-cisa-base transition-colors">
                                                    {{ $author->full_name }}
                                                </h3>
                                                @if($author->affiliation)
                                                    <p class="text-xs text-slate-400 font-medium">{{ $author->affiliation }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-200 overflow-hidden">
                        <div class="bg-slate-50 border-b border-slate-100 px-8 py-4">
                            <h2 class="text-sm font-black text-slate-900 uppercase tracking-widest flex items-center gap-2">
                                <i class="fas fa-file-invoice text-cisa-accent"></i>
                                Manuscript & Files
                            </h2>
                        </div>
                        <div class="p-8">
                            <div class="space-y-4">
                                @foreach($submission->files as $file)
                                    <div
                                        class="flex items-center justify-between p-5 rounded-2xl border border-slate-100 hover:bg-slate-50 transition-all group">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-500">
                                                @if(Str::endsWith($file->original_name, '.pdf'))
                                                    <i class="fas fa-file-pdf text-xl"></i>
                                                @else
                                                    <i class="fas fa-file-word text-xl"></i>
                                                @endif
                                            </div>
                                            <div>
                                                <p class="font-bold text-slate-900 leading-tight mb-1">
                                                    {{ $file->original_name }}
                                                </p>
                                                <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest">
                                                    {{ ucfirst($file->file_type) }} • v{{ $file->version }} •
                                                    {{ strtoupper(pathinfo($file->original_name, PATHINFO_EXTENSION)) }}
                                                </p>
                                            </div>
                                        </div>
                                        <a href="{{ route('submissions.files.download', [$submission, $file]) }}"
                                            class="px-5 py-2.5 bg-slate-900 hover:bg-cisa-base text-white rounded-xl font-bold text-xs uppercase tracking-widest transition-all hover:-translate-y-0.5 shadow-lg shadow-slate-200 group-hover:shadow-cisa-base/10">
                                            Download
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    @if($submission->reviews->count() > 0)
                        <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">Reviews</h2>
                            <div class="space-y-4">
                                @foreach($submission->reviews as $review)
                                    <div class="border border-gray-200 rounded-lg p-4">
                                        <div class="flex justify-between items-start mb-2">
                                            <h3 class="font-semibold text-gray-900">{{ $review->reviewer->full_name }}</h3>
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">{{ ucfirst($review->status) }}</span>
                                        </div>
                                        @if($review->recommendation)
                                            <p class="text-sm text-gray-600 mb-2">
                                                <strong>Recommendation:</strong>
                                                {{ ucfirst(str_replace('_', ' ', $review->recommendation)) }}
                                            </p>
                                        @endif
                                        @if($review->decline_reason)
                                            <p class="text-sm text-red-600 mb-2">
                                                <strong>Decline Reason:</strong> {{ $review->decline_reason }}
                                            </p>
                                        @endif
                                        @if($review->comments_for_editor)
                                            <p class="text-gray-700 mt-2"><strong>Comments for Editor:</strong></p>
                                            <p class="text-gray-700">{{ $review->comments_for_editor }}</p>
                                        @endif
                                        @if($review->comments_for_author)
                                            <p class="text-gray-700 mt-2"><strong>Comments for Author:</strong></p>
                                            <p class="text-gray-700">{{ $review->comments_for_author }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="space-y-6">
                    <!-- Anti-Plagiarism Card -->
                    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-200 overflow-hidden">
                        <div class="p-6 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
                            <h3 class="font-black text-slate-900 text-xs uppercase tracking-widest flex items-center gap-2">
                                <i class="fas fa-shield-alt text-cisa-base"></i> Anti-Plagiarism
                            </h3>
                            @if($submission->plagiarismReport && $submission->plagiarismReport->status === 'completed')
                                @php $isHighMatch = $submission->plagiarismReport->similarity_percentage >= 20; @endphp
                                <span
                                    class="px-2 py-0.5 rounded {{ $isHighMatch ? 'bg-red-600' : 'bg-cisa-base' }} text-white text-[10px] font-black uppercase tracking-tighter shadow-sm">
                                    {{ $submission->plagiarismReport->similarity_percentage }}% Match
                                </span>
                            @endif
                        </div>
                        <div class="p-6">
                            @if($submission->plagiarismReport && $submission->plagiarismReport->status === 'completed' && $submission->plagiarismReport->similarity_percentage >= 20)
                                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl animate-pulse">
                                    <div class="flex items-center gap-3">
                                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                                        <p class="text-[11px] font-black text-red-700 uppercase tracking-wider">Critical
                                            Similarity Warning</p>
                                    </div>
                                    <p class="text-[10px] text-red-600 mt-1 font-medium leading-relaxed">
                                        High similarity detected. Please review the detailed report immediately.
                                    </p>
                                </div>
                            @endif

                            @if(!$submission->plagiarismReport)
                                <div class="text-center py-6">
                                    <div
                                        class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-200 mx-auto mb-4">
                                        <i class="fas fa-search text-2xl"></i>
                                    </div>
                                    <p class="text-xs text-slate-500 font-medium mb-6 px-4 leading-relaxed">System-wide
                                        similarity check across all journal archives.</p>
                                    <form action="{{ route('submissions.plagiarism.check', $submission) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="w-full py-3.5 bg-cisa-base hover:bg-cisa-accent text-white rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-cisa-base/10 transition-all hover:-translate-y-0.5">
                                            Run Similarity Check
                                        </button>
                                    </form>
                                </div>
                            @elseif($submission->plagiarismReport->status === 'processing')
                                <div class="text-center py-6">
                                    <div class="relative inline-block mb-3">
                                        <div
                                            class="w-12 h-12 rounded-full border-4 border-slate-100 border-t-cisa-base animate-spin">
                                        </div>
                                    </div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Scanning
                                        Archive...</p>
                                </div>
                            @elseif($submission->plagiarismReport->status === 'completed')
                                @php $isHighMatch = $submission->plagiarismReport->similarity_percentage >= 20; @endphp
                                <div class="space-y-4">
                                    <div
                                        class="flex items-center justify-between p-4 {{ $isHighMatch ? 'bg-red-50 border-red-100' : 'bg-slate-50 border-slate-100' }} rounded-2xl border transition-colors duration-500">
                                        <div>
                                            <p
                                                class="text-[9px] {{ $isHighMatch ? 'text-red-400' : 'text-slate-400' }} font-black uppercase tracking-widest mb-1">
                                                Similarity Index</p>
                                            <p
                                                class="text-2xl font-black {{ $isHighMatch ? 'text-red-700' : 'text-slate-900' }} leading-none">
                                                {{ $submission->plagiarismReport->similarity_percentage }}<span
                                                    class="text-sm font-bold opacity-50 ml-0.5">%</span>
                                            </p>
                                        </div>
                                        <a href="{{ route('submissions.plagiarism.report', $submission) }}"
                                            class="w-10 h-10 flex items-center justify-center bg-white rounded-xl border {{ $isHighMatch ? 'border-red-200 text-red-600 hover:bg-red-600' : 'border-slate-200 text-cisa-base hover:bg-cisa-base' }} hover:text-white transition-all shadow-sm">
                                            <i class="fas fa-eye text-sm"></i>
                                        </a>
                                    </div>
                                    <form action="{{ route('submissions.plagiarism.check', $submission) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="w-full py-2 {{ $isHighMatch ? 'text-red-400 hover:text-red-600' : 'text-slate-400 hover:text-cisa-base' }} text-[9px] font-black uppercase tracking-widest transition-all">
                                            <i class="fas fa-sync-alt mr-1"></i> Re-run Check
                                        </button>
                                    </form>
                                </div>
                            @elseif($submission->plagiarismReport->status === 'failed')
                                <div class="p-3 bg-red-50 rounded-lg border border-red-100 mb-4">
                                    <p class="text-[10px] text-red-700 font-bold uppercase mb-1">Check Failed</p>
                                    <p class="text-xs text-red-600">
                                        {{ Str::limit($submission->plagiarismReport->error_message, 50) }}
                                    </p>
                                </div>
                                <form action="{{ route('submissions.plagiarism.check', $submission) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full py-2.5 bg-red-600 text-white rounded-lg text-sm font-bold hover:bg-red-700 transition-all">
                                        Retry Check
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <!-- Editor Actions -->
                    @if(auth()->user()->hasJournalRole($journal->id, 'editor') || auth()->user()->hasJournalRole($journal->id, 'journal_manager'))
                        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-200 overflow-hidden">
                            <div class="bg-slate-50 border-b border-slate-100 px-6 py-4">
                                <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest flex items-center gap-2">
                                    <i class="fas fa-bolt text-cisa-accent"></i> Editor Console
                                </h3>
                            </div>
                            <div class="p-6 space-y-3">
                                @if(in_array($submission->status, ['submitted', 'under_review', 'revision_requested']))
                                    <button onclick="showAcceptModal()"
                                        class="w-full flex items-center justify-between px-5 py-3.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-100 rounded-xl font-bold text-xs transition-all group">
                                        <span>Accept Submission</span>
                                        <i class="fas fa-check-circle opacity-50 group-hover:opacity-100 transition-opacity"></i>
                                    </button>

                                    <button onclick="showRevisionModal()"
                                        class="w-full flex items-center justify-between px-5 py-3.5 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-100 rounded-xl font-bold text-xs transition-all group">
                                        <span>Request Revision</span>
                                        <i class="fas fa-edit opacity-50 group-hover:opacity-100 transition-opacity"></i>
                                    </button>

                                    <button onclick="showRejectModal()"
                                        class="w-full flex items-center justify-between px-5 py-3.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-100 rounded-xl font-bold text-xs transition-all group">
                                        <span>Reject Manuscript</span>
                                        <i class="fas fa-times-circle opacity-50 group-hover:opacity-100 transition-opacity"></i>
                                    </button>
                                @endif

                                @if($submission->status === 'submitted')
                                    <button onclick="showDeskRejectModal()"
                                        class="w-full flex items-center justify-between px-5 py-3.5 bg-red-50 hover:bg-red-100 text-red-700 border border-red-100 rounded-xl font-bold text-xs transition-all group">
                                        <span>Desk Reject</span>
                                        <i class="fas fa-ban opacity-50 group-hover:opacity-100 transition-opacity"></i>
                                    </button>
                                @endif

                                @if($submission->status === 'accepted')
                                    @if($submission->proofread_manuscript)
                                        <button onclick="showPublishModal()"
                                            class="w-full flex items-center justify-between px-5 py-3.5 bg-purple-50 hover:bg-purple-100 text-purple-700 border border-purple-100 rounded-xl font-bold text-xs transition-all group">
                                            <span>Publish Article</span>
                                            <i class="fas fa-paper-plane opacity-50 group-hover:opacity-100 transition-opacity"></i>
                                        </button>
                                    @else
                                        <button disabled
                                            class="w-full flex items-center justify-between px-5 py-3.5 bg-slate-50 text-slate-400 border border-slate-100 rounded-xl font-bold text-xs cursor-not-allowed opacity-60"
                                            title="Waiting for proofreader to submit final manuscript">
                                            <span class="flex items-center gap-2">
                                                <i class="fas fa-clock text-[10px] animate-pulse"></i>
                                                Waiting for Proofreader
                                            </span>
                                            <i class="fas fa-lock opacity-30"></i>
                                        </button>
                                    @endif
                                @endif

                                <!-- Payment Status Indicator -->
                                <div class="mt-4 pt-4 border-t border-slate-100">
                                    <label
                                        class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Workflow
                                        Payment Status</label>
                                    @php
                                        $payment = $submission->payment;
                                        $pStatusClass = 'bg-slate-100 text-slate-500 border-slate-200';
                                        $pStatusText = $submission->payment_status ?: 'Not Required';

                                        if ($submission->payment_status === 'paid') {
                                            $pStatusClass = 'bg-emerald-100 text-emerald-700 border-emerald-200';
                                        } elseif ($submission->payment_status === 'processing') {
                                            $pStatusClass = 'bg-blue-100 text-blue-700 border-blue-200';
                                            $pStatusText = 'Awaiting Verification';
                                        } elseif ($submission->payment_status === 'awaiting_payment' || $submission->payment_status === 'pending') {
                                            $pStatusClass = 'bg-amber-100 text-amber-700 border-amber-200 animate-pulse';
                                        }
                                    @endphp
                                    <div class="flex items-center justify-between p-3 rounded-xl border-2 {{ $pStatusClass }}">
                                        <span
                                            class="text-[10px] font-black uppercase tracking-widest">{{ strtoupper($pStatusText) }}</span>
                                        @if($payment)
                                            <a href="{{ route('editor.payments.show', [$journal, $payment]) }}"
                                                class="text-[9px] font-black uppercase tracking-tight text-cisa-base hover:underline">
                                                Invoice <i class="fas fa-external-link-alt ml-1"></i>
                                            </a>
                                        @endif
                                    </div>

                                    @if($submission->payment_status === 'processing' && $payment && $payment->proof_file)
                                        <div class="mt-4 p-4 bg-slate-50 rounded-2xl border-2 border-slate-100">
                                            <p
                                                class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2 text-center">
                                                Payment Proof Preview</p>
                                            <div
                                                class="relative group rounded-xl overflow-hidden aspect-video mb-4 border border-slate-200">
                                                @php $extension = pathinfo($payment->proof_file, PATHINFO_EXTENSION); @endphp
                                                @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp']))
                                                    <img src="{{ Storage::url($payment->proof_file) }}"
                                                        class="w-full h-full object-contain">
                                                @else
                                                    <div class="w-full h-full flex flex-col items-center justify-center bg-white">
                                                        <i class="fas fa-file-pdf text-2xl text-rose-500 mb-2"></i>
                                                        <span class="text-[8px] font-black text-cisa-base">PDF DOCUMENT</span>
                                                    </div>
                                                @endif
                                                <a href="{{ Storage::url($payment->proof_file) }}" target="_blank"
                                                    class="absolute inset-0 bg-cisa-base/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all text-white text-[8px] font-black uppercase tracking-widest">
                                                    View Full Size
                                                </a>
                                            </div>

                                            <div class="grid grid-cols-2 gap-2">
                                                <form method="POST"
                                                    action="{{ route('editor.payments.update-status', [$journal, $payment]) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="completed">
                                                    <button type="submit"
                                                        class="w-full py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-black text-[9px] uppercase tracking-widest rounded-lg transition-all">
                                                        Approve
                                                    </button>
                                                </form>
                                                <button
                                                    onclick="document.getElementById('reject-proof-modal').classList.remove('hidden')"
                                                    class="w-full py-2 bg-white border border-rose-200 text-rose-600 font-black text-[9px] uppercase tracking-widest rounded-lg transition-all">
                                                    Reject
                                                </button>
                                            </div>
                                        </div>
                                    @endif

                                    @if(($submission->payment_status === 'awaiting_payment' || $submission->payment_status === 'pending') && $submission->status === 'accepted')
                                        <p class="mt-2 text-[9px] font-bold text-amber-600 uppercase leading-tight italic">
                                            <i class="fas fa-exclamation-triangle mr-1"></i> Stalled: Waiting for author payment
                                            before copyediting.
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-200 overflow-hidden">
                        <div class="bg-slate-50 border-b border-slate-100 px-6 py-4">
                            <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest flex items-center gap-2">
                                <i class="fas fa-user-plus text-cisa-accent"></i> Assignment
                            </h3>
                        </div>
                        <div class="p-6">
                            <form method="POST"
                                action="{{ route('editor.submissions.assign-editor', [$journal, $submission]) }}">
                                @csrf
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Editor
                                    Assignee</label>
                                <select name="editor_id"
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl mb-4 focus:ring-2 focus:ring-cisa-base/10 focus:border-cisa-base outline-none transition-all text-sm font-medium">
                                    <option value="">Select Editor</option>
                                    @foreach($journal->editors as $editor)
                                        <option value="{{ $editor->id }}" {{ $submission->assigned_editor_id == $editor->id ? 'selected' : '' }}>
                                            {{ $editor->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit"
                                    class="w-full py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-black text-[10px] uppercase tracking-widest transition-all">
                                    Update Assignment
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-200 overflow-hidden">
                        <div class="bg-slate-50 border-b border-slate-100 px-6 py-4">
                            <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest flex items-center gap-2">
                                <i class="fas fa-microscope text-cisa-accent"></i> Peer Review
                            </h3>
                        </div>
                        <div class="p-6">
                            <form method="POST"
                                action="{{ route('editor.submissions.assign-reviewer', [$journal, $submission]) }}">
                                @csrf
                                <div class="mb-4">
                                    <label
                                        class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Available
                                        Reviewers</label>
                                    <select name="reviewer_id"
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-cisa-base/10 focus:border-cisa-base outline-none transition-all text-sm font-medium"
                                        required>
                                        <option value="">Select Reviewer</option>
                                        @foreach($reviewers as $reviewer)
                                            <option value="{{ $reviewer->id }}">{{ $reviewer->full_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-6">
                                    <label
                                        class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Completion
                                        Deadline</label>
                                    <input type="date" name="due_date"
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-cisa-base/10 focus:border-cisa-base outline-none transition-all text-sm font-medium"
                                        required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                </div>
                                <button type="submit"
                                    class="w-full py-3 bg-cisa-accent hover:bg-amber-600 text-slate-900 rounded-xl font-black text-[10px] uppercase tracking-widest transition-all shadow-lg shadow-amber-200">
                                    Send Review Request
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-200 overflow-hidden">
                        <div class="bg-slate-50 border-b border-slate-100 px-6 py-4">
                            <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest flex items-center gap-2">
                                <i class="fas fa-history text-slate-400"></i> Audit Trail
                            </h3>
                        </div>
                        <div class="p-6">
                            <div
                                class="space-y-6 relative before:absolute before:inset-0 before:left-3 before:w-0.5 before:bg-slate-100">
                                @foreach($submission->logs as $log)
                                    <div class="relative pl-10">
                                        <div
                                            class="absolute left-1.5 top-1.5 w-3 h-3 rounded-full bg-white border-2 border-slate-300 z-10">
                                        </div>
                                        <p class="text-xs font-bold text-slate-900 leading-tight">
                                            {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                                        </p>
                                        @if($log->user)
                                            <p class="text-[10px] text-slate-400 font-medium">By {{ $log->user->full_name }}</p>
                                        @endif
                                        <p class="text-[9px] text-slate-300 font-bold uppercase mt-1">
                                            {{ $log->created_at->format('M d, H:i') }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Accept Modal -->
                <div id="acceptModal"
                    class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Accept Submission</h3>
                        <form method="POST" action="{{ route('editor.submissions.accept', [$journal, $submission]) }}">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Notes (Optional)</label>
                                <textarea name="notes" rows="3"
                                    class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-green-500"
                                    placeholder="Add any notes..."></textarea>
                            </div>
                            <div class="flex gap-3">
                                <button type="button" onclick="hideAcceptModal()"
                                    class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg">Cancel</button>
                                <button type="submit"
                                    class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">Accept</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Reject Modal -->
                <div id="rejectModal"
                    class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Reject Submission</h3>
                        <form method="POST" action="{{ route('editor.submissions.reject', [$journal, $submission]) }}">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Rejection Reason *</label>
                                <textarea name="reason" rows="4" required
                                    class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500"
                                    placeholder="Provide reason for rejection..."></textarea>
                            </div>
                            <div class="flex gap-3">
                                <button type="button" onclick="hideRejectModal()"
                                    class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg">Cancel</button>
                                <button type="submit"
                                    class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg">Reject</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Desk Reject Modal -->
                <div id="deskRejectModal"
                    class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Desk Reject (Without Review)</h3>
                        <form method="POST" action="{{ route('editor.submissions.desk-reject', [$journal, $submission]) }}">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Rejection Reason *</label>
                                <textarea name="reason" rows="4" required
                                    class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500"
                                    placeholder="Provide reason for desk rejection..."></textarea>
                            </div>
                            <div class="flex gap-3">
                                <button type="button" onclick="hideDeskRejectModal()"
                                    class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg">Cancel</button>
                                <button type="submit"
                                    class="flex-1 bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg">Desk
                                    Reject</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Request Revision Modal -->
                <div id="revisionModal"
                    class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Request Revision</h3>
                        {{-- Use no-slug route to avoid slug/journal mismatch 404s --}}
                        <form method="POST"
                            action="{{ route('editor.submissions.request-revision.no-slug', $submission) }}">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Revision Type *</label>
                                <select name="revision_type" required
                                    class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-yellow-500">
                                    <option value="minor_revision">Minor Revision</option>
                                    <option value="major_revision">Major Revision</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Comments for Author *</label>
                                <textarea name="comments" rows="4" required
                                    class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-yellow-500"
                                    placeholder="Provide revision instructions..."></textarea>
                            </div>
                            <div class="flex gap-3">
                                <button type="button" onclick="hideRevisionModal()"
                                    class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg">Cancel</button>
                                <button type="submit"
                                    class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-lg">Request
                                    Revision</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Publish Modal -->
                <div id="publishModal"
                    class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Publish Article</h3>
                        {{-- Use no-slug route to avoid slug/journal mismatch 404s --}}
                        <form method="POST" action="{{ route('editor.submissions.publish.no-slug', $submission) }}">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Issue (Optional)</label>
                                <select name="issue_id"
                                    class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-purple-500">
                                    <option value="">Select Issue</option>
                                    @foreach($journal->issues()->where('is_published', true)->get() as $issue)
                                        <option value="{{ $issue->id }}">{{ $issue->display_title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Page Start</label>
                                    <input type="number" name="page_start"
                                        class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Page End</label>
                                    <input type="number" name="page_end"
                                        class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg">
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <button type="button" onclick="hidePublishModal()"
                                    class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg">Cancel</button>
                                <button type="submit"
                                    class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-lg">Publish</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Contact Author Modal -->
                <div id="contactModal"
                    class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Contact Author</h3>
                        {{-- Use no-slug route to avoid 404 if slug/journal context mismatch --}}
                        <form method="POST" action="{{ route('editor.submissions.contact-author.no-slug', $submission) }}">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Subject *</label>
                                <input type="text" name="subject" required
                                    class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-500"
                                    placeholder="Email subject...">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Message *</label>
                                <textarea name="message" rows="5" required
                                    class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-500"
                                    placeholder="Your message..."></textarea>
                            </div>
                            <div class="flex gap-3">
                                <button type="button" onclick="hideContactModal()"
                                    class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg">Cancel</button>
                                <button type="submit"
                                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">Send
                                    Email</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Reject Proof Modal -->
                @if($payment)
                    <div id="reject-proof-modal"
                        class="fixed inset-0 bg-cisa-base/80 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
                        <div class="bg-white rounded-3xl max-w-md w-full p-8 shadow-2xl">
                            <h3 class="text-xl font-black text-cisa-base uppercase tracking-tight mb-4">Reject Payment Proof
                            </h3>
                            <p class="text-xs text-slate-500 font-bold mb-6">Please provide a reason for rejecting this proof.
                                The author will be notified to re-upload.</p>

                            <form method="POST" action="{{ route('editor.payments.update', [$journal, $payment]) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="failed">
                                <textarea name="notes" rows="4" required
                                    placeholder="e.g. Image is blurry, Incorrect transaction ID..."
                                    class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-cisa-accent outline-none font-bold text-cisa-base text-xs mb-6"></textarea>

                                <div class="flex gap-4">
                                    <button type="button"
                                        onclick="document.getElementById('reject-proof-modal').classList.add('hidden')"
                                        class="flex-1 py-4 bg-slate-100 text-slate-500 font-black rounded-xl uppercase tracking-widest text-[10px]">Cancel</button>
                                    <button type="submit"
                                        class="flex-1 py-4 bg-rose-600 text-white font-black rounded-xl uppercase tracking-widest text-[10px]">Reject</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif

                <script>
                    function showAcceptModal() { document.getElementById('acceptModal').classList.remove('hidden'); }
                    function hideAcceptModal() { document.getElementById('acceptModal').classList.add('hidden'); }
                    function showRejectModal() { document.getElementById('rejectModal').classList.remove('hidden'); }
                    function hideRejectModal() { document.getElementById('rejectModal').classList.add('hidden'); }
                    function showDeskRejectModal() { document.getElementById('deskRejectModal').classList.remove('hidden'); }
                    function hideDeskRejectModal() { document.getElementById('deskRejectModal').classList.add('hidden'); }
                    function showRevisionModal() { document.getElementById('revisionModal').classList.remove('hidden'); }
                    function hideRevisionModal() { document.getElementById('revisionModal').classList.add('hidden'); }
                    function showPublishModal() { document.getElementById('publishModal').classList.remove('hidden'); }
                    function hidePublishModal() { document.getElementById('publishModal').classList.add('hidden'); }
                    function showContactModal() { document.getElementById('contactModal').classList.remove('hidden'); }
                    function hideContactModal() { document.getElementById('contactModal').classList.add('hidden'); }
                </script>

                <!-- Copyedit Status Section -->
                @if($submission->status === 'accepted' && $submission->current_stage === 'copyediting')
                    <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6 mt-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Copyedit Status</h2>
                        @if($submission->copyedit_approval_status === 'pending' || $submission->copyedit_approval_status === null)
                            <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-lg">
                                <p class="text-sm text-yellow-800">
                                    <i class="fas fa-clock mr-2"></i>Waiting for author approval of copyedited files.
                                </p>
                            </div>
                        @elseif($submission->copyedit_approval_status === 'approved')
                            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                                <p class="text-sm text-green-800 mb-2">
                                    <i class="fas fa-check-circle mr-2"></i>Author has approved copyedited files. Ready for final
                                    approval.
                                </p>
                                @if(auth()->user()->hasJournalRole($journal->id, ['journal_manager', 'section_editor', 'editor']))
                                    <form method="POST"
                                        action="{{ route('editor.submissions.copyedit.final-approve', [$journal, $submission]) }}"
                                        class="mt-4">
                                        @csrf
                                        <button type="submit"
                                            class="w-full bg-cisa-base hover:bg-slate-900 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition-all hover:-translate-y-0.5">
                                            <i class="fas fa-check-double mr-2"></i>Final Approve & Move to Proofreading
                                        </button>
                                    </form>
                                @else
                                    <p class="text-sm text-gray-700 mt-2">Only Editors, Journal Managers or Section Editors can provide
                                        final
                                        approval.</p>
                                @endif
                            </div>
                        @elseif($submission->copyedit_approval_status === 'changes_requested')
                            <div class="bg-orange-50 border-l-4 border-orange-500 p-4 rounded-lg">
                                <p class="text-sm text-orange-800">
                                    <i class="fas fa-edit mr-2"></i>Author has requested changes to copyedited files.
                                </p>
                                @if($submission->copyedit_author_comments)
                                    <p class="text-sm text-gray-700 mt-2">
                                        <strong>Author Comments:</strong> {{ $submission->copyedit_author_comments }}
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Galley Management Section -->
                @if($submission->status === 'accepted' && ($submission->current_stage === 'proofreading' || $submission->current_stage === 'production'))
                    <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6 mt-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-bold text-gray-900">Galleys</h2>
                            @if(auth()->user()->hasJournalRole($journal->id, ['journal_manager', 'editor', 'section_editor']))
                                <button onclick="document.getElementById('upload-galley-modal').classList.remove('hidden')"
                                    class="px-4 py-2 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors">
                                    <i class="fas fa-upload mr-2"></i>Upload Galley
                                </button>
                            @endif
                        </div>

                        @php
                            $galleys = $submission->galleys;
                        @endphp

                        @if($galleys->count() > 0)
                            <div class="space-y-3">
                                @foreach($galleys as $galley)
                                    <div class="border-2 border-gray-200 rounded-lg p-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center">
                                                <i
                                                    class="fas fa-file-{{ $galley->type === 'pdf' ? 'pdf' : ($galley->type === 'html' ? 'code' : 'file-code') }} text-{{ $galley->type === 'pdf' ? 'red' : ($galley->type === 'html' ? 'blue' : 'green') }}-600 text-xl mr-3"></i>
                                                <div>
                                                    <p class="font-semibold text-gray-900">
                                                        {{ $galley->label ?? strtoupper($galley->type) }}
                                                    </p>
                                                    <p class="text-sm text-gray-500">{{ $galley->original_name }}</p>
                                                </div>
                                            </div>
                                            <div>
                                                @if($galley->approval_status === 'approved')
                                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-lg text-sm font-semibold">
                                                        Approved
                                                    </span>
                                                @elseif($galley->approval_status === 'changes_requested')
                                                    <span class="px-3 py-1 bg-orange-100 text-orange-800 rounded-lg text-sm font-semibold">
                                                        Changes Requested
                                                    </span>
                                                @else
                                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-lg text-sm font-semibold">
                                                        Pending Approval
                                                    </span>
                                                @endif

                                                <a href="{{ route('submissions.galleys.download', [$submission, $galley]) }}"
                                                    class="ml-3 text-cisa-base hover:text-slate-900 transition-colors"
                                                    title="Download Galley">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </div>
                                        </div>
                                        @if($galley->author_comments)
                                            <div class="bg-orange-50 border-l-4 border-orange-500 p-3 rounded-lg mt-2">
                                                <p class="text-sm text-gray-700">
                                                    <strong>Author Comments:</strong> {{ $galley->author_comments }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            @if($galleys->where('approval_status', '!=', 'approved')->count() === 0 && $submission->copyedit_approval_status === 'approved')
                                @if(auth()->user()->hasJournalRole($journal->id, ['journal_manager', 'section_editor']))
                                    @if($submission->proofread_manuscript)
                                        <div class="mt-4">
                                            <form method="POST" action="{{ route('production.submissions.final-publish', $submission) }}">
                                                @csrf
                                                <div class="mb-4">
                                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Issue (Optional)</label>
                                                    <select name="issue_id" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg">
                                                        <option value="">Select Issue</option>
                                                        @foreach($journal->issues()->orderBy('created_at', 'desc')->get() as $issue)
                                                            <option value="{{ $issue->id }}">{{ $issue->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="grid grid-cols-2 gap-4 mb-4">
                                                    <div>
                                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Page Start</label>
                                                        <input type="number" name="page_start"
                                                            class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg">
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Page End</label>
                                                        <input type="number" name="page_end"
                                                            class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg">
                                                    </div>
                                                </div>
                                                <button type="submit"
                                                    class="w-full bg-[#0056FF] hover:bg-[#0044CC] text-white font-bold py-3 px-4 rounded-lg shadow-lg transition-all hover:-translate-y-0.5">
                                                    <i class="fas fa-globe mr-2"></i>Final Publish Article
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <div class="mt-4 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
                                            <p class="text-sm text-blue-800 font-bold flex items-center gap-2">
                                                <i class="fas fa-info-circle"></i>
                                                Waiting for Proofreader File
                                            </p>
                                            <p class="text-[11px] text-blue-600 mt-1 uppercase tracking-wider font-black">
                                                Final publication is blocked until the proofreader uploads the definitive manuscript.
                                            </p>
                                        </div>
                                    @endif
                                @endif
                            @endif
                        @else
                            <div class="bg-gray-50 border-l-4 border-gray-400 p-4 rounded-lg">
                                <p class="text-sm text-gray-700">
                                    <i class="fas fa-info-circle mr-2"></i>No galleys uploaded yet.
                                </p>
                            </div>
                        @endif

                        <!-- Upload Galley Modal -->
                        <div id="upload-galley-modal"
                            class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                            <div class="bg-white rounded-xl p-6 max-w-2xl w-full mx-4">
                                <h3 class="text-xl font-bold text-gray-900 mb-4">Upload Galley</h3>
                                <form method="POST" action="{{ route('production.galleys.upload', $submission) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Galley Type <span class="text-red-500">*</span>
                                        </label>
                                        <select name="type" required
                                            class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg">
                                            <option value="pdf">PDF</option>
                                            <option value="html">HTML</option>
                                            <option value="xml">XML</option>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Label (Optional)
                                        </label>
                                        <input type="text" name="label"
                                            class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg"
                                            placeholder="e.g., PDF, HTML, XML">
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            File <span class="text-red-500">*</span>
                                        </label>
                                        <input type="file" name="file" required accept=".pdf,.html,.xml"
                                            class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg">
                                    </div>
                                    <div class="flex gap-4">
                                        <button type="button"
                                            onclick="document.getElementById('upload-galley-modal').classList.add('hidden')"
                                            class="flex-1 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg font-semibold transition-colors">
                                            Cancel
                                        </button>
                                        <button type="submit"
                                            class="flex-1 px-4 py-2 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors">
                                            Upload
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Discussion Threads Section -->
                <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6 mt-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-gray-900">Discussion Threads</h2>
                        <button onclick="document.getElementById('new-thread-modal-editor').classList.remove('hidden')"
                            class="px-4 py-2 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors">
                            <i class="fas fa-plus mr-2"></i>New Thread
                        </button>
                    </div>

                    @php
                        $threads = $submission->discussionThreads()->with(['comments.user', 'latestComment.user'])->get();
                    @endphp

                    @if($threads->count() > 0)
                        <div class="space-y-4">
                            @foreach($threads as $thread)
                                <div class="border-2 border-gray-200 rounded-lg p-4">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $thread->title }}</h3>
                                            @if($thread->description)
                                                <p class="text-sm text-gray-600 mb-2">{{ $thread->description }}</p>
                                            @endif
                                            <p class="text-xs text-gray-500">
                                                <i class="fas fa-comments mr-1"></i>{{ $thread->comments->count() }} comments
                                                <span class="mx-2">•</span>
                                                <i class="fas fa-clock mr-1"></i>{{ $thread->created_at->format('M d, Y') }}
                                            </p>
                                        </div>
                                        <div class="flex gap-2">
                                            @if($thread->is_locked)
                                                <span class="px-3 py-1 bg-red-100 text-red-800 rounded-lg text-sm font-semibold">
                                                    <i class="fas fa-lock mr-1"></i>Locked
                                                </span>
                                            @endif
                                            @if(auth()->user()->hasJournalRole($journal->id, ['editor', 'journal_manager', 'section_editor']))
                                                <form method="POST"
                                                    action="{{ route('discussions.threads.toggle-lock', ['submission' => $submission, 'thread' => $thread]) }}"
                                                    class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="px-3 py-1 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg text-sm font-semibold transition-colors">
                                                        <i
                                                            class="fas fa-{{ $thread->is_locked ? 'unlock' : 'lock' }} mr-1"></i>{{ $thread->is_locked ? 'Unlock' : 'Lock' }}
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Comments -->
                                    <div class="space-y-3 mt-4 max-h-96 overflow-y-auto">
                                        @foreach($thread->comments as $comment)
                                            @if(!$comment->is_internal || auth()->user()->hasJournalRole($journal->id, ['editor', 'journal_manager', 'section_editor']))
                                                <div class="border-l-4 border-[#0056FF] pl-4 py-2 bg-gray-50 rounded-r-lg">
                                                    <div class="flex items-center justify-between mb-1">
                                                        <p class="font-semibold text-gray-900">{{ $comment->user->full_name }}</p>
                                                        <p class="text-xs text-gray-500">{{ $comment->created_at->format('M d, Y H:i') }}
                                                        </p>
                                                    </div>
                                                    <p class="text-sm text-gray-700 whitespace-pre-line">{{ $comment->comment }}</p>
                                                    @if($comment->is_internal)
                                                        <span class="inline-block mt-2 px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">
                                                            Internal Note (Editors Only)
                                                        </span>
                                                    @endif
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>

                                    <!-- Add Comment Form -->
                                    @if(!$thread->is_locked)
                                        <form method="POST"
                                            action="{{ route('discussions.comments.store', ['submission' => $submission, 'thread' => $thread]) }}"
                                            class="mt-4">
                                            @csrf
                                            <div class="mb-2">
                                                <label class="flex items-center">
                                                    <input type="checkbox" name="is_internal" value="1" class="mr-2">
                                                    <span class="text-sm text-gray-700">Internal comment (visible to editors
                                                        only)</span>
                                                </label>
                                            </div>
                                            <div class="flex gap-3">
                                                <textarea name="comment" rows="3" required
                                                    class="flex-1 px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]"
                                                    placeholder="Add a comment..."></textarea>
                                                <button type="submit"
                                                    class="px-6 py-2 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors">
                                                    <i class="fas fa-paper-plane mr-2"></i>Post
                                                </button>
                                            </div>
                                        </form>
                                    @else
                                        <div class="mt-4 bg-red-50 border-l-4 border-red-500 p-3 rounded-lg">
                                            <p class="text-sm text-red-800">
                                                <i class="fas fa-lock mr-2"></i>This thread is locked. No new comments can be added.
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-comments text-4xl mb-3"></i>
                            <p>No discussion threads yet. Start a conversation!</p>
                        </div>
                    @endif

                    <!-- New Thread Modal -->
                    <div id="new-thread-modal-editor"
                        class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                        <div class="bg-white rounded-xl p-6 max-w-2xl w-full mx-4">
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Create New Discussion Thread</h3>
                            <form method="POST" action="{{ route('discussions.threads.store', $submission) }}">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Title <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="title" required
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]"
                                        placeholder="Enter thread title...">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Description (Optional)
                                    </label>
                                    <textarea name="description" rows="4"
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]"
                                        placeholder="Enter thread description..."></textarea>
                                </div>
                                <div class="flex gap-4">
                                    <button type="button"
                                        onclick="document.getElementById('new-thread-modal-editor').classList.add('hidden')"
                                        class="flex-1 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg font-semibold transition-colors">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                        class="flex-1 px-4 py-2 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors">
                                        Create Thread
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection