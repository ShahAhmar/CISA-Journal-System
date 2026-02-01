@extends('layouts.app')

@section('title', 'Copyediting - ' . $submission->title)

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
                                <a href="{{ route('copyeditor.dashboard') }}"
                                    class="text-sm font-medium text-gray-500 hover:text-cisa-base">Copyeditor Dashboard</a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                                <span class="text-sm font-medium text-cisa-base">Submission #{{ $submission->id }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-serif font-bold text-cisa-base mb-3 leading-tight">
                            {{ $submission->title }}
                        </h1>
                        <div class="flex items-center gap-4 flex-wrap">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-slate-200 text-slate-800">
                                {{ $submission->journal->name }}
                            </span>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-cisa-accent text-white">
                                Stage: Copyediting
                            </span>
                        </div>
                    </div>
                    <!-- Quick Actions / Status -->
                    <div class="flex-shrink-0">
                        <div
                            class="bg-white px-6 py-4 rounded-xl shadow-glass border border-white/20 flex flex-col items-end">
                            <span class="text-xs text-gray-500 uppercase tracking-widest font-bold mb-1">Current
                                Status</span>
                            <span class="text-cisa-base font-serif font-bold text-lg flex items-center">
                                <span class="w-2 h-2 rounded-full bg-green-500 mr-2 animate-pulse"></span>
                                Active
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Left Column: Tasks & Files -->
                <div class="lg:col-span-2 space-y-8">

                    <!-- Guidelines / Instructions -->
                    <div
                        class="bg-gradient-to-r from-cisa-base to-slate-800 rounded-xl p-6 shadow-lg text-white relative overflow-hidden">
                        <div
                            class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-cisa-accent opacity-10 rounded-full blur-3xl">
                        </div>
                        <div class="relative z-10 flex items-start gap-4">
                            <div
                                class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center flex-shrink-0 backdrop-blur-sm border border-white/20">
                                <i class="fas fa-pen-nib text-cisa-accent text-xl"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-serif font-bold mb-2 text-white">Copyediting Instructions</h2>
                                <p class="text-gray-300 text-sm leading-relaxed mb-4">
                                    Please review the manuscript for grammar, style, and clarity according to the journal's
                                    guidelines. Ensure citations and references are formatted correctly before uploading the
                                    revised file.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Files to Edit -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="text-lg font-serif font-bold text-cisa-base flex items-center">
                                <i class="fas fa-file-alt text-cisa-accent mr-3"></i>
                                Original Manuscript
                            </h3>
                            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Source Files</span>
                        </div>
                        <div class="p-6">
                            @if($submission->files->where('file_type', 'manuscript')->count() > 0)
                                <div class="space-y-4">
                                    @foreach($submission->files->where('file_type', 'manuscript') as $file)
                                        <div
                                            class="group flex items-center justify-between p-4 bg-white border border-gray-200 rounded-xl hover:border-cisa-accent hover:shadow-md transition-all">
                                            <div class="flex items-center gap-4">
                                                <div
                                                    class="w-12 h-12 bg-red-50 text-red-600 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                                    <i class="fas fa-file-pdf text-xl"></i>
                                                </div>
                                                <div>
                                                    <h4
                                                        class="font-bold text-cisa-base group-hover:text-cisa-accent transition-colors">
                                                        {{ $file->original_name }}</h4>
                                                    <div class="flex items-center gap-3 text-xs text-gray-500 mt-1">
                                                        <span
                                                            class="bg-gray-100 px-2 py-0.5 rounded text-gray-600 font-medium uppercase tracking-wide">{{ ucfirst(str_replace('_', ' ', $file->file_type)) }}</span>
                                                        <span><i class="fas fa-code-branch mr-1"></i>v{{ $file->version }}</span>
                                                        <span><i
                                                                class="fas fa-weight-hanging mr-1"></i>{{ number_format($file->file_size / 1024, 2) }}
                                                            KB</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="{{ route('submissions.files.download', ['submission' => $submission->id, 'file' => $file->id]) }}"
                                                class="inline-flex items-center px-4 py-2 bg-slate-100 text-cisa-base rounded-lg font-bold text-sm hover:bg-cisa-base hover:text-white transition-all">
                                                <i class="fas fa-download mr-2"></i> Download
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                                    <i class="fas fa-file-slash text-gray-300 text-4xl mb-3"></i>
                                    <p class="text-gray-500 font-medium">No manuscript files available.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Upload Form -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                            <h3 class="text-lg font-serif font-bold text-cisa-base flex items-center">
                                <i class="fas fa-upload text-cisa-accent mr-3"></i>
                                Submit Copyedited Version
                            </h3>
                        </div>
                        <div class="p-6">
                            <form method="POST" action="{{ route('copyeditor.submissions.upload', $submission) }}"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="mb-6">
                                    <label class="block text-sm font-bold text-cisa-base mb-2">
                                        Upload Corrected File <span class="text-red-500">*</span>
                                    </label>
                                    <div
                                        class="relative border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-cisa-accent hover:bg-cisa-accent/5 transition-colors group cursor-pointer">
                                        <input type="file" name="file" required accept=".pdf,.doc,.docx"
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                        <div class="space-y-2">
                                            <i
                                                class="fas fa-cloud-upload-alt text-4xl text-gray-300 group-hover:text-cisa-accent transition-colors"></i>
                                            <p class="text-gray-600 font-medium group-hover:text-cisa-base">
                                                Drag & drop your file here or <span
                                                    class="text-cisa-accent underline">browse</span>
                                            </p>
                                            <p class="text-xs text-gray-400 uppercase tracking-widest">
                                                PDF, DOC, DOCX up to 10MB
                                            </p>
                                        </div>
                                    </div>
                                    @error('file')
                                        <p class="text-red-500 text-sm mt-2 flex items-center"><i
                                                class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-8">
                                    <label class="block text-sm font-bold text-cisa-base mb-2">
                                        Edit Notes (Optional)
                                    </label>
                                    <textarea name="notes" rows="4"
                                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-cisa-accent transition-all resize-none"
                                        placeholder="Describe major changes or queries for the author..."></textarea>
                                </div>

                                <div class="flex items-center gap-4">
                                    <button type="submit"
                                        class="flex-1 bg-cisa-base text-white font-bold py-4 px-8 rounded-xl shadow-lg shadow-cisa-base/20 hover:bg-slate-800 hover:-translate-y-1 transition-all flex items-center justify-center">
                                        <i class="fas fa-check-circle mr-2"></i> Submit Copyedited File
                                    </button>
                                    <a href="{{ route('copyeditor.dashboard') }}"
                                        class="px-8 py-4 bg-white border border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-50 hover:text-cisa-base transition-colors">
                                        Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

                <!-- Right Column: Info & Activity -->
                <div class="lg:col-span-1 space-y-8">

                    <!-- Metadata Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-8">
                        <h3 class="text-lg font-serif font-bold text-cisa-base mb-6 pb-2 border-b border-gray-100">
                            Article Information
                        </h3>

                        <div class="space-y-6">
                            <div>
                                <span
                                    class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Author</span>
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xs">
                                        {{ substr($submission->author->full_name ?? 'A', 0, 1) }}
                                    </div>
                                    <span
                                        class="text-cisa-base font-medium">{{ $submission->author->full_name ?? 'N/A' }}</span>
                                </div>
                            </div>

                            <div>
                                <span
                                    class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Journal</span>
                                <span class="text-cisa-base font-medium block">{{ $submission->journal->name }}</span>
                            </div>

                            <div>
                                <span
                                    class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Abstract</span>
                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                    <p class="text-gray-600 text-sm leading-relaxed italic">
                                        "{{ Str::limit($submission->abstract, 150) }}"
                                    </p>
                                    <button class="text-cisa-accent text-xs font-bold mt-2 hover:underline">Read
                                        logs...</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Activity Log -->
                    @if($submission->logs->count() > 0)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-serif font-bold text-cisa-base mb-6 flex items-center justify-between">
                                <span>Activity History</span>
                                <i class="fas fa-history text-gray-300"></i>
                            </h3>
                            <div
                                class="space-y-6 relative before:absolute before:inset-0 before:ml-2.5 before:-translate-x-px md:before:mx-auto md:before:-translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-200 before:to-transparent">
                                @foreach($submission->logs->sortByDesc('created_at')->take(5) as $log)
                                    <div
                                        class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                                        <div
                                            class="flex items-center justify-center w-5 h-5 rounded-full border border-white bg-slate-200 group-hover:bg-cisa-accent transition-colors shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10 ml-0">
                                        </div>

                                        <div
                                            class="w-[calc(100%-2.5rem)] md:w-[calc(50%-1rem)] p-4 rounded-xl border border-gray-100 bg-white shadow-sm">
                                            <div class="flex items-center justify-between space-x-2 mb-1">
                                                <div class="font-bold text-cisa-base text-xs">
                                                    {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                                                </div>
                                                <time
                                                    class="font-mono text-[10px] text-gray-400 shrink-0">{{ $log->created_at->format('M d') }}</time>
                                            </div>
                                            <div class="text-[11px] text-gray-500">
                                                by <span class="font-medium text-slate-700">{{ $log->user->full_name }}</span>
                                            </div>
                                            @if($log->message)
                                                <p class="text-xs text-gray-600 mt-2 italic bg-gray-50 p-2 rounded">
                                                    {{ Str::limit($log->message, 80) }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection