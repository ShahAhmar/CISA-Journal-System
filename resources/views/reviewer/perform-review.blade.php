@extends('layouts.app')

@section('title', 'Perform Review - EMANP')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-xl border-2 border-gray-200 p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Perform Review</h1>
                    <p class="text-gray-600">Review the submission and provide your recommendation.</p>
                </div>
                <div class="bg-blue-100 rounded-full p-4">
                    <i class="fas fa-edit text-3xl text-blue-600"></i>
                </div>
            </div>
            
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                <p class="text-sm text-blue-800">
                    <i class="fas fa-info-circle mr-2"></i>
                    <strong>Double-Blind Review:</strong> Author information is not visible to maintain anonymity.
                </p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                <p class="text-green-800 font-semibold">{{ session('success') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                <ul class="list-disc list-inside text-red-800">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Article Information -->
        <div class="bg-white rounded-2xl shadow-xl border-2 border-gray-200 p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-file-alt text-blue-600 mr-2"></i>Article Information
            </h2>
            
            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Title</label>
                    <p class="text-gray-900">{{ $submission->title }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Abstract</label>
                    <p class="text-gray-700 text-sm leading-relaxed">{{ $submission->abstract }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Journal</label>
                        <p class="text-gray-700">{{ $submission->journal->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Section</label>
                        <p class="text-gray-700">{{ $submission->journalSection->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Keywords</label>
                        <p class="text-gray-700">{{ $submission->keywords ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Review Form -->
        <form method="POST" action="{{ route('reviewer.review.submit', $review) }}" enctype="multipart/form-data" id="reviewForm">
            @csrf

            <!-- Reviewer Guidelines (Optional) -->
            <div class="bg-white rounded-2xl shadow-xl border-2 border-gray-200 p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-book-open text-blue-600 mr-2"></i>Reviewer Guidelines
                </h2>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm text-gray-700 mb-2">
                        Please review the manuscript carefully and provide constructive feedback. Consider:
                    </p>
                    <ul class="list-disc list-inside text-sm text-gray-700 space-y-1">
                        <li>Originality and significance of the research</li>
                        <li>Methodology and data analysis</li>
                        <li>Clarity of presentation and writing quality</li>
                        <li>Appropriateness for the journal's scope</li>
                    </ul>
                </div>
            </div>

            <!-- Manuscript Files -->
            <div class="bg-white rounded-2xl shadow-xl border-2 border-gray-200 p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-download text-blue-600 mr-2"></i>Manuscript Files
                </h2>
                
                @if($submission->files->count() > 0)
                    <div class="space-y-3">
                        @foreach($submission->files as $file)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-file-pdf text-red-600 text-xl"></i>
                                    <div>
                                        <p class="font-semibold text-gray-900">File {{ $file->id }}</p>
                                        <p class="text-xs text-gray-500">{{ ucfirst($file->file_type) }} • {{ number_format($file->file_size / 1024, 2) }} KB</p>
                                    </div>
                                </div>
                                <a href="{{ route('reviewer.file.download', ['review' => $review, 'file' => $file]) }}" 
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition-colors">
                                    <i class="fas fa-download mr-2"></i>Download
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No files available for download.</p>
                @endif
            </div>

            <!-- Review Comments -->
            <div class="bg-white rounded-2xl shadow-xl border-2 border-gray-200 p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-comments text-blue-600 mr-2"></i>Review Comments
                </h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Comments for Editor (Confidential) *
                        </label>
                        <textarea name="comments_for_editor" 
                                  rows="6" 
                                  required
                                  class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                                  placeholder="Provide confidential comments for the editor regarding the manuscript...">{{ old('comments_for_editor', $review->comments_for_editor) }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">These comments will only be visible to editors, not authors.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Comments for Author (Will be shared) *
                        </label>
                        <textarea name="comments_for_author" 
                                  rows="6" 
                                  required
                                  class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                                  placeholder="Provide constructive feedback for the author...">{{ old('comments_for_author', $review->comments_for_author) }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">These comments will be shared with the author.</p>
                    </div>
                </div>
            </div>

            <!-- Annotated File Upload (Optional) -->
            <div class="bg-white rounded-2xl shadow-xl border-2 border-gray-200 p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-upload text-blue-600 mr-2"></i>Annotated File (Optional)
                </h2>
                
                <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded mb-4">
                    <p class="text-sm text-yellow-800">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>Important:</strong> Please remove all personal information (name, affiliation, etc.) from annotated files before uploading.
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Upload Annotated File</label>
                    <input type="file" 
                           name="annotated_file" 
                           accept=".pdf,.doc,.docx"
                           class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-xs text-gray-500 mt-1">Accepted formats: PDF, DOC, DOCX. Max size: 10MB</p>
                </div>

                @if($review->files->where('file_type', 'annotated')->count() > 0)
                    <div class="mt-4">
                        <p class="text-sm font-semibold text-gray-700 mb-2">Previously uploaded files:</p>
                        @foreach($review->files->where('file_type', 'annotated') as $file)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="text-sm text-gray-700">{{ $file->file_name }}</span>
                                <span class="text-xs text-gray-500">{{ number_format($file->file_size / 1024, 2) }} KB</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Recommendation -->
            <div class="bg-white rounded-2xl shadow-xl border-2 border-gray-200 p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-check-circle text-blue-600 mr-2"></i>Recommendation *
                </h2>
                
                <div>
                    <select name="recommendation" 
                            required
                            id="recommendation"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                        <option value="">Select a recommendation...</option>
                        <option value="accept" {{ old('recommendation', $review->recommendation) === 'accept' ? 'selected' : '' }}>Accept</option>
                        <option value="minor_revision" {{ old('recommendation', $review->recommendation) === 'minor_revision' ? 'selected' : '' }}>Minor Revisions Required</option>
                        <option value="major_revision" {{ old('recommendation', $review->recommendation) === 'major_revision' ? 'selected' : '' }}>Major Revisions Required</option>
                        <option value="resubmit" {{ old('recommendation', $review->recommendation) === 'resubmit' ? 'selected' : '' }}>Resubmit for Review</option>
                        <option value="resubmit_elsewhere" {{ old('recommendation', $review->recommendation) === 'resubmit_elsewhere' ? 'selected' : '' }}>Resubmit Elsewhere</option>
                        <option value="decline" {{ old('recommendation', $review->recommendation) === 'decline' ? 'selected' : '' }}>Decline</option>
                        <option value="see_comments" {{ old('recommendation', $review->recommendation) === 'see_comments' ? 'selected' : '' }}>See Comments</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-2">
                        <i class="fas fa-info-circle mr-1"></i>
                        Recommendation is mandatory. Please select one option before submitting.
                    </p>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="bg-white rounded-2xl shadow-xl border-2 border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-clock mr-1"></i>
                            Due Date: <span class="font-semibold {{ $review->due_date && $review->due_date->isPast() ? 'text-red-600' : 'text-gray-900' }}">
                                {{ $review->due_date->format('F d, Y') }}
                            </span>
                        </p>
                    </div>
                    <button type="submit" 
                            onclick="return confirmSubmit()"
                            class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-4 px-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-paper-plane mr-2"></i>Submit Review
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function confirmSubmit() {
    const recommendation = document.getElementById('recommendation').value;
    
    if (!recommendation) {
        alert('Please select a recommendation before submitting.');
        return false;
    }
    
    return confirm('Are you sure you want to submit this review? Once submitted, you cannot make changes.');
}
</script>
@endsection





