@extends('layouts.app')

@section('title', 'Copyediting - ' . $submission->title)

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('copyeditor.dashboard') }}" class="text-[#0056FF] hover:text-[#0044CC] inline-flex items-center mb-4">
                <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-[#0F1B4C] mb-2">{{ $submission->title }}</h1>
                    <p class="text-gray-600">{{ $submission->journal->name }}</p>
                </div>
                <div class="bg-green-100 px-4 py-2 rounded-lg">
                    <span class="text-green-800 font-semibold">Status: Accepted</span>
                </div>
            </div>

            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
                <p class="text-sm text-blue-800">
                    <i class="fas fa-info-circle mr-2"></i>
                    <strong>Note:</strong> Copyediting is only available for accepted articles. Please review the manuscript and upload the copyedited version.
                </p>
            </div>
        </div>

        <!-- Article Information -->
        <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6 mb-6">
            <h2 class="text-xl font-bold text-[#0F1B4C] mb-4 flex items-center">
                <i class="fas fa-file-alt text-[#0056FF] mr-3"></i>Article Information
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Author</label>
                    <p class="text-gray-900">{{ $submission->author->full_name ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Journal</label>
                    <p class="text-gray-900">{{ $submission->journal->name }}</p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Abstract</label>
                    <p class="text-gray-700 leading-relaxed">{{ $submission->abstract }}</p>
                </div>
            </div>
        </div>

        <!-- Current Files -->
        <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6 mb-6">
            <h2 class="text-xl font-bold text-[#0F1B4C] mb-4 flex items-center">
                <i class="fas fa-file-pdf text-[#0056FF] mr-3"></i>Current Manuscript Files
            </h2>
            
            @if($submission->files->where('file_type', 'manuscript')->count() > 0)
                <div class="space-y-3">
                    @foreach($submission->files->where('file_type', 'manuscript') as $file)
                        <div class="flex items-center justify-between border-2 border-gray-200 rounded-lg p-4 hover:border-[#0056FF] transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-file-pdf text-red-600 text-2xl mr-4"></i>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $file->original_name }}</p>
                                    <p class="text-sm text-gray-500">Version {{ $file->version }} • {{ number_format($file->file_size / 1024, 2) }} KB</p>
                                </div>
                            </div>
                            <a href="{{ Storage::url($file->file_path) }}" target="_blank" 
                               class="px-4 py-2 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors">
                                <i class="fas fa-download mr-2"></i>Download
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No files available</p>
            @endif
        </div>

        <!-- Upload Copyedited File -->
        <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6">
            <h2 class="text-xl font-bold text-[#0F1B4C] mb-4 flex items-center">
                <i class="fas fa-upload text-[#0056FF] mr-3"></i>Upload Copyedited File
            </h2>
            
            <form method="POST" action="{{ route('copyeditor.submissions.upload', $submission) }}" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Copyedited Manuscript File * <span class="text-gray-500">(PDF, DOC, or DOCX)</span>
                    </label>
                    <input type="file" name="file" required accept=".pdf,.doc,.docx" 
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                    @error('file')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-sm text-gray-500 mt-2">Maximum file size: 10MB</p>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Notes (Optional)
                    </label>
                    <textarea name="notes" rows="4" 
                              class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]"
                              placeholder="Add any notes about the copyediting changes..."></textarea>
                </div>

                <div class="flex gap-4">
                    <a href="{{ route('copyeditor.dashboard') }}" 
                       class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-lg text-center transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="flex-1 bg-[#0056FF] hover:bg-[#0044CC] text-white font-bold py-3 px-6 rounded-lg transition-colors">
                        <i class="fas fa-upload mr-2"></i>Upload Copyedited File
                    </button>
                </div>
            </form>
        </div>

        <!-- Activity Log -->
        @if($submission->logs->count() > 0)
        <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6 mt-6">
            <h2 class="text-xl font-bold text-[#0F1B4C] mb-4 flex items-center">
                <i class="fas fa-history text-[#0056FF] mr-3"></i>Activity Log
            </h2>
            <div class="space-y-3">
                @foreach($submission->logs->sortByDesc('created_at') as $log)
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
    </div>
</div>
@endsection

