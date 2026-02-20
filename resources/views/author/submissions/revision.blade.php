@extends('layouts.app')

@section('title', 'Upload Revision - ' . $submission->title)

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <a href="{{ route('author.submissions.show', $submission) }}" class="text-primary-600 hover:text-primary-800">
            <i class="fas fa-arrow-left mr-2"></i>Back to Submission
        </a>
    </div>

    <div class="card mb-6">
        <div class="mb-4">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Upload Revision</h1>
            <p class="text-gray-600">{{ $submission->journal->name }}</p>
        </div>
        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-lg">
            <p class="text-sm text-yellow-800">
                <strong>Current Version:</strong> {{ $latestVersion }}
            </p>
            <p class="text-sm text-yellow-800 mt-2">
                <strong>New Version:</strong> {{ $latestVersion + 1 }}
            </p>
        </div>
    </div>

    @if($submission->editor_notes)
    <div class="card mb-6 bg-blue-50 border-l-4 border-blue-500">
        <h2 class="text-xl font-bold text-gray-900 mb-3">Editor's Comments</h2>
        <div class="text-gray-700 whitespace-pre-line">{{ $submission->editor_notes }}</div>
    </div>
    @endif

    <div class="card">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Upload Revised Manuscript</h2>
        
        <form method="POST" action="{{ route('author.submissions.upload-revision', $submission) }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Revised Manuscript File * <span class="text-gray-500">(DOC, DOCX, or PDF)</span>
                </label>
                <input type="file" name="manuscript" required accept=".doc,.docx,.pdf" 
                       class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-primary-500">
                @error('manuscript')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-2">Maximum file size: 10MB</p>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Response to Editor (Optional)
                </label>
                <textarea name="author_comments" rows="5" 
                          class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-primary-500"
                          placeholder="Please describe the changes you made in this revision..."></textarea>
                @error('author_comments')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4">
                <a href="{{ route('author.submissions.show', $submission) }}" 
                   class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-lg text-center transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-3 px-6 rounded-lg transition-colors">
                    <i class="fas fa-upload mr-2"></i>Upload Revision
                </button>
            </div>
        </form>
    </div>

    @if($submission->files->where('file_type', 'manuscript')->count() > 0)
    <div class="card mt-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Previous Versions</h2>
        <div class="space-y-2">
            @foreach($submission->files->where('file_type', 'manuscript')->sortByDesc('version') as $file)
                <div class="flex items-center justify-between border border-gray-200 rounded-lg p-3">
                    <div>
                        <p class="font-medium text-gray-900">Version {{ $file->version }}</p>
                        <p class="text-sm text-gray-500">{{ $file->original_name }}</p>
                        <p class="text-xs text-gray-400">{{ $file->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <a href="{{ Storage::url($file->file_path) }}" target="_blank" 
                       class="btn btn-secondary text-sm">
                        <i class="fas fa-download mr-1"></i>Download
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

