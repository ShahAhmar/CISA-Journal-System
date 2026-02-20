@extends('layouts.admin')

@section('title', 'View Submission - EMANP')
@section('page-title', 'Submission Details')
@section('page-subtitle', 'View and manage submission')

@section('content')
<div class="bg-white rounded-xl border-2 border-gray-200 p-8 mb-6">
    <div class="flex justify-between items-start mb-6">
        <div>
            <h2 class="text-2xl font-bold text-[#0F1B4C] mb-2" style="font-family: 'Playfair Display', serif;">{{ $submission->title }}</h2>
            <p class="text-gray-600">
                <span class="font-semibold">Journal:</span> {{ $submission->journal->name ?? 'N/A' }}
            </p>
        </div>
        <span class="px-4 py-2 rounded-full text-sm font-semibold 
            @if($submission->status == 'published') bg-green-100 text-green-700
            @elseif($submission->status == 'submitted') bg-orange-100 text-orange-700
            @elseif($submission->status == 'under_review') bg-blue-100 text-blue-700
            @elseif($submission->status == 'accepted') bg-green-100 text-green-700
            @elseif($submission->status == 'rejected') bg-red-100 text-red-700
            @else bg-gray-100 text-gray-700
            @endif">
            {{ ucfirst(str_replace('_', ' ', $submission->status)) }}
        </span>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
            <h3 class="font-semibold text-[#0F1B4C] mb-2">Author</h3>
            <p class="text-gray-600">{{ $submission->author->full_name ?? 'N/A' }}</p>
            <p class="text-sm text-gray-500">{{ $submission->author->email ?? '' }}</p>
        </div>
        <div>
            <h3 class="font-semibold text-[#0F1B4C] mb-2">Submitted Date</h3>
            <p class="text-gray-600">
                @if($submission->submitted_at)
                    {{ \Carbon\Carbon::parse($submission->submitted_at)->format('F d, Y h:i A') }}
                @else
                    {{ $submission->created_at->format('F d, Y h:i A') }}
                @endif
            </p>
        </div>
    </div>
    
    @if($submission->abstract)
        <div class="mb-6">
            <h3 class="font-semibold text-[#0F1B4C] mb-2">Abstract</h3>
            <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $submission->abstract }}</p>
        </div>
    @endif

    <!-- Site Administrator Notice -->
    <div class="bg-indigo-50 border-l-4 border-indigo-500 p-4 rounded-lg mb-6">
        <div class="flex items-start">
            <i class="fas fa-shield-alt text-indigo-600 mr-3 mt-1"></i>
            <div>
                <p class="font-semibold text-indigo-900 mb-1">Site Administrator Control</p>
                <p class="text-sm text-indigo-800">
                    As a Site Administrator, you have full editorial control over this submission. You can approve, reject, assign reviewers, or force-update the submission status.
                </p>
            </div>
        </div>
    </div>
    
    @if($submission->keywords)
        <div class="mb-6">
            <h3 class="font-semibold text-[#0F1B4C] mb-2">Keywords</h3>
            <div class="flex flex-wrap gap-2">
                @foreach(explode(',', $submission->keywords) as $keyword)
                    <span class="bg-[#F7F9FC] text-[#0056FF] px-3 py-1 rounded-full text-sm">{{ trim($keyword) }}</span>
                @endforeach
            </div>
        </div>
    @endif
    
    @if($submission->authors->count() > 0)
        <div class="mb-6">
            <h3 class="font-semibold text-[#0F1B4C] mb-3">All Authors</h3>
            <div class="space-y-2">
                @foreach($submission->authors as $author)
                    <div class="bg-[#F7F9FC] rounded-lg p-3">
                        <p class="font-medium text-[#0F1B4C]">{{ $author->full_name }}</p>
                        @if($author->email)
                            <p class="text-sm text-gray-600">{{ $author->email }}</p>
                        @endif
                        @if($author->is_corresponding)
                            <span class="inline-block mt-1 px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">Corresponding Author</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    
    @if($submission->files->count() > 0)
        <div class="mb-6">
            <h3 class="font-semibold text-[#0F1B4C] mb-4">Files</h3>
            <div class="space-y-2">
                @foreach($submission->files as $file)
                    <div class="flex items-center justify-between p-3 bg-[#F7F9FC] rounded-lg">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-file-alt text-blue-500"></i>
                            <div>
                                <span class="text-sm font-medium text-gray-700">{{ $file->original_name }}</span>
                                <p class="text-xs text-gray-500">{{ ucfirst($file->file_type) }} • Version {{ $file->version }}</p>
                            </div>
                        </div>
                        <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="px-4 py-2 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg text-sm font-semibold transition-colors">
                            <i class="fas fa-download mr-1"></i>Download
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<!-- Approval Section -->
    <!-- Editorial Actions -->
    <div class="bg-white rounded-xl border-2 border-gray-200 p-8 mb-6">
        <h3 class="text-xl font-bold text-[#0F1B4C] mb-6 flex items-center">
            <i class="fas fa-cogs mr-3 text-indigo-600"></i>Editorial Actions
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Approve -->
            <div class="border-2 border-green-200 rounded-xl p-6 bg-green-50">
                <form method="POST" action="{{ route('admin.submissions.approve', $submission) }}">
                    @csrf
                    <h4 class="font-bold text-[#0F1B4C] mb-4">Approve Submission</h4>
                    <p class="text-xs text-gray-600 mb-4">Move to copyediting stage.</p>
                    <button type="submit" class="w-full py-2 bg-green-600 text-white rounded font-bold text-sm">Approve</button>
                </form>
            </div>
            
            <!-- Reject -->
            <div class="border-2 border-red-200 rounded-xl p-6 bg-red-50">
                <form method="POST" action="{{ route('admin.submissions.reject', $submission) }}">
                    @csrf
                    <h4 class="font-bold text-[#0F1B4C] mb-4">Reject Submission</h4>
                    <textarea name="reason" rows="2" class="w-full text-xs p-2 border mb-2" placeholder="Reason..."></textarea>
                    <button type="submit" class="w-full py-2 bg-red-600 text-white rounded font-bold text-sm">Reject</button>
                </form>
            </div>
            
            <!-- Status Update -->
            <div class="border-2 border-blue-200 rounded-xl p-6 bg-blue-50">
                <form method="POST" action="{{ route('admin.submissions.update-status', $submission) }}">
                    @csrf
                    <h4 class="font-bold text-[#0F1B4C] mb-4">Force Status Update</h4>
                    <select name="status" class="w-full text-xs p-2 border mb-2">
                        <option value="submitted">Submitted</option>
                        <option value="under_review">Under Review</option>
                        <option value="revision_required">Revision Required</option>
                        <option value="accepted">Accepted</option>
                        <option value="published">Published</option>
                        <option value="rejected">Rejected</option>
                    </select>
                    <input type="hidden" name="stage" value="review"> <!-- Fallback stage -->
                    <button type="submit" class="w-full py-2 bg-[#0056FF] text-white rounded font-bold text-sm">Update Status</button>
                </form>
            </div>
        </div>
    </div>
    @else
    <h3 class="text-xl font-bold text-[#0F1B4C] mb-6 flex items-center">
        <i class="fas fa-check-circle mr-3 text-green-600"></i>Submission Approval
    </h3>
    
    <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-4 mb-6">
        <div class="flex items-start">
            <i class="fas fa-info-circle text-blue-600 mr-3 mt-1"></i>
            <div>
                <p class="font-semibold text-blue-900 mb-1">Journal Review Setting:</p>
                <p class="text-sm text-blue-800">
                    @if($submission->journal->requires_review ?? true)
                        <span class="font-semibold">This journal requires review.</span> Submissions will go through the review process.
                    @else
                        <span class="font-semibold">This journal allows direct approval.</span> You can approve submissions directly without review.
                    @endif
                </p>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Approve Direct -->
        <div class="border-2 border-green-200 rounded-xl p-6 bg-green-50">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-check text-white text-xl"></i>
                </div>
                <div>
                    <h4 class="font-bold text-lg text-[#0F1B4C]">Approve Directly</h4>
                    <p class="text-sm text-gray-600">Skip review and approve immediately</p>
                </div>
            </div>
            <p class="text-sm text-gray-700 mb-4">
                This will approve the submission and move it directly to the copyediting stage, bypassing the review process.
            </p>
            <form method="POST" action="{{ route('admin.submissions.approve', $submission) }}" onsubmit="return confirm('Are you sure you want to approve this submission directly? This will skip the review process.');">
                @csrf
                <input type="hidden" name="action" value="approve_direct">
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Notes (Optional)</label>
                    <textarea name="notes" rows="3" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]" placeholder="Add any notes about this approval..."></textarea>
                </div>
                <button type="submit" class="w-full px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition-colors shadow-lg">
                    <i class="fas fa-check mr-2"></i>Approve Directly
                </button>
            </form>
        </div>
        
        <!-- Send to Review -->
        <div class="border-2 border-blue-200 rounded-xl p-6 bg-blue-50">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-search text-white text-xl"></i>
                </div>
                <div>
                    <h4 class="font-bold text-lg text-[#0F1B4C]">Send to Review</h4>
                    <p class="text-sm text-gray-600">Start the peer review process</p>
                </div>
            </div>
            <p class="text-sm text-gray-700 mb-4">
                This will send the submission to the review stage where reviewers will evaluate it.
            </p>
            <form method="POST" action="{{ route('admin.submissions.approve', $submission) }}">
                @csrf
                <input type="hidden" name="action" value="approve_review">
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Notes (Optional)</label>
                    <textarea name="notes" rows="3" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]" placeholder="Add any notes for reviewers..."></textarea>
                </div>
                <button type="submit" class="w-full px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-colors shadow-lg">
                    <i class="fas fa-paper-plane mr-2"></i>Send to Review
                </button>
            </form>
        </div>
    </div>
    
    <!-- Reject Option -->
    <div class="mt-6 border-2 border-red-200 rounded-xl p-6 bg-red-50">
        <div class="flex items-center mb-4">
            <div class="w-12 h-12 bg-red-500 rounded-lg flex items-center justify-center mr-4">
                <i class="fas fa-times text-white text-xl"></i>
            </div>
            <div>
                <h4 class="font-bold text-lg text-[#0F1B4C]">Reject Submission</h4>
                <p class="text-sm text-gray-600">Reject this submission</p>
            </div>
        </div>
        <p class="text-sm text-gray-700 mb-4">
            This will reject the submission. Please provide a reason for rejection.
        </p>
        <form method="POST" action="{{ route('admin.submissions.reject', $submission) }}" onsubmit="return confirm('Are you sure you want to reject this submission? This action cannot be undone.');">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Rejection Reason <span class="text-red-500">*</span></label>
                <textarea name="reason" rows="4" required class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500" placeholder="Please provide a reason for rejection..."></textarea>
            </div>
            <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition-colors shadow-lg">
                <i class="fas fa-times mr-2"></i>Reject Submission
            </button>
        </form>
    </div>
    @endif
</div>
@endif

<!-- Activity Log -->
@if($submission->logs->count() > 0)
<div class="bg-white rounded-xl border-2 border-gray-200 p-8 mb-6">
    <h3 class="text-xl font-bold text-[#0F1B4C] mb-6 flex items-center">
        <i class="fas fa-history mr-3 text-indigo-600"></i>Activity Log
    </h3>
    <div class="space-y-4">
        @foreach($submission->logs as $log)
            <div class="border-l-4 border-[#0056FF] pl-4 py-2">
                <div class="flex items-center justify-between mb-1">
                    <p class="font-semibold text-[#0F1B4C]">{{ ucfirst(str_replace('_', ' ', $log->action)) }}</p>
                    <p class="text-xs text-gray-500">{{ $log->created_at->format('M d, Y H:i') }}</p>
                </div>
                @if($log->user)
                    <p class="text-sm text-gray-600 mb-1">
                        <i class="fas fa-user mr-1"></i>{{ $log->user->full_name }}
                    </p>
                @endif
                @if($log->message)
                    <p class="text-sm text-gray-700 mt-2">{{ $log->message }}</p>
                @endif
            </div>
        @endforeach
    </div>
</div>
@endif

<div class="flex justify-end space-x-4">
    <a href="{{ route('admin.submissions.index') }}" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-semibold transition-colors">
        <i class="fas fa-arrow-left mr-2"></i>Back to List
    </a>
</div>
@endsection
