@extends('layouts.app')

@section('title', 'Perform Review - ' . $submission->title)

@section('content')
    <div class="min-h-screen bg-slate-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header & Breadcrumbs -->
            <div class="mb-8">
                <nav class="flex mb-4" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('dashboard') }}"
                                class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-cisa-base">
                                <i class="fas fa-home mr-2"></i>Dashboard
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                                <span class="text-sm font-medium text-gray-500">Review Assignment</span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-serif font-bold text-cisa-base mb-3 leading-tight">
                            Review Assignment
                        </h1>
                        <div class="flex items-center gap-4 flex-wrap">
                            <span class="text-gray-600 font-medium text-lg">{{ $submission->title }}</span>
                        </div>
                    </div>

                    <!-- Quick Status -->
                    <div class="flex-shrink-0">
                        <div
                            class="bg-white px-6 py-4 rounded-xl shadow-glass border border-white/20 flex flex-col items-end">
                            <span class="text-xs text-gray-500 uppercase tracking-widest font-bold mb-1">Due Date</span>
                            @php
                                // Safely parse due_date
                                $dueDate = null;
                                $isOverdue = false;
                                if ($review->due_date) {
                                    try {
                                        $dueDate = $review->due_date instanceof \Carbon\Carbon
                                            ? $review->due_date
                                            : \Carbon\Carbon::parse($review->due_date);
                                        $isOverdue = $dueDate->isPast();
                                    } catch (\Throwable $e) {
                                        $dueDate = null;
                                        $isOverdue = false;
                                    }
                                }
                            @endphp
                            <span
                                class="font-serif font-bold text-lg flex items-center {{ $isOverdue ? 'text-red-600' : 'text-cisa-base' }}">
                                @if($isOverdue) <i class="fas fa-exclamation-circle mr-2"></i> @else <i
                                class="far fa-calendar-alt mr-2"></i> @endif
                                {{ $dueDate ? $dueDate->format('M d, Y') : 'No Deadline' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-8 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm flex items-center">
                    <i class="fas fa-check-circle text-green-600 text-xl mr-3"></i>
                    <p class="text-green-800 font-bold">{{ session('success') }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-8 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-exclamation-circle text-red-600 text-xl mr-3"></i>
                        <h3 class="text-red-800 font-bold">Please correct the following errors:</h3>
                    </div>
                    <ul class="list-disc list-inside text-red-700 ml-8 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Main Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Left Column: Form & Content -->
                <div class="lg:col-span-2 space-y-8">

                    <!-- Double Blind Notice -->
                    <div
                        class="bg-gradient-to-r from-blue-900 to-cisa-base rounded-xl p-6 shadow-lg text-white relative overflow-hidden">
                        <div class="relative z-10 flex items-start gap-4">
                            <div
                                class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center flex-shrink-0 backdrop-blur-sm border border-white/20">
                                <i class="fas fa-user-secret text-cisa-accent text-lg"></i>
                            </div>
                            <div>
                                <h2 class="font-bold mb-1 text-white">Double-Blind Review Process</h2>
                                <p class="text-blue-100 text-sm leading-relaxed">
                                    To ensure impartiality, author identities are hidden. Please keep your review objective
                                    and free of personal bias.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Guidelines -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-serif font-bold text-cisa-base mb-4 flex items-center">
                            <i class="fas fa-list-check text-cisa-accent mr-3"></i>
                            Review Guidelines
                        </h3>
                        <div
                            class="prose prose-sm text-gray-600 max-w-none bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <p class="mb-2 font-medium">Please evaluate the manuscript based on:</p>
                            <ul class="grid grid-cols-1 md:grid-cols-2 gap-2 list-none pl-0">
                                <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Originality &
                                    Significance</li>
                                <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Methodology &
                                    Rigor</li>
                                <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Clarity &
                                    Presentation</li>
                                <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Relevance to
                                    Scope</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Manuscript Files -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="text-lg font-serif font-bold text-cisa-base flex items-center">
                                <i class="fas fa-file-pdf text-cisa-accent mr-3"></i>
                                Manuscript Files
                            </h3>
                        </div>
                        <div class="p-6">
                            @if($submission->files->count() > 0)
                                <div class="space-y-3">
                                    @foreach($submission->files as $file)
                                        <div
                                            class="flex items-center justify-between p-4 bg-white border border-gray-200 rounded-xl hover:border-cisa-accent hover:shadow-md transition-all group">
                                            <div class="flex items-center gap-4">
                                                <div
                                                    class="w-10 h-10 bg-red-50 text-red-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                                    <i class="fas fa-file-pdf text-lg"></i>
                                                </div>
                                                <div>
                                                    <p class="font-bold text-gray-800 text-sm">Review File #{{ $file->id }}</p>
                                                    <p class="text-xs text-text-gray-500">{{ ucfirst($file->file_type) }} •
                                                        {{ number_format($file->file_size / 1024, 2) }} KB</p>
                                                </div>
                                            </div>
                                            <a href="{{ route('reviewer.file.download', ['review' => $review, 'file' => $file]) }}"
                                                class="text-sm font-bold text-cisa-base hover:text-cisa-accent flex items-center transition-colors">
                                                <i class="fas fa-download mr-2"></i> Download
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 text-center py-4 italic">No files available for review.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Review Form -->
                    <form method="POST" action="{{ route('reviewer.review.submit', $review) }}"
                        enctype="multipart/form-data" id="reviewForm" class="space-y-8">
                        @csrf

                        <!-- Comments Section -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-serif font-bold text-cisa-base mb-6 flex items-center">
                                <i class="fas fa-comment-alt text-cisa-accent mr-3"></i>
                                Your Evaluation
                            </h3>

                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-bold text-cisa-base mb-2">
                                        Confidential Comments to Editor <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="comments_for_editor" rows="6" required
                                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-cisa-accent focus:ring-0 transition-all resize-y"
                                        placeholder="Provide private feedback to the editor (not visible to author)...">{{ old('comments_for_editor', $review->comments_for_editor) }}</textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-cisa-base mb-2">
                                        Comments to Author <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="comments_for_author" rows="8" required
                                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-cisa-accent focus:ring-0 transition-all resize-y"
                                        placeholder="Provide constructive feedback to the author...">{{ old('comments_for_author', $review->comments_for_author) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Upload Annotated File -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-serif font-bold text-cisa-base mb-6 flex items-center">
                                <i class="fas fa-paperclip text-cisa-accent mr-3"></i>
                                Attachments (Optional)
                            </h3>

                            <div class="space-y-4">
                                <label class="block text-sm font-medium text-gray-700">Upload Annotated Manuscript</label>

                                <div class="flex items-center gap-4">
                                    <div class="relative flex-grow">
                                        <input type="file" name="annotated_file" accept=".pdf,.doc,.docx"
                                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-cisa-base file:text-white hover:file:bg-slate-800 transition-all cursor-pointer">
                                    </div>
                                </div>
                                <p class="text-xs text-gray-400">Ensure all personal metadata is removed from the file.</p>

                                @if($review->files->where('file_type', 'annotated')->count() > 0)
                                    <div class="mt-4 bg-gray-50 p-4 rounded-lg border border-gray-100">
                                        <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Previously
                                            Uploaded</p>
                                        @foreach($review->files->where('file_type', 'annotated') as $file)
                                            <div class="flex items-center text-sm text-cisa-base">
                                                <i class="fas fa-paperclip mr-2 text-gray-400"></i>
                                                {{ $file->file_name }} <span
                                                    class="text-gray-400 ml-2">({{ number_format($file->file_size / 1024, 2) }}
                                                    KB)</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Recommendation & Submit -->
                        <div class="bg-white rounded-xl shadow-lg border-2 border-indigo-50 p-8 relative overflow-hidden">
                            <div
                                class="absolute top-0 right-0 w-32 h-32 bg-cisa-accent/5 rounded-full blur-3xl -mr-16 -mt-16">
                            </div>

                            <h3 class="text-xl font-serif font-bold text-cisa-base mb-6">Final Recommendation</h3>

                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-bold text-cisa-base mb-2">Select Decision <span
                                            class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <select name="recommendation" required id="recommendation"
                                            class="w-full px-4 py-4 bg-white border-2 border-gray-200 rounded-xl appearance-none focus:outline-none focus:border-cisa-accent text-gray-700 font-medium cursor-pointer transition-colors">
                                            <option value="">Choose a recommendation...</option>
                                            <option value="accept" {{ old('recommendation', $review->recommendation) === 'accept' ? 'selected' : '' }}>Accept Submission
                                            </option>
                                            <option value="minor_revision" {{ old('recommendation', $review->recommendation) === 'minor_revision' ? 'selected' : '' }}>Revisions
                                                Required (Minor)</option>
                                            <option value="major_revision" {{ old('recommendation', $review->recommendation) === 'major_revision' ? 'selected' : '' }}>Revisions
                                                Required (Major)</option>
                                            <option value="resubmit" {{ old('recommendation', $review->recommendation) === 'resubmit' ? 'selected' : '' }}>Resubmit for
                                                Review</option>
                                            <option value="resubmit_elsewhere" {{ old('recommendation', $review->recommendation) === 'resubmit_elsewhere' ? 'selected' : '' }}>
                                                Resubmit Elsewhere</option>
                                            <option value="decline" {{ old('recommendation', $review->recommendation) === 'decline' ? 'selected' : '' }}>Decline Submission
                                            </option>
                                            <option value="see_comments" {{ old('recommendation', $review->recommendation) === 'see_comments' ? 'selected' : '' }}>See Comments
                                            </option>
                                        </select>
                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" onclick="return confirmSubmit()"
                                    class="w-full bg-cisa-base hover:bg-slate-800 text-white font-bold py-4 px-8 rounded-xl shadow-xl shadow-cisa-base/20 hover:-translate-y-1 transition-all flex items-center justify-center text-lg">
                                    <i class="fas fa-paper-plane mr-3"></i> Submit Review
                                </button>
                            </div>
                        </div>

                    </form>
                </div>

                <!-- Right Column: Sidebar -->
                <div class="lg:col-span-1 space-y-8">

                    <!-- Article Metadata Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-8">
                        <h3 class="text-lg font-serif font-bold text-cisa-base mb-6 pb-2 border-b border-gray-100">
                            About Article
                        </h3>

                        <div class="space-y-6">
                            <div>
                                <span
                                    class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Section</span>
                                <span
                                    class="text-gray-800 font-medium block">{{ $submission->journalSection->name ?? 'Article' }}</span>
                            </div>

                            <div>
                                <span
                                    class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Abstract</span>
                                <div
                                    class="bg-gray-50 p-4 rounded-lg border border-gray-100 max-h-60 overflow-y-auto custom-scrollbar">
                                    <p class="text-gray-600 text-xs leading-relaxed">
                                        {{ $submission->abstract }}
                                    </p>
                                </div>
                            </div>

                            <div>
                                <span
                                    class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Keywords</span>
                                <div class="flex flex-wrap gap-2">
                                    @if($submission->keywords)
                                        @foreach(explode(',', $submission->keywords) as $keyword)
                                            <span
                                                class="px-2 py-1 bg-slate-100 text-slate-600 rounded text-xs font-medium">{{ trim($keyword) }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-gray-400 text-sm">N/A</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmSubmit() {
            const recommendation = document.getElementById('recommendation').value;

            if (!recommendation) {
                alert('Please select a recommendation before submitting.');
                return false;
            }

            return confirm('Are you sure you want to submit this review? The recommendation and comments will be finalized. This action cannot be undone.');
        }
    </script>
@endsection