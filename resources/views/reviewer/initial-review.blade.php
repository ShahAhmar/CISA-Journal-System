@extends('layouts.app')

@section('title', 'Review Request - ' . $submission->title)

@section('content')
    <div class="min-h-screen bg-slate-50 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="text-center mb-10">
                <h1 class="text-3xl md:text-4xl font-serif font-bold text-cisa-base mb-3 leading-tight">
                    Review Request
                </h1>
                <p class="text-gray-500 max-w-2xl mx-auto">
                    You have been invited to review a submission for <span
                        class="font-bold text-cisa-base">{{ $submission->journal->name }}</span>.
                    Please check the details below and decide if you can undertake this assignment.
                </p>
            </div>

            @if(session('success'))
                <div class="mb-8 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm flex items-center">
                    <i class="fas fa-check-circle text-green-600 text-xl mr-3"></i>
                    <p class="text-green-800 font-bold">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-8 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm flex items-center">
                    <i class="fas fa-exclamation-circle text-red-600 text-xl mr-3"></i>
                    <p class="text-red-800 font-bold">{{ session('error') }}</p>
                </div>
            @endif

            <!-- Card: Invite Details -->
            <div class="bg-white rounded-xl shadow-lg border-2 border-indigo-50 overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-cisa-base to-slate-800 px-8 py-6 relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 -mt-6 -mr-6 w-32 h-32 bg-cisa-accent opacity-20 rounded-full blur-3xl">
                    </div>
                    <h2 class="text-xl font-serif font-bold text-white relative z-10 flex items-center">
                        <i class="fas fa-file-contract text-cisa-accent mr-3"></i>
                        Article Details
                    </h2>
                </div>

                <div class="p-8 space-y-6">

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Title</label>
                        <h3 class="text-xl font-bold text-cisa-base leading-snug">
                            {{ $submission->title }}
                        </h3>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-xl border border-gray-100">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Abstract</label>
                        <p class="text-gray-600 leading-relaxed text-sm">
                            {{ $submission->abstract }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label
                                class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Keywords</label>
                            <p class="text-cisa-base font-medium">{{ $submission->keywords ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label
                                class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Section</label>
                            <p class="text-cisa-base font-medium">{{ $submission->journalSection->name ?? 'Article' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                        <div class="flex-1">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Due
                                Date</label>
                            @php
                                $due = null;
                                $isOverdue = false;
                                if ($review->due_date) {
                                    try {
                                        $due = $review->due_date instanceof \Carbon\Carbon
                                            ? $review->due_date
                                            : \Carbon\Carbon::parse($review->due_date);
                                        $isOverdue = $due->isPast();
                                    } catch (\Throwable $e) {
                                        $due = null;
                                    }
                                }
                            @endphp
                            <div class="text-lg font-bold text-cisa-base flex items-center">
                                <i class="far fa-calendar-alt mr-2 text-cisa-accent"></i>
                                {{ $due ? $due->format('F d, Y') : 'N/A' }}
                                @if($isOverdue)
                                    <span
                                        class="ml-2 text-xs bg-red-100 text-red-600 px-2 py-0.5 rounded font-bold uppercase">Overdue</span>
                                @endif
                            </div>
                        </div>
                        <div>
                            <button onclick="showSubmissionDetails()"
                                class="text-sm font-bold text-cisa-accent hover:text-cisa-base transition-colors flex items-center">
                                View Full Details <i class="fas fa-chevron-right ml-1 text-xs"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Action Card -->
            <div class="bg-white rounded-xl shadow-xl border border-gray-100 p-8 text-center">
                <h3 class="text-lg font-bold text-cisa-base mb-6">Will you accept this review request?</h3>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <!-- Accept Button -->
                    <form method="POST" action="{{ route('reviewer.review.accept', $review) }}" class="flex-1 max-w-xs">
                        @csrf
                        <button type="submit"
                            onclick="return confirm('Are you sure you want to accept this review request?')"
                            class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-4 px-6 rounded-xl shadow-lg shadow-green-600/20 hover:-translate-y-1 transition-all flex items-center justify-center group">
                            <i class="fas fa-check-circle mr-2 group-hover:scale-110 transition-transform"></i> Accept
                            Request
                        </button>
                    </form>

                    <!-- Decline Button -->
                    <button onclick="showDeclineModal()"
                        class="flex-1 max-w-xs bg-white border-2 border-red-100 hover:border-red-500 text-red-600 hover:text-red-600 font-bold py-4 px-6 rounded-xl hover:bg-red-50 transition-all">
                        <i class="fas fa-times-circle mr-2"></i> Decline Request
                    </button>
                </div>
                <p class="text-xs text-gray-400 mt-4">
                    By accepting, you agree to complete the review by the due date.
                </p>
            </div>

        </div>
    </div>

    <!-- Decline Modal -->
    <div id="declineModal"
        class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 transform transition-all scale-100">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-times text-2xl text-red-500"></i>
                </div>
                <h3 class="text-2xl font-serif font-bold text-cisa-base mb-2">Decline Request</h3>
                <p class="text-gray-500 text-sm">We're sorry you can't join us. Please let us know why.</p>
            </div>

            <form method="POST" action="{{ route('reviewer.review.decline', $review) }}">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-bold text-cisa-base mb-2">Reason (Required)</label>
                    <textarea name="decline_reason" rows="4" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-red-500 focus:ring-0 transition-all resize-none"
                        placeholder="e.g., Conflict of interest, Outside area of expertise, Busy schedule..."></textarea>
                </div>

                <div class="flex gap-3">
                    <button type="button" onclick="hideDeclineModal()"
                        class="flex-1 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold py-3 px-6 rounded-xl transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-red-600/20 transition-colors">
                        Confirm Decline
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Submission Details Modal -->
    <div id="detailsModal"
        class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full p-8 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                <h3 class="text-2xl font-serif font-bold text-cisa-base">Full Submission Details</h3>
                <button onclick="hideSubmissionDetails()"
                    class="w-8 h-8 rounded-full bg-gray-100 text-gray-500 hover:bg-red-50 hover:text-red-500 flex items-center justify-center transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div id="detailsContent" class="space-y-6">
                <div class="text-center py-12">
                    <i class="fas fa-circle-notch fa-spin text-4xl text-cisa-accent mb-4"></i>
                    <p class="text-gray-500 font-medium">Fetching secure data...</p>
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
                    <div class="space-y-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Title</label>
                            <p class="text-lg font-bold text-cisa-base">${data.title}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                             <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Journal</label>
                                <p class="font-medium text-gray-700">${data.journal}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Submitted On</label>
                                <p class="font-medium text-gray-700">${data.submission_date}</p>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Abstract</label>
                            <p class="text-sm text-gray-600 leading-relaxed">${data.abstract}</p>
                        </div>

                         <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Keywords</label>
                            <div class="flex flex-wrap gap-2">
                                ${(data.keywords || '').split(',').map(k => k.trim() ? `<span class="bg-indigo-50 text-cisa-base px-2 py-1 rounded text-xs font-bold">${k.trim()}</span>` : '').join('') || '<span class="text-gray-400 text-sm">N/A</span>'}
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Manuscript Files</label>
                            <div class="space-y-3">
                                ${data.files.map(file => `
                                    <div class="flex items-center justify-between p-3 bg-white border border-gray-200 rounded-lg shadow-sm">
                                        <div class="flex items-center">
                                            <i class="fas fa-file text-gray-400 mr-3"></i>
                                            <span class="text-sm font-bold text-gray-700">${file.name}</span>
                                        </div>
                                        <span class="text-xs font-mono text-gray-400 bg-gray-50 px-2 py-1 rounded">${(file.size / 1024).toFixed(2)} KB</span>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    </div>
                `;
                })
                .catch(error => {
                    document.getElementById('detailsContent').innerHTML = `
                    <div class="text-center py-12">
                         <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-exclamation-triangle text-2xl text-red-500"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Connection Error</h3>
                        <p class="text-gray-500 text-sm mt-1">Unable to load submission details.</p>
                        <button onclick="showSubmissionDetails()" class="mt-4 text-cisa-accent font-bold hover:underline">Try Again</button>
                    </div>
                `;
                });
        }

        function hideSubmissionDetails() {
            document.getElementById('detailsModal').classList.add('hidden');
        }
    </script>
@endsection