@extends('layouts.app')

@section('title', $submission->title . ' | EMANP')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-br from-[#0F1B4C] to-[#1a2d6b] text-white py-12 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 20px 20px;"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="mb-6">
            <a href="{{ route('author.submissions.index') }}" class="inline-flex items-center text-blue-200 hover:text-white transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Back to Submissions
            </a>
        </div>
        
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="mb-4 md:mb-0">
                <h1 class="text-3xl md:text-4xl font-bold mb-2" style="font-family: 'Playfair Display', serif;">{{ $submission->title }}</h1>
                <p class="text-lg text-blue-200">{{ $submission->journal->name }}</p>
            </div>
            <div class="flex flex-wrap gap-3">
                @php
                    $statusColors = [
                        'submitted' => 'bg-blue-100 text-blue-800 border-blue-300',
                        'under_review' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
                        'revision_requested' => 'bg-orange-100 text-orange-800 border-orange-300',
                        'accepted' => 'bg-green-100 text-green-800 border-green-300',
                        'rejected' => 'bg-red-100 text-red-800 border-red-300',
                        'withdrawn' => 'bg-gray-100 text-gray-800 border-gray-300',
                        'published' => 'bg-purple-100 text-purple-800 border-purple-300',
                    ];
                    $statusColor = $statusColors[$submission->status] ?? 'bg-gray-100 text-gray-800 border-gray-300';
                @endphp
                <span class="px-4 py-2 rounded-lg font-semibold text-sm border-2 {{ $statusColor }}">
                    <i class="fas fa-info-circle mr-1"></i>{{ ucfirst(str_replace('_', ' ', $submission->status)) }}
                </span>
            </div>
        </div>
    </div>
</section>

<!-- Progress Indicator -->
<section class="bg-white border-b border-gray-200 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-xl font-bold text-[#0F1B4C] mb-6">Submission Progress</h2>
        @php
            $stages = [
                'submission' => ['label' => 'Submitted', 'icon' => 'fa-paper-plane', 'color' => 'blue'],
                'review' => ['label' => 'Under Review', 'icon' => 'fa-search', 'color' => 'yellow'],
                'revision' => ['label' => 'Revision', 'icon' => 'fa-edit', 'color' => 'orange'],
                'copyediting' => ['label' => 'Copyediting', 'icon' => 'fa-spell-check', 'color' => 'purple'],
                'proofreading' => ['label' => 'Proofreading', 'icon' => 'fa-check-double', 'color' => 'indigo'],
                'published' => ['label' => 'Published', 'icon' => 'fa-check-circle', 'color' => 'green'],
            ];
            
            $currentStageIndex = array_search($submission->current_stage, array_keys($stages));
            if ($currentStageIndex === false) $currentStageIndex = 0;
        @endphp
        
        <div class="relative">
            <!-- Progress Line -->
            <div class="absolute top-6 left-0 right-0 h-1 bg-gray-200 rounded-full" style="z-index: 0;">
                <div class="h-full bg-gradient-to-r from-[#0056FF] to-[#00A8FF] rounded-full transition-all duration-500" 
                     style="width: {{ ($currentStageIndex + 1) / count($stages) * 100 }}%"></div>
            </div>
            
            <!-- Stages -->
            <div class="relative flex justify-between" style="z-index: 1;">
                @foreach($stages as $stageKey => $stage)
                    @php
                        $stageIndex = array_search($stageKey, array_keys($stages));
                        $isActive = $stageIndex <= $currentStageIndex;
                        $isCurrent = $stageIndex == $currentStageIndex;
                    @endphp
                    <div class="flex flex-col items-center flex-1">
                        <div class="relative">
                            @php
                                $bgClass = $isActive ? match($stage['color']) {
                                    'blue' => 'bg-blue-500',
                                    'yellow' => 'bg-yellow-500',
                                    'orange' => 'bg-orange-500',
                                    'purple' => 'bg-purple-500',
                                    'indigo' => 'bg-indigo-500',
                                    'green' => 'bg-green-500',
                                    default => 'bg-gray-500',
                                } : 'bg-gray-200';
                                $ringClass = $isCurrent ? match($stage['color']) {
                                    'blue' => 'ring-4 ring-blue-200',
                                    'yellow' => 'ring-4 ring-yellow-200',
                                    'orange' => 'ring-4 ring-orange-200',
                                    'purple' => 'ring-4 ring-purple-200',
                                    'indigo' => 'ring-4 ring-indigo-200',
                                    'green' => 'ring-4 ring-green-200',
                                    default => '',
                                } : '';
                            @endphp
                            <div class="w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300 {{ $bgClass }} {{ $isActive ? 'text-white shadow-lg transform scale-110' : 'text-gray-400' }} {{ $ringClass }}">
                                @if($isActive && !$isCurrent)
                                    <i class="fas fa-check text-white"></i>
                                @else
                                    <i class="fas {{ $stage['icon'] }}"></i>
                                @endif
                            </div>
                            @if($isCurrent)
                                <div class="absolute -top-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white animate-pulse"></div>
                            @endif
                        </div>
                        <div class="mt-3 text-center">
                            <p class="text-xs font-semibold {{ $isActive ? 'text-[#0F1B4C]' : 'text-gray-400' }}">
                                {{ $stage['label'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <!-- Submission Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg border-2 border-gray-100 p-6 hover:shadow-xl transition-shadow">
            <div class="flex items-center mb-3">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600 font-medium">Submitted Date</p>
                    <p class="text-lg font-bold text-[#0F1B4C]">
                        @if($submission->submitted_at)
                            {{ \Carbon\Carbon::parse($submission->submitted_at)->format('M d, Y') }}
                        @else
                            {{ \Carbon\Carbon::parse($submission->created_at)->format('M d, Y') }}
                        @endif
                    </p>
                </div>
            </div>
        </div>
        
        @if($submission->published_at)
        <div class="bg-white rounded-xl shadow-lg border-2 border-gray-100 p-6 hover:shadow-xl transition-shadow">
            <div class="flex items-center mb-3">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600 font-medium">Published Date</p>
                    <p class="text-lg font-bold text-[#0F1B4C]">
                        {{ \Carbon\Carbon::parse($submission->published_at)->format('M d, Y') }}
                    </p>
                </div>
            </div>
        </div>
        @endif
        
        @if($submission->doi)
        <div class="bg-white rounded-xl shadow-lg border-2 border-gray-100 p-6 hover:shadow-xl transition-shadow">
            <div class="flex items-center mb-3">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-link text-purple-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600 font-medium">DOI</p>
                    <p class="text-sm font-bold text-[#0F1B4C] break-all">{{ $submission->doi }}</p>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Abstract -->
            <div class="bg-white rounded-xl shadow-lg border-2 border-gray-100 p-8">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-file-alt text-blue-600"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-[#0F1B4C]">Abstract</h2>
                </div>
                <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $submission->abstract }}</p>
            </div>

            <!-- Keywords -->
            @if($submission->keywords)
            <div class="bg-white rounded-xl shadow-lg border-2 border-gray-100 p-8">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-tags text-green-600"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-[#0F1B4C]">Keywords</h2>
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach(explode(',', $submission->keywords) as $keyword)
                        <span class="px-4 py-2 bg-[#F7F9FC] text-[#0F1B4C] rounded-lg font-medium text-sm border border-gray-200">
                            {{ trim($keyword) }}
                        </span>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Authors -->
            <div class="bg-white rounded-xl shadow-lg border-2 border-gray-100 p-8">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-users text-purple-600"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-[#0F1B4C]">Authors</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($submission->authors as $author)
                        <div class="bg-[#F7F9FC] border-2 border-gray-200 rounded-xl p-5 hover:border-[#0056FF] transition-colors">
                            <div class="flex items-start justify-between mb-3">
                                <h3 class="font-bold text-lg text-[#0F1B4C]">{{ $author->full_name }}</h3>
                                @if($author->is_corresponding)
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-lg text-xs font-semibold">
                                        <i class="fas fa-envelope mr-1"></i>Corresponding
                                    </span>
                                @endif
                            </div>
                            @if($author->affiliation)
                                <p class="text-sm text-gray-600 mb-2">
                                    <i class="fas fa-building mr-2 text-gray-400"></i>{{ $author->affiliation }}
                                </p>
                            @endif
                            @if($author->email)
                                <p class="text-sm text-gray-600 mb-2">
                                    <i class="fas fa-envelope mr-2 text-gray-400"></i>{{ $author->email }}
                                </p>
                            @endif
                            @if($author->orcid)
                                <p class="text-sm text-gray-600">
                                    <i class="fab fa-orcid mr-2 text-gray-400"></i>{{ $author->orcid }}
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Files -->
            <div class="bg-white rounded-xl shadow-lg border-2 border-gray-100 p-8">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-file-download text-orange-600"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-[#0F1B4C]">Files</h2>
                </div>
                <div class="space-y-3">
                    @forelse($submission->files as $file)
                        <div class="flex items-center justify-between bg-[#F7F9FC] border-2 border-gray-200 rounded-xl p-4 hover:border-[#0056FF] transition-all group">
                            <div class="flex items-center flex-1">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-[#0F1B4C] mb-1">{{ $file->original_name }}</p>
                                    <p class="text-sm text-gray-500">
                                        <i class="fas fa-tag mr-1"></i>{{ ucfirst($file->file_type) }} 
                                        <span class="mx-2">•</span>
                                        <i class="fas fa-code-branch mr-1"></i>Version {{ $file->version }}
                                        @if($file->file_size)
                                        <span class="mx-2">•</span>
                                        <i class="fas fa-weight-hanging mr-1"></i>{{ number_format($file->file_size / 1024, 2) }} KB
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" 
                               class="px-6 py-2 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors shadow-md hover:shadow-lg">
                                <i class="fas fa-download mr-2"></i>Download
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-file-alt text-4xl mb-3 text-gray-300"></i>
                            <p>No files uploaded yet</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Reviews -->
            @if($submission->reviews->count() > 0)
            <div class="bg-white rounded-xl shadow-lg border-2 border-gray-100 p-8">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-star text-yellow-600"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-[#0F1B4C]">Reviews</h2>
                </div>
                <div class="space-y-4">
                    @foreach($submission->reviews as $review)
                        <div class="bg-[#F7F9FC] border-2 border-gray-200 rounded-xl p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="font-bold text-lg text-[#0F1B4C]">
                                        <i class="fas fa-user-circle mr-2 text-gray-400"></i>
                                        {{ $review->reviewer->full_name ?? 'Anonymous Reviewer' }}
                                    </h3>
                                </div>
                                <span class="px-3 py-1 rounded-lg text-xs font-semibold
                                    {{ $review->status === 'submitted' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($review->status) }}
                                </span>
                            </div>
                            @if($review->recommendation)
                                <div class="mb-3">
                                    <span class="px-4 py-2 bg-blue-100 text-blue-800 rounded-lg font-semibold text-sm">
                                        <i class="fas fa-gavel mr-2"></i>
                                        Recommendation: {{ ucfirst(str_replace('_', ' ', $review->recommendation)) }}
                                    </span>
                                </div>
                            @endif
                            @if($review->comments_for_author)
                                <div class="mt-4 p-4 bg-white rounded-lg border border-gray-200">
                                    <p class="text-sm font-semibold text-gray-700 mb-2">Comments:</p>
                                    <p class="text-gray-700 whitespace-pre-line">{{ $review->comments_for_author }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Activity Log -->
            <div class="bg-white rounded-xl shadow-lg border-2 border-gray-100 p-6">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-history text-indigo-600"></i>
                    </div>
                    <h2 class="text-xl font-bold text-[#0F1B4C]">Activity Log</h2>
                </div>
                <div class="space-y-4">
                    @forelse($submission->logs as $log)
                        <div class="relative pl-6 border-l-2 border-[#0056FF]">
                            <div class="absolute -left-2 top-0 w-4 h-4 bg-[#0056FF] rounded-full border-2 border-white"></div>
                            <div class="bg-[#F7F9FC] rounded-lg p-4">
                                <p class="font-semibold text-[#0F1B4C] mb-1">
                                    <i class="fas fa-circle text-xs mr-2 text-[#0056FF]"></i>
                                    {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                                </p>
                                @if($log->user)
                                    <p class="text-sm text-gray-600 mb-1">
                                        <i class="fas fa-user mr-1"></i>{{ $log->user->full_name }}
                                    </p>
                                @endif
                                <p class="text-xs text-gray-500 mb-2">
                                    <i class="fas fa-clock mr-1"></i>{{ $log->created_at->format('M d, Y H:i') }}
                                </p>
                                @if($log->message)
                                    <p class="text-sm text-gray-700 mt-2 bg-white p-2 rounded border border-gray-200">
                                        {{ $log->message }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-4">No activity yet</p>
                    @endforelse
                </div>
            </div>

            <!-- Quick Actions -->
            @if($submission->status === 'revision_requested')
            <div class="bg-yellow-50 rounded-xl shadow-lg border-2 border-yellow-200 p-6 mb-6">
                <h3 class="font-bold text-[#0F1B4C] mb-4 flex items-center">
                    <i class="fas fa-exclamation-triangle text-yellow-600 mr-2"></i>
                    Action Required
                </h3>
                <p class="text-sm text-gray-700 mb-4">Your submission requires revisions. Please upload the revised files.</p>
                <a href="{{ route('author.submissions.edit', $submission) }}" 
                   class="block w-full text-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg font-semibold transition-colors">
                    <i class="fas fa-upload mr-2"></i>Upload Revision
                </a>
            </div>
            @endif

            <!-- Withdrawal Option -->
            @if(!in_array($submission->status, ['published', 'rejected', 'withdrawn']))
            <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6 mb-6">
                <h3 class="font-bold text-[#0F1B4C] mb-4 flex items-center">
                    <i class="fas fa-undo text-gray-600 mr-2"></i>
                    Withdraw Submission
                </h3>
                <p class="text-sm text-gray-700 mb-4">If you need to withdraw this submission, please provide a reason below.</p>
                <button type="button" 
                        onclick="document.getElementById('withdraw-modal').classList.remove('hidden')"
                        class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-semibold transition-colors">
                    <i class="fas fa-undo mr-2"></i>Withdraw Submission
                </button>
            </div>

            <!-- Withdrawal Modal -->
            <div id="withdraw-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Withdraw Submission</h3>
                    <p class="text-sm text-gray-600 mb-4">Are you sure you want to withdraw this submission? Please provide a reason.</p>
                    <form method="POST" action="{{ route('author.submissions.withdraw', $submission) }}">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Reason for Withdrawal <span class="text-red-500">*</span></label>
                            <textarea name="withdrawal_reason" rows="4" required 
                                      class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-gray-500" 
                                      placeholder="Please provide a reason for withdrawing this submission..."></textarea>
                        </div>
                        <div class="flex gap-3">
                            <button type="button" 
                                    onclick="document.getElementById('withdraw-modal').classList.add('hidden')"
                                    class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg">Cancel</button>
                            <button type="submit" 
                                    onclick="return confirm('Are you sure you want to withdraw this submission? This action cannot be undone.')"
                                    class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">Withdraw</button>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            <!-- Copyedit Approval Section -->
            @if($submission->status === 'accepted' && $submission->current_stage === 'copyediting')
            <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6 mb-6">
                <h2 class="text-2xl font-bold text-[#0F1B4C] mb-4 flex items-center">
                    <i class="fas fa-spell-check text-[#0056FF] mr-3"></i>Copyedit Approval
                </h2>
                
                @php
                    $copyeditedFiles = $submission->files->where('file_type', 'copyedited_manuscript');
                @endphp

                @if($copyeditedFiles->count() > 0)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Copyedited Files</h3>
                        <div class="space-y-3">
                            @foreach($copyeditedFiles as $file)
                                <div class="flex items-center justify-between border-2 border-gray-200 rounded-lg p-4">
                                    <div class="flex items-center">
                                        <i class="fas fa-file-pdf text-red-600 text-2xl mr-4"></i>
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $file->original_name }}</p>
                                            <p class="text-sm text-gray-500">{{ number_format($file->file_size / 1024, 2) }} KB</p>
                                        </div>
                                    </div>
                                    <a href="{{ Storage::url($file->file_path) }}" target="_blank" 
                                       class="px-4 py-2 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors">
                                        <i class="fas fa-download mr-2"></i>Download
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @if($submission->copyedit_approval_status === 'pending' || $submission->copyedit_approval_status === null)
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg mb-4">
                            <p class="text-sm text-blue-800">
                                <i class="fas fa-info-circle mr-2"></i>
                                Please review the copyedited files and either approve them or request changes.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <form method="POST" action="{{ route('author.submissions.copyedit.approve', $submission) }}" class="flex-1">
                                @csrf
                                <button type="submit" 
                                        class="w-full px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition-colors">
                                    <i class="fas fa-check-circle mr-2"></i>Approve Copyedited Files
                                </button>
                            </form>

                            <button type="button" 
                                    onclick="document.getElementById('request-changes-modal').classList.remove('hidden')"
                                    class="w-full px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white rounded-lg font-semibold transition-colors">
                                <i class="fas fa-edit mr-2"></i>Request Changes
                            </button>
                        </div>

                        <!-- Request Changes Modal -->
                        <div id="request-changes-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                            <div class="bg-white rounded-xl p-6 max-w-2xl w-full mx-4">
                                <h3 class="text-xl font-bold text-[#0F1B4C] mb-4">Request Changes to Copyedited Files</h3>
                                <form method="POST" action="{{ route('author.submissions.copyedit.request-changes', $submission) }}">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Comments <span class="text-red-500">*</span>
                                        </label>
                                        <textarea name="comments" rows="6" required
                                                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]"
                                                  placeholder="Please specify what changes you need in the copyedited files..."></textarea>
                                    </div>
                                    <div class="flex gap-4">
                                        <button type="button" 
                                                onclick="document.getElementById('request-changes-modal').classList.add('hidden')"
                                                class="flex-1 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg font-semibold transition-colors">
                                            Cancel
                                        </button>
                                        <button type="submit" 
                                                class="flex-1 px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg font-semibold transition-colors">
                                            Submit Request
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @elseif($submission->copyedit_approval_status === 'approved')
                        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                            <p class="text-sm text-green-800">
                                <i class="fas fa-check-circle mr-2"></i>
                                You have approved the copyedited files. Waiting for editor final approval.
                            </p>
                        </div>
                    @elseif($submission->copyedit_approval_status === 'changes_requested')
                        <div class="bg-orange-50 border-l-4 border-orange-500 p-4 rounded-lg">
                            <p class="text-sm text-orange-800 mb-2">
                                <i class="fas fa-info-circle mr-2"></i>
                                You have requested changes to the copyedited files.
                            </p>
                            @if($submission->copyedit_author_comments)
                                <p class="text-sm text-gray-700 mt-2">
                                    <strong>Your Comments:</strong> {{ $submission->copyedit_author_comments }}
                                </p>
                            @endif
                        </div>
                    @endif
                @else
                    <div class="bg-gray-50 border-l-4 border-gray-400 p-4 rounded-lg">
                        <p class="text-sm text-gray-700">
                            <i class="fas fa-clock mr-2"></i>
                            Copyedited files are not yet available. The copyeditor is working on your submission.
                        </p>
                    </div>
                @endif
            </div>
            @endif

            <!-- Galley Approval Section -->
            @if($submission->status === 'accepted' && ($submission->current_stage === 'proofreading' || $submission->current_stage === 'production'))
            <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6 mb-6">
                <h2 class="text-2xl font-bold text-[#0F1B4C] mb-4 flex items-center">
                    <i class="fas fa-file-alt text-[#0056FF] mr-3"></i>Galley Approval
                </h2>
                
                @php
                    $galleys = $submission->galleys;
                @endphp

                @if($galleys->count() > 0)
                    <div class="space-y-4 mb-6">
                        @foreach($galleys as $galley)
                            <div class="border-2 border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center">
                                        <i class="fas fa-file-{{ $galley->type === 'pdf' ? 'pdf' : ($galley->type === 'html' ? 'code' : 'file-code') }} text-{{ $galley->type === 'pdf' ? 'red' : ($galley->type === 'html' ? 'blue' : 'green') }}-600 text-2xl mr-4"></i>
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $galley->label ?? strtoupper($galley->type) }}</p>
                                            <p class="text-sm text-gray-500">{{ $galley->original_name }} • {{ number_format($galley->file_size / 1024, 2) }} KB</p>
                                        </div>
                                    </div>
                                    <div>
                                        @if($galley->approval_status === 'approved')
                                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-lg text-sm font-semibold">
                                                <i class="fas fa-check-circle mr-1"></i>Approved
                                            </span>
                                        @elseif($galley->approval_status === 'changes_requested')
                                            <span class="px-3 py-1 bg-orange-100 text-orange-800 rounded-lg text-sm font-semibold">
                                                <i class="fas fa-edit mr-1"></i>Changes Requested
                                            </span>
                                        @else
                                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-lg text-sm font-semibold">
                                                <i class="fas fa-clock mr-1"></i>Pending
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="flex gap-3 mb-3">
                                    <a href="{{ Storage::url($galley->file_path) }}" target="_blank" 
                                       class="px-4 py-2 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors text-sm">
                                        <i class="fas fa-download mr-2"></i>Download
                                    </a>
                                </div>

                                @if($galley->approval_status === 'pending')
                                    <div class="flex gap-3">
                                        <form method="POST" action="{{ route('production.galleys.approve', $galley) }}" class="flex-1">
                                            @csrf
                                            <button type="submit" 
                                                    class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition-colors text-sm">
                                                <i class="fas fa-check-circle mr-2"></i>Approve
                                            </button>
                                        </form>
                                        <button type="button" 
                                                onclick="document.getElementById('galley-changes-{{ $galley->id }}').classList.remove('hidden')"
                                                class="flex-1 px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg font-semibold transition-colors text-sm">
                                            <i class="fas fa-edit mr-2"></i>Request Changes
                                        </button>
                                    </div>

                                    <!-- Request Changes Modal -->
                                    <div id="galley-changes-{{ $galley->id }}" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                                        <div class="bg-white rounded-xl p-6 max-w-2xl w-full mx-4">
                                            <h3 class="text-xl font-bold text-[#0F1B4C] mb-4">Request Changes to {{ $galley->label ?? strtoupper($galley->type) }} Galley</h3>
                                            <form method="POST" action="{{ route('production.galleys.request-changes', $galley) }}">
                                                @csrf
                                                <div class="mb-4">
                                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                        Comments <span class="text-red-500">*</span>
                                                    </label>
                                                    <textarea name="comments" rows="6" required
                                                              class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]"
                                                              placeholder="Please specify what changes you need..."></textarea>
                                                </div>
                                                <div class="flex gap-4">
                                                    <button type="button" 
                                                            onclick="document.getElementById('galley-changes-{{ $galley->id }}').classList.add('hidden')"
                                                            class="flex-1 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg font-semibold transition-colors">
                                                        Cancel
                                                    </button>
                                                    <button type="submit" 
                                                            class="flex-1 px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg font-semibold transition-colors">
                                                        Submit Request
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @elseif($galley->approval_status === 'changes_requested' && $galley->author_comments)
                                    <div class="bg-orange-50 border-l-4 border-orange-500 p-3 rounded-lg mt-3">
                                        <p class="text-sm text-gray-700">
                                            <strong>Your Comments:</strong> {{ $galley->author_comments }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-gray-50 border-l-4 border-gray-400 p-4 rounded-lg">
                        <p class="text-sm text-gray-700">
                            <i class="fas fa-clock mr-2"></i>
                            Galleys are not yet available. The production team is working on your submission.
                        </p>
                    </div>
                @endif
            </div>
            @endif

            <!-- Discussion Threads Section -->
            <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-2xl font-bold text-[#0F1B4C] flex items-center">
                        <i class="fas fa-comments text-[#0056FF] mr-3"></i>Discussion Threads
                    </h2>
                    <button type="button" 
                            onclick="document.getElementById('new-thread-modal').classList.remove('hidden')"
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
                                        <h3 class="text-lg font-semibold text-[#0F1B4C] mb-1">{{ $thread->title }}</h3>
                                        @if($thread->description)
                                            <p class="text-sm text-gray-600 mb-2">{{ $thread->description }}</p>
                                        @endif
                                        <p class="text-xs text-gray-500">
                                            <i class="fas fa-comments mr-1"></i>{{ $thread->comments->count() }} comments
                                            <span class="mx-2">•</span>
                                            <i class="fas fa-clock mr-1"></i>{{ $thread->created_at->format('M d, Y') }}
                                        </p>
                                    </div>
                                    @if($thread->is_locked)
                                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded-lg text-sm font-semibold">
                                            <i class="fas fa-lock mr-1"></i>Locked
                                        </span>
                                    @endif
                                </div>

                                <!-- Comments -->
                                <div class="space-y-3 mt-4 max-h-96 overflow-y-auto">
                                    @foreach($thread->comments as $comment)
                                        <div class="border-l-4 border-[#0056FF] pl-4 py-2 bg-gray-50 rounded-r-lg">
                                            <div class="flex items-center justify-between mb-1">
                                                <p class="font-semibold text-[#0F1B4C]">{{ $comment->user->full_name }}</p>
                                                <p class="text-xs text-gray-500">{{ $comment->created_at->format('M d, Y H:i') }}</p>
                                            </div>
                                            <p class="text-sm text-gray-700 whitespace-pre-line">{{ $comment->comment }}</p>
                                            @if($comment->is_internal)
                                                <span class="inline-block mt-2 px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">
                                                    Internal Note
                                                </span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Add Comment Form -->
                                @if(!$thread->is_locked)
                                    <form method="POST" action="{{ route('discussions.comments.store', ['submission' => $submission, 'thread' => $thread]) }}" class="mt-4">
                                        @csrf
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
                <div id="new-thread-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                    <div class="bg-white rounded-xl p-6 max-w-2xl w-full mx-4">
                        <h3 class="text-xl font-bold text-[#0F1B4C] mb-4">Create New Discussion Thread</h3>
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
                                        onclick="document.getElementById('new-thread-modal').classList.add('hidden')"
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
</div>
@endsection
