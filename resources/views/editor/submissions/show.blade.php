@extends('layouts.app')

@section('title', $submission->title)

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <a href="{{ route('editor.submissions.index', $journal) }}" class="text-primary-600 hover:text-primary-800">← Back to Submissions</a>
    </div>

    <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6 mb-6">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $submission->title }}</h1>
                <p class="text-gray-600">{{ $submission->journal->name }}</p>
            </div>
            <div class="text-right">
                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">{{ ucfirst(str_replace('_', ' ', $submission->status)) }}</span>
                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 ml-2">{{ ucfirst(str_replace('_', ' ', $submission->current_stage)) }}</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Abstract</h2>
                <p class="text-gray-700 whitespace-pre-line">{{ $submission->abstract }}</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Authors</h2>
                <div class="space-y-3">
                    @foreach($submission->authors as $author)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h3 class="font-semibold text-gray-900">{{ $author->full_name }}</h3>
                            @if($author->affiliation)
                                <p class="text-sm text-gray-600">{{ $author->affiliation }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Files</h2>
                <div class="space-y-2">
                    @foreach($submission->files as $file)
                        <div class="flex items-center justify-between border border-gray-200 rounded-lg p-3">
                            <div>
                                <p class="font-medium text-gray-900">{{ $file->original_name }}</p>
                                <p class="text-sm text-gray-500">{{ ucfirst($file->file_type) }} • Version {{ $file->version }}</p>
                            </div>
                            <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-semibold text-sm transition-colors">
                                Download
                            </a>
                        </div>
                    @endforeach
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
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">{{ ucfirst($review->status) }}</span>
                                </div>
                                @if($review->recommendation)
                                    <p class="text-sm text-gray-600 mb-2">
                                        <strong>Recommendation:</strong> {{ ucfirst(str_replace('_', ' ', $review->recommendation)) }}
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
            <!-- Editor Actions -->
            @if(auth()->user()->hasJournalRole($journal->id, 'editor') || auth()->user()->hasJournalRole($journal->id, 'journal_manager'))
            <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Editor Actions</h2>
                <div class="space-y-3">
                    @if(in_array($submission->status, ['submitted', 'under_review', 'revision_requested']))
                        <!-- Accept Button -->
                        <button onclick="showAcceptModal()" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold transition-colors">
                            <i class="fas fa-check mr-2"></i>Accept Submission
                        </button>
                        
                        <!-- Request Revision Button -->
                        <button onclick="showRevisionModal()" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg font-semibold transition-colors">
                            <i class="fas fa-edit mr-2"></i>Request Revision
                        </button>
                        
                        <!-- Reject Button -->
                        <button onclick="showRejectModal()" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-semibold transition-colors">
                            <i class="fas fa-times mr-2"></i>Reject Submission
                        </button>
                    @endif
                    
                    @if($submission->status === 'submitted')
                        <!-- Desk Reject Button -->
                        <button onclick="showDeskRejectModal()" class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-semibold transition-colors">
                            <i class="fas fa-ban mr-2"></i>Desk Reject
                        </button>
                    @endif
                    
                    @if($submission->status === 'accepted')
                        <!-- Publish Button -->
                        <button onclick="showPublishModal()" class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-semibold transition-colors">
                            <i class="fas fa-paper-plane mr-2"></i>Publish Article
                        </button>
                    @endif
                    
                    <!-- Contact Author Button -->
                    <button onclick="showContactModal()" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition-colors">
                        <i class="fas fa-envelope mr-2"></i>Contact Author
                    </button>
                </div>
            </div>
            @endif

            <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Assign Editor</h2>
                <form method="POST" action="{{ route('editor.submissions.assign-editor', [$journal, $submission]) }}">
                    @csrf
                    <select name="editor_id" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg mb-4 focus:outline-none focus:border-[#0056FF]">
                        <option value="">Select Editor</option>
                        @foreach($journal->editors as $editor)
                            <option value="{{ $editor->id }}" {{ $submission->assigned_editor_id == $editor->id ? 'selected' : '' }}>
                                {{ $editor->full_name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="w-full px-4 py-2 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors">Assign</button>
                </form>
            </div>

            <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Assign Reviewer</h2>
                <form method="POST" action="{{ route('editor.submissions.assign-reviewer', [$journal, $submission]) }}">
                    @csrf
                    <div class="mb-4">
                        <select name="reviewer_id" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]" required>
                            <option value="">Select Reviewer</option>
                            @foreach($reviewers as $reviewer)
                                <option value="{{ $reviewer->id }}">{{ $reviewer->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Due Date</label>
                        <input type="date" name="due_date" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                    </div>
                    <button type="submit" class="w-full px-4 py-2 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors">Assign Reviewer</button>
                </form>
            </div>

            <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Activity Log</h2>
                <div class="space-y-3">
                    @foreach($submission->logs as $log)
                        <div class="border-l-4 border-primary-500 pl-3">
                            <p class="text-sm font-medium text-gray-900">{{ ucfirst(str_replace('_', ' ', $log->action)) }}</p>
                            @if($log->user)
                                <p class="text-xs text-gray-600">{{ $log->user->full_name }}</p>
                            @endif
                            <p class="text-xs text-gray-500">{{ $log->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Accept Modal -->
        <div id="acceptModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Accept Submission</h3>
                <form method="POST" action="{{ route('editor.submissions.accept', [$journal, $submission]) }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Notes (Optional)</label>
                        <textarea name="notes" rows="3" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-green-500" placeholder="Add any notes..."></textarea>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" onclick="hideAcceptModal()" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg">Cancel</button>
                        <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">Accept</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Reject Modal -->
        <div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Reject Submission</h3>
                <form method="POST" action="{{ route('editor.submissions.reject', [$journal, $submission]) }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Rejection Reason *</label>
                        <textarea name="reason" rows="4" required class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500" placeholder="Provide reason for rejection..."></textarea>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" onclick="hideRejectModal()" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg">Cancel</button>
                        <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg">Reject</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Desk Reject Modal -->
        <div id="deskRejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Desk Reject (Without Review)</h3>
                <form method="POST" action="{{ route('editor.submissions.desk-reject', [$journal, $submission]) }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Rejection Reason *</label>
                        <textarea name="reason" rows="4" required class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500" placeholder="Provide reason for desk rejection..."></textarea>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" onclick="hideDeskRejectModal()" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg">Cancel</button>
                        <button type="submit" class="flex-1 bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg">Desk Reject</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Request Revision Modal -->
        <div id="revisionModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Request Revision</h3>
                <form method="POST" action="{{ route('editor.submissions.request-revision', [$journal, $submission]) }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Revision Type *</label>
                        <select name="revision_type" required class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-yellow-500">
                            <option value="minor_revision">Minor Revision</option>
                            <option value="major_revision">Major Revision</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Comments for Author *</label>
                        <textarea name="comments" rows="4" required class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-yellow-500" placeholder="Provide revision instructions..."></textarea>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" onclick="hideRevisionModal()" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg">Cancel</button>
                        <button type="submit" class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-lg">Request Revision</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Publish Modal -->
        <div id="publishModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Publish Article</h3>
                {{-- Use no-slug route to avoid slug/journal mismatch 404s --}}
                <form method="POST" action="{{ route('editor.submissions.publish.no-slug', $submission) }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Issue (Optional)</label>
                        <select name="issue_id" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-purple-500">
                            <option value="">Select Issue</option>
                            @foreach($journal->issues()->where('is_published', true)->get() as $issue)
                                <option value="{{ $issue->id }}">{{ $issue->display_title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Page Start</label>
                            <input type="number" name="page_start" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Page End</label>
                            <input type="number" name="page_end" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg">
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" onclick="hidePublishModal()" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg">Cancel</button>
                        <button type="submit" class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-lg">Publish</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Contact Author Modal -->
        <div id="contactModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Contact Author</h3>
                {{-- Use no-slug route to avoid 404 if slug/journal context mismatch --}}
                <form method="POST" action="{{ route('editor.submissions.contact-author.no-slug', $submission) }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Subject *</label>
                        <input type="text" name="subject" required class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-500" placeholder="Email subject...">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Message *</label>
                        <textarea name="message" rows="5" required class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-500" placeholder="Your message..."></textarea>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" onclick="hideContactModal()" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg">Cancel</button>
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">Send Email</button>
                    </div>
                </form>
            </div>
        </div>

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
                        <i class="fas fa-check-circle mr-2"></i>Author has approved copyedited files. Ready for final approval.
                    </p>
                    @if(auth()->user()->hasJournalRole($journal->id, ['journal_manager', 'section_editor']))
                        <p class="text-sm text-gray-700">You can final approve to move to proofreading stage.</p>
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
                                    <i class="fas fa-file-{{ $galley->type === 'pdf' ? 'pdf' : ($galley->type === 'html' ? 'code' : 'file-code') }} text-{{ $galley->type === 'pdf' ? 'red' : ($galley->type === 'html' ? 'blue' : 'green') }}-600 text-xl mr-3"></i>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $galley->label ?? strtoupper($galley->type) }}</p>
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
                                        <input type="number" name="page_start" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Page End</label>
                                        <input type="number" name="page_end" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg">
                                    </div>
                                </div>
                                <button type="submit" onclick="return confirm('Are you sure you want to publish this article?')" 
                                        class="w-full px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-semibold transition-colors">
                                    <i class="fas fa-check-circle mr-2"></i>Final Publish Article
                                </button>
                            </form>
                        </div>
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
            <div id="upload-galley-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                <div class="bg-white rounded-xl p-6 max-w-2xl w-full mx-4">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Upload Galley</h3>
                    <form method="POST" action="{{ route('production.galleys.upload', $submission) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Galley Type <span class="text-red-500">*</span>
                            </label>
                            <select name="type" required class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg">
                                <option value="pdf">PDF</option>
                                <option value="html">HTML</option>
                                <option value="xml">XML</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Label (Optional)
                            </label>
                            <input type="text" name="label" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg" placeholder="e.g., PDF, HTML, XML">
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
                                        <form method="POST" action="{{ route('discussions.threads.toggle-lock', ['submission' => $submission, 'thread' => $thread]) }}" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="px-3 py-1 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg text-sm font-semibold transition-colors">
                                                <i class="fas fa-{{ $thread->is_locked ? 'unlock' : 'lock' }} mr-1"></i>{{ $thread->is_locked ? 'Unlock' : 'Lock' }}
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
                                                <p class="text-xs text-gray-500">{{ $comment->created_at->format('M d, Y H:i') }}</p>
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
                                <form method="POST" action="{{ route('discussions.comments.store', ['submission' => $submission, 'thread' => $thread]) }}" class="mt-4">
                                    @csrf
                                    <div class="mb-2">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="is_internal" value="1" class="mr-2">
                                            <span class="text-sm text-gray-700">Internal comment (visible to editors only)</span>
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
            <div id="new-thread-modal-editor" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
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

