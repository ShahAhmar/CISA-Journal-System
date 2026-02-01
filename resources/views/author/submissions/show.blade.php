@extends('layouts.app')

@section('title', $submission->title . ' | CISA Interdisciplinary Journal')

@section('content')
    <!-- Hero Section -->
    <section class="cisa-gradient text-white py-14 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0"
                style="background-image: radial-gradient(circle, white 0.5px, transparent 0.5px); background-size: 30px 30px;">
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="mb-8">
                <a href="{{ route('author.submissions.index') }}"
                    class="inline-flex items-center text-slate-300 hover:text-white transition-all group">
                    <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
                    <span class="font-bold text-sm uppercase tracking-widest text-[10px]">Back to Submissions</span>
                </a>
            </div>

            <div class="flex flex-col md:flex-row md:items-end justify-between gap-8">
                <div class="max-w-4xl">
                    <div class="flex items-center gap-3 mb-4">
                        <span
                            class="px-3 py-1 rounded-full bg-white/10 text-white text-[10px] font-black uppercase tracking-wider border border-white/20">
                            Manuscript #{{ str_pad($submission->id, 5, '0', STR_PAD_LEFT) }}
                        </span>
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span>
                        <span class="text-xs font-bold text-slate-300 tracking-wide">{{ $submission->journal->name }}</span>
                    </div>
                    <h1 class="text-3xl md:text-5xl font-black mb-0 tracking-tight leading-tight">{{ $submission->title }}
                    </h1>
                </div>
                <div class="shrink-0">
                    @php
                        $statusThemes = [
                            'submitted' => ['bg' => 'bg-blue-500/10', 'text' => 'text-blue-400', 'border' => 'border-blue-500/30', 'icon' => 'fa-paper-plane'],
                            'under_review' => ['bg' => 'bg-amber-500/10', 'text' => 'text-amber-400', 'border' => 'border-amber-500/30', 'icon' => 'fa-search'],
                            'revision_requested' => ['bg' => 'bg-orange-500/10', 'text' => 'text-orange-400', 'border' => 'border-orange-500/30', 'icon' => 'fa-edit'],
                            'accepted' => ['bg' => 'bg-emerald-500/10', 'text' => 'text-emerald-400', 'border' => 'border-emerald-500/30', 'icon' => 'fa-check-circle'],
                            'rejected' => ['bg' => 'bg-red-500/10', 'text' => 'text-red-400', 'border' => 'border-red-500/30', 'icon' => 'fa-times-circle'],
                            'published' => ['bg' => 'bg-indigo-500/10', 'text' => 'text-indigo-400', 'border' => 'border-indigo-500/30', 'icon' => 'fa-certificate'],
                        ];
                        $theme = $statusThemes[$submission->status] ?? ['bg' => 'bg-slate-500/10', 'text' => 'text-slate-400', 'border' => 'border-slate-500/30', 'icon' => 'fa-info-circle'];
                    @endphp
                    <div
                        class="{{ $theme['bg'] }} {{ $theme['text'] }} {{ $theme['border'] }} border-2 px-6 py-3 rounded-2xl flex items-center gap-3 backdrop-blur-sm shadow-xl">
                        <i class="fas {{ $theme['icon'] }} text-xl"></i>
                        <div>
                            <p class="text-[9px] font-black uppercase tracking-[0.2em] leading-none mb-1 text-white/50">
                                Current Status</p>
                            <p class="text-sm font-black uppercase tracking-widest leading-none">
                                {{ str_replace('_', ' ', $submission->status) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Progress Visualizer -->
    <section class="bg-white border-b border-slate-100 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @php
                $stages = [
                    'submission' => ['label' => 'Submission', 'icon' => 'fa-upload'],
                    'review' => ['label' => 'Review', 'icon' => 'fa-microscope'],
                    'revision' => ['label' => 'Revision', 'icon' => 'fa-pen-fancy'],
                    'copyediting' => ['label' => 'Copyedit', 'icon' => 'fa-spell-check'],
                    'proofreading' => ['label' => 'Proofread', 'icon' => 'fa-file-signature'],
                    'production' => ['label' => 'Production', 'icon' => 'fa-cogs'],
                    'published' => ['label' => 'Published', 'icon' => 'fa-award'],
                ];
                $stageKeys = array_keys($stages);
                $currentIdx = array_search($submission->current_stage, $stageKeys);
                if ($currentIdx === false) {
                    // If current stage not found, default to first stage
                    $currentIdx = 0;
                }
                $progressPct = ($currentIdx / (count($stages) - 1)) * 100;
            @endphp

            <div class="relative pt-4 pb-2">
                <!-- Background Line -->
                <div
                    class="absolute top-[3.25rem] left-0 w-full h-1.5 bg-slate-100 rounded-full overflow-hidden shadow-inner">
                    <div class="h-full bg-gradient-to-r from-cisa-base to-cisa-accent transition-all duration-[1500ms] cubic-bezier(0.4, 0, 0.2, 1)"
                        style="width: {{ $progressPct }}%"></div>
                </div>

                <!-- Steps Container -->
                <div class="relative flex justify-between gap-2">
                    @foreach($stages as $key => $stage)
                        @php
                            $idx = array_search($key, $stageKeys);
                            $isCompleted = $idx < $currentIdx;
                            $isCurrent = $idx === $currentIdx;
                            $isPending = $idx > $currentIdx;
                        @endphp
                        <div class="flex flex-col items-center group relative z-10 w-24">
                            <div class="relative">
                                <div
                                    class="w-14 h-14 rounded-2xl flex items-center justify-center transition-all duration-500 border-2 
                                                                                                @if($isCurrent) bg-cisa-base text-cisa-accent border-cisa-accent shadow-lg shadow-cisa-base/20 scale-110 
                                                                                                @elseif($isCompleted) bg-emerald-50 text-emerald-600 border-emerald-200 
                                                                                                @else bg-white text-slate-300 border-slate-100 @endif">

                                    @if($isCompleted)
                                        <i class="fas fa-check text-lg"></i>
                                    @else
                                        <i class="fas {{ $stage['icon'] }} text-lg"></i>
                                    @endif

                                    @if($isCurrent)
                                        <span class="absolute -top-1.5 -right-1.5 flex h-4 w-4">
                                            <span
                                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cisa-accent opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-4 w-4 bg-cisa-accent"></span>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-4 text-center">
                                <p
                                    class="text-[10px] font-black uppercase tracking-widest leading-tight
                                                                                                @if($isCurrent) text-cisa-base @elseif($isCompleted) text-emerald-700 @else text-slate-400 @endif">
                                    {{ $stage['label'] }}
                                </p>
                                @if($isCurrent)
                                    <div class="h-1 w-6 bg-cisa-accent mx-auto mt-1 rounded-full"></div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Copyedit Approval Status Message -->
                @if($submission->status === 'accepted' && $submission->current_stage === 'copyediting')
                    <div class="mt-8 bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-xl p-6">
                        @php
                            $copyeditedFiles = $submission->files()->where('file_type', 'copyedited_manuscript')->get();
                        @endphp
                        @if($copyeditedFiles->count() > 0)
                            @if($submission->copyedit_approval_status === 'approved')
                                <div class="flex items-start gap-4">
                                    <div
                                        class="w-12 h-12 bg-green-500 text-white rounded-xl flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-check-circle text-xl"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-lg font-bold text-green-900 mb-1">Copyedit Files Approved</h3>
                                        <p class="text-sm text-green-800">You have approved the copyedited files. The editor will now
                                            provide final approval to move to the proofreading stage.</p>
                                    </div>
                                </div>
                            @elseif($submission->copyedit_approval_status === 'changes_requested')
                                <div class="flex items-start gap-4">
                                    <div
                                        class="w-12 h-12 bg-orange-500 text-white rounded-xl flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-edit text-xl"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-lg font-bold text-orange-900 mb-1">Changes Requested</h3>
                                        <p class="text-sm text-orange-800">You have requested changes to the copyedited files. The
                                            copyeditor will review your comments and upload a revised version.</p>
                                    </div>
                                </div>
                            @else
                                <div class="flex items-start gap-4">
                                    <div
                                        class="w-12 h-12 bg-blue-500 text-white rounded-xl flex items-center justify-center flex-shrink-0 animate-pulse">
                                        <i class="fas fa-clock text-xl"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-lg font-bold text-blue-900 mb-1">Action Required: Review Copyedited Files</h3>
                                        <p class="text-sm text-blue-800 mb-3">The copyeditor has uploaded the edited version of your
                                            manuscript. Please review the files below and either approve them or request changes.</p>
                                        <a href="#copyedit-approval"
                                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-colors shadow-md">
                                            <i class="fas fa-arrow-down mr-2"></i>View Copyedited Files
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-12 h-12 bg-gray-400 text-white rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-hourglass-half text-xl"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-gray-900 mb-1">Waiting for Copyeditor</h3>
                                    <p class="text-sm text-gray-700">The copyeditor is currently working on your manuscript. You
                                        will be notified when the copyedited files are ready for your review.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Proofreading Stage Status Message -->
                @if($submission->status === 'accepted' && $submission->current_stage === 'proofreading')
                    <div class="mt-8 bg-gradient-to-r from-purple-50 to-indigo-50 border-2 border-purple-200 rounded-xl p-6">
                        @php
                            $proofreadFiles = $submission->files()->where('file_type', 'proofread_manuscript')->get();
                        @endphp
                        @if($proofreadFiles->count() > 0)
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-12 h-12 bg-purple-500 text-white rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-file-signature text-xl"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-purple-900 mb-1">Proofreading Complete</h3>
                                    <p class="text-sm text-purple-800">The proofreader has uploaded the final manuscript. The editor
                                        is now reviewing it for publication.</p>
                                </div>
                            </div>
                        @else
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-12 h-12 bg-purple-400 text-white rounded-xl flex items-center justify-center flex-shrink-0 animate-pulse">
                                    <i class="fas fa-hourglass-half text-xl"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-purple-900 mb-1">Proofreading in Progress</h3>
                                    <p class="text-sm text-purple-800">Your manuscript is currently with the proofreader for final
                                        review and formatting. You will be notified when this stage is complete.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
                <!-- Payment Status Alert -->
                @if($submission->payment_status === 'awaiting_payment' || ($submission->payment && $submission->payment->status !== 'completed'))
                    @php 
                                                                $payment = $submission->payment ?? \App\Models\Payment::where('submission_id', $submission->id)->first();

                        $alertConfig = [
                            'pending' => [
                                'bg' => 'from-amber-50 to-orange-50 border-amber-200 shadow-amber-100',
                                'icon_bg' => 'bg-amber-500 shadow-amber-200',
                                'title' => 'Action Required: Payment Pending',
                                'text' => 'Your paper has been accepted for publication, but an Article Processing Charge (APC) is required to proceed to the copyediting stage.',
                                'badge' => 'Awaiting Payment'
                            ],
                            'processing' => [
                                'bg' => 'from-blue-50 to-indigo-50 border-blue-200 shadow-blue-100',
                                'icon_bg' => 'bg-blue-500 shadow-blue-200',
                                'title' => 'Status: Payment Under Review',
                                'text' => 'We have received your payment proof. Our editorial team is currently verifying it. This usually takes 24-48 hours.',
                                'badge' => 'Under Review'
                            ],
                            'failed' => [
                                'bg' => 'from-rose-50 to-red-50 border-rose-200 shadow-rose-100',
                                'icon_bg' => 'bg-rose-500 shadow-rose-200',
                                'title' => 'Action Required: Payment Rejected',
                                'text' => $payment->payment_details['notes'] ?? 'Your payment proof was rejected. Please review the comments on the invoice and re-submit.',
                                'badge' => 'Rejected'
                            ]
                        ];

                        $config = $alertConfig[$payment->status] ?? $alertConfig['pending'];
                    @endphp
                    @if($payment)
                        <div class="mt-8 bg-gradient-to-r {{ $config['bg'] }} border-2 rounded-3xl p-8 shadow-xl flex flex-col md:flex-row items-center justify-between gap-6 transition-all hover:scale-[1.01]">
                            <div class="flex items-start gap-6">
                                <div class="w-16 h-16 {{ $config['icon_bg'] }} text-white rounded-2xl flex items-center justify-center flex-shrink-0 @if($payment->status !== 'processing') animate-pulse @endif shadow-lg">
                                    <i class="fas fa-file-invoice-dollar text-3xl"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight mb-1">{{ $config['title'] }}</h3>
                                    <p class="text-sm text-slate-600 font-bold max-w-xl">
                                        {{ $config['text'] }}
                                    </p>
                                    <div class="mt-3 flex items-center gap-3">
                                        <span class="px-3 py-1 bg-white/50 text-slate-700 text-[10px] font-black rounded-lg border border-slate-200 uppercase tracking-widest">
                                            Status: {{ $config['badge'] }}
                                        </span>
                                        <span class="px-3 py-1 bg-white/50 text-slate-700 text-[10px] font-black rounded-lg border border-slate-200 uppercase tracking-widest">
                                            Amount: {{ number_format($payment->amount, 2) }} {{ $payment->currency }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="shrink-0">
                                <a href="{{ route('author.payments.show', $payment) }}" 
                                   class="inline-flex items-center gap-3 px-8 py-4 bg-cisa-base hover:bg-slate-800 text-white font-black text-xs uppercase tracking-[0.2em] rounded-2xl transition-all shadow-2xl shadow-slate-200 group">
                                    <span>View Invoice</span>
                                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                                </a>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Submission Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-lg border-2 border-gray-100 p-6 hover:shadow-xl transition-shadow">
                <div class="flex items-center mb-3">
                    <div
                        class="w-12 h-12 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 group-hover:bg-cisa-base group-hover:text-cisa-accent transition-all">
                        <i class="fas fa-calendar-alt text-xl"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Submitted Date</p>
                        <p class="text-lg font-bold text-cisa-base">
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
                <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-10 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-slate-50 rounded-bl-full -mr-10 -mt-10 opacity-50">
                    </div>

                    <div class="flex items-center gap-4 mb-8 relative z-10">
                        <div
                            class="w-10 h-10 bg-cisa-base text-cisa-accent rounded-lg flex items-center justify-center shadow-lg shadow-cisa-base/20">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <h2 class="text-2xl font-black text-cisa-base tracking-tight">Abstract</h2>
                    </div>

                    <div class="relative z-10">
                        <p class="text-slate-600 text-lg leading-relaxed font-serif italic text-justify">
                            {{ $submission->abstract }}
                        </p>
                    </div>
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
                                <span
                                    class="px-4 py-2 bg-[#F7F9FC] text-[#0F1B4C] rounded-lg font-medium text-sm border border-gray-200">
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
                            <div
                                class="bg-[#F7F9FC] border-2 border-gray-200 rounded-xl p-5 hover:border-[#0056FF] transition-colors">
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
                    <div class="flex items-center gap-4 mb-8">
                        <div
                            class="w-10 h-10 bg-cisa-base text-cisa-accent rounded-lg flex items-center justify-center shadow-lg shadow-cisa-base/20">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <h2 class="text-2xl font-black text-cisa-base tracking-tight">Manuscript Files</h2>
                    </div>
                    <div class="space-y-3">
                        @forelse($submission->files as $file)
                            <div
                                class="flex items-center justify-between bg-[#F7F9FC] border-2 border-gray-200 rounded-xl p-4 hover:border-[#0056FF] transition-all group">
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
                                                <i
                                                    class="fas fa-weight-hanging mr-1"></i>{{ number_format($file->file_size / 1024, 2) }}
                                                KB
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <a href="{{ route('submissions.files.download', [$submission, $file]) }}"
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

                <!-- Copyedit Approval Section -->
                @if($submission->status === 'accepted' && $submission->current_stage === 'copyediting')
                    @php
                        $copyeditedFiles = $submission->files()->where('file_type', 'copyedited_manuscript')->get();
                    @endphp
                    @if($copyeditedFiles->count() > 0)
                        <div id="copyedit-approval" class="bg-white rounded-xl shadow-lg border-2 border-blue-200 p-8">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-12 h-12 bg-blue-500 text-white rounded-xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-spell-check text-xl"></i>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-black text-cisa-base tracking-tight">Copyedit Approval</h2>
                                    <p class="text-sm text-gray-600 mt-1">Review the copyedited files and approve or request changes
                                    </p>
                                </div>
                            </div>

                            <!-- Copyedited Files -->
                            <div class="mb-6">
                                <h3 class="text-lg font-bold text-gray-900 mb-4">Copyedited Files</h3>
                                <div class="space-y-3">
                                    @foreach($copyeditedFiles as $file)
                                        <div
                                            class="flex items-center justify-between bg-blue-50 border-2 border-blue-200 rounded-xl p-4">
                                            <div class="flex items-center flex-1">
                                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                                    <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <p class="font-semibold text-gray-900 mb-1">{{ $file->original_name }}</p>
                                                    <p class="text-sm text-gray-600">
                                                        <i class="fas fa-clock mr-1"></i>Uploaded
                                                        {{ $file->created_at->format('M d, Y') }}
                                                        @if($file->file_size)
                                                            <span class="mx-2">•</span>
                                                            <i
                                                                class="fas fa-weight-hanging mr-1"></i>{{ number_format($file->file_size / 1024, 2) }}
                                                            KB
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                            <a href="{{ route('submissions.files.download', [$submission, $file]) }}"
                                                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-colors shadow-md hover:shadow-lg">
                                                <i class="fas fa-download mr-2"></i>Download
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Status Message -->
                            @if($submission->copyedit_approval_status === 'approved')
                                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg mb-4">
                                    <p class="text-sm text-green-800 font-semibold">
                                        <i class="fas fa-check-circle mr-2"></i>You have approved the copyedited files. The editor will
                                        now proceed with final approval.
                                    </p>
                                </div>
                            @elseif($submission->copyedit_approval_status === 'changes_requested')
                                <div class="bg-orange-50 border-l-4 border-orange-500 p-4 rounded-lg mb-4">
                                    <p class="text-sm text-orange-800 font-semibold">
                                        <i class="fas fa-edit mr-2"></i>You have requested changes to the copyedited files.
                                    </p>
                                    @if($submission->copyedit_author_comments)
                                        <p class="text-sm text-gray-700 mt-2">
                                            <strong>Your Comments:</strong> {{ $submission->copyedit_author_comments }}
                                        </p>
                                    @endif
                                </div>
                            @else
                                <!-- Approval Actions -->
                                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg mb-6">
                                    <p class="text-sm text-blue-800">
                                        <i class="fas fa-info-circle mr-2"></i>Please review the copyedited files and either approve
                                        them or request changes.
                                    </p>
                                </div>

                                <div class="flex gap-4">
                                    <form method="POST" action="{{ route('author.submissions.copyedit.approve', $submission) }}"
                                        class="flex-1">
                                        @csrf
                                        <button type="submit"
                                            class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition-all hover:-translate-y-0.5">
                                            <i class="fas fa-check-circle mr-2"></i>Approve Copyedited Files
                                        </button>
                                    </form>
                                    <button onclick="document.getElementById('request-changes-modal').classList.remove('hidden')"
                                        class="flex-1 bg-orange-600 hover:bg-orange-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition-all hover:-translate-y-0.5">
                                        <i class="fas fa-edit mr-2"></i>Request Changes
                                    </button>
                                </div>
                            @endif
                        </div>

                        <!-- Request Changes Modal -->
                        <div id="request-changes-modal"
                            class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                            <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full p-8">
                                <div class="flex items-center justify-between mb-6">
                                    <h3 class="text-2xl font-bold text-gray-900">Request Changes</h3>
                                    <button onclick="document.getElementById('request-changes-modal').classList.add('hidden')"
                                        class="text-gray-400 hover:text-gray-600 transition-colors">
                                        <i class="fas fa-times text-2xl"></i>
                                    </button>
                                </div>
                                <form method="POST"
                                    action="{{ route('author.submissions.copyedit.request-changes', $submission) }}">
                                    @csrf
                                    <div class="mb-6">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Please describe the changes you would like:
                                        </label>
                                        <textarea name="comments" rows="6" required
                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all"
                                            placeholder="Describe the specific changes you need..."></textarea>
                                    </div>
                                    <div class="flex gap-4">
                                        <button type="button"
                                            onclick="document.getElementById('request-changes-modal').classList.add('hidden')"
                                            class="flex-1 px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition-colors">
                                            Cancel
                                        </button>
                                        <button type="submit"
                                            class="flex-1 bg-orange-600 hover:bg-orange-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition-all">
                                            <i class="fas fa-paper-plane mr-2"></i>Submit Request
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                @endif

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
                                        <span
                                            class="px-3 py-1 rounded-lg text-xs font-semibold
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
                                    @if($review->status === 'declined' && $review->decline_reason)
                                        <div class="mt-4 p-4 bg-red-50 rounded-lg border-2 border-red-200">
                                            <p class="text-sm font-semibold text-red-800 mb-2">
                                                <i class="fas fa-times-circle mr-2"></i>Review Declined - Reason:
                                            </p>
                                            <p class="text-red-700 whitespace-pre-line">{{ $review->decline_reason }}</p>
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

                <!-- Plagiarism Check Service -->
                @php
                    $plagiarismMethod = \App\Models\PaymentMethod::where('journal_id', $submission->journal_id)
                        ->where('service_type', 'plagiarism_check')
                        ->where('is_active', true)
                        ->first();

                    $plagiarismPayment = $submission->payments()
                        ->where('type', 'plagiarism_check')
                        ->where('status', 'completed')
                        ->first();
                @endphp

                @if($plagiarismMethod)
                    <div class="bg-white rounded-xl shadow-lg border-2 border-indigo-100 p-6 mb-6">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-shield-alt text-indigo-600"></i>
                            </div>
                            <h2 class="text-xl font-bold text-[#0F1B4C]">Plagiarism Check</h2>
                        </div>

                        @if($plagiarismPayment)
                             <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                                <div class="flex items-center text-green-700 font-bold mb-2">
                                    <i class="fas fa-check-circle mr-2"></i> Payment Verified
                                </div>
                                <p class="text-xs text-green-600">Your plagiarism check request has been approved. The editorial team will process it shortly.</p>
                             </div>
                        @else
                             <p class="text-sm text-gray-600 mb-4">
                                A specialized plagiarism detection service is available. Payment is required to unlock this feature.
                             </p>
                             <div class="flex items-center justify-between mb-4 bg-slate-50 p-3 rounded-lg">
                                <span class="text-xs font-bold text-slate-500 uppercase">Fee</span>
                                <span class="text-lg font-black text-cisa-base">
                                    {{-- Basic preview, actual logic in controller --}}
                                    Calculated at Checkout
                                </span>
                             </div>
                             <a href="{{ route('payment.show.submission', ['journal' => $submission->journal, 'type' => 'plagiarism_check', 'submission' => $submission]) }}" 
                                class="block w-full text-center px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-bold transition-colors shadow-md transform hover:scale-[1.02]">
                                <i class="fas fa-credit-card mr-2"></i> Pay Now
                             </a>
                        @endif
                    </div>
                @endif

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
                                <div class="absolute -left-2 top-0 w-4 h-4 bg-[#0056FF] rounded-full border-2 border-white">
                                </div>
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
                        <p class="text-sm text-gray-700 mb-4">Your submission requires revisions. Please upload the revised
                            files.</p>
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
                        <p class="text-sm text-gray-700 mb-4">If you need to withdraw this submission, please provide a reason
                            below.</p>
                        <button type="button" onclick="document.getElementById('withdraw-modal').classList.remove('hidden')"
                            class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-semibold transition-colors">
                            <i class="fas fa-undo mr-2"></i>Withdraw Submission
                        </button>
                    </div>

                    <!-- Withdrawal Modal -->
                    <div id="withdraw-modal"
                        class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6">
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Withdraw Submission</h3>
                            <p class="text-sm text-gray-600 mb-4">Are you sure you want to withdraw this submission? Please
                                provide a reason.</p>
                            <form method="POST" action="{{ route('author.submissions.withdraw', $submission) }}">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Reason for Withdrawal <span
                                            class="text-red-500">*</span></label>
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
                                                    <p class="text-sm text-gray-500">{{ number_format($file->file_size / 1024, 2) }} KB
                                                    </p>
                                                </div>
                                            </div>
                                            <a href="{{ route('submissions.files.download', [$submission, $file]) }}"
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
                                    <form method="POST" action="{{ route('author.submissions.copyedit.approve', $submission) }}"
                                        class="flex-1">
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
                                <div id="request-changes-modal"
                                    class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                                    <div class="bg-white rounded-xl p-6 max-w-2xl w-full mx-4">
                                        <h3 class="text-xl font-bold text-[#0F1B4C] mb-4">Request Changes to Copyedited Files</h3>
                                        <form method="POST"
                                            action="{{ route('author.submissions.copyedit.request-changes', $submission) }}">
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
                                                <i
                                                    class="fas fa-file-{{ $galley->type === 'pdf' ? 'pdf' : ($galley->type === 'html' ? 'code' : 'file-code') }} text-{{ $galley->type === 'pdf' ? 'red' : ($galley->type === 'html' ? 'blue' : 'green') }}-600 text-2xl mr-4"></i>
                                                <div>
                                                    <p class="font-semibold text-gray-900">
                                                        {{ $galley->label ?? strtoupper($galley->type) }}
                                                    </p>
                                                    <p class="text-sm text-gray-500">{{ $galley->original_name }} •
                                                        {{ number_format($galley->file_size / 1024, 2) }} KB
                                                    </p>
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
                                                <form method="POST" action="{{ route('production.galleys.approve', $galley) }}"
                                                    class="flex-1">
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
                                            <div id="galley-changes-{{ $galley->id }}"
                                                class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                                                <div class="bg-white rounded-xl p-6 max-w-2xl w-full mx-4">
                                                    <h3 class="text-xl font-bold text-[#0F1B4C] mb-4">Request Changes to
                                                        {{ $galley->label ?? strtoupper($galley->type) }} Galley
                                                    </h3>
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
                                                    <p class="text-xs text-gray-500">{{ $comment->created_at->format('M d, Y H:i') }}
                                                    </p>
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
                                        <form method="POST"
                                            action="{{ route('discussions.comments.store', ['submission' => $submission, 'thread' => $thread]) }}"
                                            class="mt-4">
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
                    <div id="new-thread-modal"
                        class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
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