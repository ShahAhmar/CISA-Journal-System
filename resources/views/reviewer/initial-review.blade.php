@extends('layouts.app')

@section('title', 'Review Request - EMANP')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-xl border-2 border-gray-200 p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Review Request</h1>
                    <p class="text-gray-600">Please review the submission details and accept or decline this review request.</p>
                </div>
                <div class="bg-blue-100 rounded-full p-4">
                    <i class="fas fa-file-alt text-3xl text-blue-600"></i>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                <p class="text-green-800 font-semibold">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                <p class="text-red-800 font-semibold">{{ session('error') }}</p>
            </div>
        @endif

        <!-- Submission Details Card -->
        <div class="bg-white rounded-2xl shadow-xl border-2 border-gray-200 p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-info-circle text-blue-600 mr-2"></i>Article Information
            </h2>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Article Title</label>
                    <p class="text-gray-900 font-medium">{{ $submission->title }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Abstract</label>
                    <p class="text-gray-700 text-sm leading-relaxed">{{ $submission->abstract }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Journal</label>
                        <p class="text-gray-700">{{ $submission->journal->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Section</label>
                        <p class="text-gray-700">{{ $submission->journalSection->name ?? 'N/A' }}</p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Keywords</label>
                    <p class="text-gray-700">{{ $submission->keywords ?? 'N/A' }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Assigned Date</label>
                        <p class="text-gray-700">{{ $review->assigned_date->format('F d, Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Due Date</label>
                        <p class="text-gray-700 font-semibold {{ $review->due_date && $review->due_date->isPast() ? 'text-red-600' : '' }}">
                            {{ $review->due_date->format('F d, Y') }}
                            @if($review->due_date->isPast())
                                <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded ml-2">Overdue</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- View All Submission Details Button -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <button onclick="showSubmissionDetails()" 
                        class="text-blue-600 hover:text-blue-800 font-semibold inline-flex items-center">
                    <i class="fas fa-eye mr-2"></i>View All Submission Details
                </button>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="bg-white rounded-2xl shadow-xl border-2 border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Your Response</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Accept Button -->
                <form method="POST" action="{{ route('reviewer.review.accept', $review) }}" class="flex-1">
                    @csrf
                    <button type="submit" 
                            onclick="return confirm('Are you sure you want to accept this review request?')"
                            class="w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-check-circle mr-2"></i>Accept Review
                    </button>
                </form>

                <!-- Decline Button -->
                <button onclick="showDeclineModal()" 
                        class="w-full bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-times-circle mr-2"></i>Decline Review
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Decline Modal -->
<div id="declineModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
        <h3 class="text-2xl font-bold text-gray-900 mb-4">Decline Review Request</h3>
        <p class="text-gray-600 mb-4">Please provide a reason for declining this review request.</p>
        
        <form method="POST" action="{{ route('reviewer.review.decline', $review) }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Reason for Declining *</label>
                <textarea name="decline_reason" 
                          rows="4" 
                          required
                          class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-red-500 focus:ring-2 focus:ring-red-200"
                          placeholder="e.g., Conflict of interest, Lack of expertise in this area, Time constraints..."></textarea>
            </div>
            
            <div class="flex gap-3">
                <button type="button" 
                        onclick="hideDeclineModal()"
                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-xl transition-colors">
                    Cancel
                </button>
                <button type="submit" 
                        class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-xl transition-colors">
                    Decline Review
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Submission Details Modal -->
<div id="detailsModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full p-6 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-2xl font-bold text-gray-900">Submission Details</h3>
            <button onclick="hideSubmissionDetails()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        
        <div id="detailsContent" class="space-y-4">
            <div class="text-center py-8">
                <i class="fas fa-spinner fa-spin text-3xl text-gray-400"></i>
                <p class="text-gray-500 mt-2">Loading details...</p>
            </div>
        </div>
    </div>
</div>

<script>
function showDeclineModal() {
    document.getElementById('declineModal').classList.remove('hidden');
}

function hideDeclineModal() {
    document.getElementById('declineModal').classList.add('hidden');
}

function showSubmissionDetails() {
    document.getElementById('detailsModal').classList.remove('hidden');
    
    fetch('{{ route("reviewer.review.details", $review) }}')
        .then(response => response.json())
        .then(data => {
            const content = document.getElementById('detailsContent');
            content.innerHTML = `
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Title</label>
                        <p class="text-gray-900">${data.title}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Abstract</label>
                        <p class="text-gray-700 text-sm">${data.abstract}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Keywords</label>
                        <p class="text-gray-700">${data.keywords || 'N/A'}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Journal</label>
                            <p class="text-gray-700">${data.journal}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Submission Date</label>
                            <p class="text-gray-700">${data.submission_date}</p>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Files</label>
                        <div class="space-y-2">
                            ${data.files.map(file => `
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <span class="text-sm text-gray-700">${file.name}</span>
                                    <span class="text-xs text-gray-500">${(file.size / 1024).toFixed(2)} KB</span>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                </div>
            `;
        })
        .catch(error => {
            document.getElementById('detailsContent').innerHTML = `
                <div class="text-center py-8 text-red-600">
                    <i class="fas fa-exclamation-circle text-3xl mb-2"></i>
                    <p>Error loading details. Please try again.</p>
                </div>
            `;
        });
}

function hideSubmissionDetails() {
    document.getElementById('detailsModal').classList.add('hidden');
}
</script>
@endsection





