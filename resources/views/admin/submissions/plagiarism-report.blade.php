@extends('layouts.app')

@section('content')
    <div class="bg-slate-50 min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <nav class="flex mb-8" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-4">
                    <li>
                        <div>
                            <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-gray-500">
                                <i class="fas fa-home"></i>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                            <a href="{{ route('editor.submissions.index', $submission->journal->slug) }}"
                                class="text-sm font-medium text-gray-500 hover:text-gray-700">Submissions</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                            <a href="{{ route('editor.submissions.show', [$submission->journal->slug, $submission]) }}"
                                class="text-sm font-medium text-gray-500 hover:text-gray-700">#{{ $submission->id }}</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                            <span class="text-sm font-medium text-cisa-base">Plagiarism Report</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Summary Card -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-cisa-base p-6">
                            <h3 class="text-white font-bold text-lg">Report Summary</h3>
                        </div>
                        <div class="p-6 text-center">
                            <div
                                class="inline-flex items-center justify-center p-8 rounded-full border-8 {{ $report->similarity_percentage > 30 ? 'border-red-100 text-red-600' : ($report->similarity_percentage > 15 ? 'border-amber-100 text-amber-600' : 'border-green-100 text-green-600') }} mb-4">
                                <span class="text-4xl font-black">{{ $report->similarity_percentage }}%</span>
                            </div>
                            <p class="text-sm text-gray-500 uppercase tracking-widest font-bold">Total Similarity</p>
                        </div>
                        <div class="border-t border-gray-100 p-6 space-y-4">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500">Submission ID:</span>
                                <span class="font-bold text-gray-900">#{{ $submission->id }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500">Checked Date:</span>
                                <span class="font-bold text-gray-900">{{ $report->updated_at->format('M d, Y H:i') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Decision Panel -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-gavel text-cisa-accent mr-2"></i>
                            Editorial Decision
                        </h3>
                        <div class="space-y-3">
                            <form
                                action="{{ route('editor.submissions.accept', [$submission->journal->slug, $submission]) }}"
                                method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full py-3 bg-green-600 text-white rounded-xl font-bold hover:bg-green-700 transition-colors shadow-sm">
                                    Accept Submission
                                </button>
                            </form>
                            <form
                                action="{{ route('editor.submissions.request-revision', [$submission->journal->slug, $submission]) }}"
                                method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full py-3 bg-amber-500 text-white rounded-xl font-bold hover:bg-amber-600 transition-colors shadow-sm">
                                    Request Revision
                                </button>
                            </form>
                            <form
                                action="{{ route('editor.submissions.reject', [$submission->journal->slug, $submission]) }}"
                                method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full py-3 bg-red-600 text-white rounded-xl font-bold hover:bg-red-700 transition-colors shadow-sm">
                                    Reject Submission
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Matched Sources -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-100 flex items-center justify-between bg-white">
                            <h3 class="font-bold text-gray-900 text-lg">Matched Internal Sources</h3>
                            <span class="px-3 py-1 bg-cisa-base text-white text-xs font-bold rounded-full">
                                {{ count($report->matched_submissions ?? []) }} Matches Found
                            </span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-slate-50 text-left">
                                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                            Matched Article</th>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                            Similarity</th>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($report->matched_submissions ?? [] as $match)
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-bold text-gray-900">#{{ $match['submission_id'] }}
                                                </div>
                                                <div class="text-[10px] text-gray-400 font-bold uppercase mb-1">
                                                    {{ $match['journal_name'] ?? 'Internal Source' }}
                                                </div>
                                                <div class="text-xs text-gray-500 line-clamp-1 truncate mb-2"
                                                    style="max-width: 300px;">{{ $match['title'] }}</div>

                                                @if(!empty($match['evidence']))
                                                    <div class="mt-2 space-y-1">
                                                        <p class="text-[9px] font-bold text-gray-400 uppercase">Matching
                                                            Phrases:</p>
                                                        @foreach($match['evidence'] as $snippet)
                                                            <div
                                                                class="text-[10px] bg-slate-100 text-slate-700 px-2 py-1 rounded border border-slate-200 italic">
                                                                "...{{ $snippet }}..."
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center space-x-2">
                                                    <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden w-24">
                                                        <div class="h-full {{ $match['percentage'] > 30 ? 'bg-red-500' : ($match['percentage'] > 15 ? 'bg-amber-500' : 'bg-green-500') }}"
                                                            style="width: {{ $match['percentage'] }}%"></div>
                                                    </div>
                                                    <span
                                                        class="text-sm font-bold text-gray-700">{{ $match['percentage'] }}%</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <a href="{{ route('editor.submissions.show', [$submission->journal->slug, $match['submission_id']]) }}"
                                                    class="text-cisa-accent hover:text-amber-600 text-sm font-bold"
                                                    target="_blank">
                                                    View Source
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-12 text-center">
                                                <div class="flex flex-col items-center">
                                                    <i class="fas fa-check-circle text-4xl text-green-200 mb-4"></i>
                                                    <p class="text-gray-500 font-medium">No significant internal matches found.
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Highlights Panel -->
                    @if(!empty($report->highlighted_matches))
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mt-8">
                            <div class="p-6 border-b border-gray-100 bg-slate-50">
                                <h3 class="font-bold text-gray-900 text-sm uppercase tracking-widest">
                                    <i class="fas fa-highlighter text-cisa-accent mr-2"></i>
                                    Flagged Similarities
                                </h3>
                            </div>
                            <div class="p-6">
                                <div class="space-y-3">
                                    @foreach($report->highlighted_matches as $match_snippet)
                                        <div
                                            class="p-3 bg-red-50 text-red-900 text-xs rounded-lg border border-red-100 leading-relaxed font-medium">
                                            "{{ $match_snippet }}"
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Guidance Alert -->
                    <div class="mt-8 p-6 bg-slate-900 text-white rounded-2xl border-l-4 border-cisa-accent">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-cisa-accent mt-1 mr-4"></i>
                            <div>
                                <h4 class="font-bold text-white mb-1">Global Database Search</h4>
                                <p class="text-sm text-slate-300 leading-relaxed">
                                    Our system now performs a <strong>system-wide cross-check</strong> against all articles
                                    in our network, not just this journal.
                                    The similarity score is calculated using the <em>Jaccard index</em> of word shingles.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection