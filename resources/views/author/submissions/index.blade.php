@extends('layouts.app')

@section('title', 'My Submissions | CISA Interdisciplinary Journal')

@section('content')
    <!-- Hero Section -->
    <section class="cisa-gradient text-white py-14 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0"
                style="background-image: radial-gradient(circle, white 0.5px, transparent 0.5px); background-size: 30px 30px;">
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h1 class="text-4xl md:text-5xl font-black mb-3 tracking-tight">My Submissions</h1>
                    <p class="text-lg text-slate-300 max-w-xl">Track and manage your scholarly contributions to our various
                        interdisciplinary journals.</p>
                </div>
                <div>
                    <a href="{{ route('journals.index') }}" class="btn-cisa-primary flex items-center justify-center">
                        <i class="fas fa-plus-circle mr-2"></i> New Submission
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Grid -->
    @if($submissions->total() > 0)
        <section class="bg-white border-b border-slate-100 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @php
                        $stats = [
                            ['label' => 'Total Submissions', 'value' => $submissions->total(), 'icon' => 'fa-file-alt', 'color' => 'slate'],
                            ['label' => 'Under Review', 'value' => $submissions->where('status', 'under_review')->count(), 'icon' => 'fa-search', 'color' => 'amber'],
                            ['label' => 'Accepted', 'value' => $submissions->where('status', 'accepted')->count(), 'icon' => 'fa-check-circle', 'color' => 'green'],
                            ['label' => 'Published', 'value' => $submissions->where('status', 'published')->count(), 'icon' => 'fa-book-open', 'color' => 'indigo'],
                        ];
                    @endphp

                    @foreach($stats as $stat)
                        <div
                            class="bg-slate-50 rounded-2xl p-5 border border-slate-100 flex items-center gap-4 transition-all hover:shadow-md hover:border-cisa-accent/20">
                            <div
                                class="w-12 h-12 rounded-xl bg-white shadow-sm flex items-center justify-center text-xl @if($stat['color'] == 'amber') text-cisa-accent @elseif($stat['color'] == 'slate') text-cisa-base @else text-{{ $stat['color'] }}-600 @endif border border-slate-100">
                                <i class="fas {{ $stat['icon'] }}"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-black text-cisa-base leading-none">{{ $stat['value'] }}</h3>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500 mt-1">{{ $stat['label'] }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Main Content Area -->
    <section class="bg-slate-50/50 py-12 min-h-[500px]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($submissions->total() > 0)
                <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                    <!-- Data Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-slate-900 border-b border-slate-800">
                                    <th class="px-8 py-5 text-xs font-bold text-white uppercase tracking-widest">Manuscript
                                        Details</th>
                                    <th class="px-6 py-5 text-xs font-bold text-white uppercase tracking-widest">Journal</th>
                                    <th class="px-6 py-5 text-xs font-bold text-white uppercase tracking-widest">Status & Stage
                                    </th>
                                    <th class="px-6 py-5 text-xs font-bold text-white uppercase tracking-widest">Dates</th>
                                    <th class="px-8 py-5 text-xs font-bold text-white uppercase tracking-widest text-right">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($submissions as $submission)
                                    <tr class="group hover:bg-slate-50/80 transition-all duration-300">
                                        <td class="px-8 py-6">
                                            <div class="max-w-sm">
                                                <h4
                                                    class="text-sm font-bold text-slate-900 mb-1 group-hover:text-cisa-accent transition-colors">
                                                    {{ Str::limit($submission->title, 70) }}
                                                </h4>
                                                <div class="flex items-center gap-2">
                                                    @if($submission->journalSection)
                                                        <span
                                                            class="text-[10px] bg-slate-100 text-slate-600 px-2 py-0.5 rounded font-bold uppercase">{{ $submission->journalSection->title }}</span>
                                                    @endif
                                                    <span class="text-[10px] text-slate-400 font-medium">ID:
                                                        #{{ str_pad($submission->id, 5, '0', STR_PAD_LEFT) }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-6">
                                            <p class="text-xs font-semibold text-slate-600">{{ strip_tags($submission->journal->name) }}</p>
                                        </td>
                                        <td class="px-6 py-6">
                                            <div class="flex flex-col gap-2">
                                                @php
                                                    $statusThemes = [
                                                        'submitted' => ['color' => 'blue', 'icon' => 'fa-paper-plane'],
                                                        'under_review' => ['color' => 'amber', 'icon' => 'fa-search'],
                                                        'revision_requested' => ['color' => 'orange', 'icon' => 'fa-edit'],
                                                        'accepted' => ['color' => 'emerald', 'icon' => 'fa-check-circle'],
                                                        'rejected' => ['color' => 'red', 'icon' => 'fa-times-circle'],
                                                        'published' => ['color' => 'indigo', 'icon' => 'fa-book-open'],
                                                    ];
                                                    $theme = $statusThemes[$submission->status] ?? ['color' => 'slate', 'icon' => 'fa-circle'];
                                                @endphp
                                                <span
                                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-{{ $theme['color'] }}-50 text-{{ $theme['color'] }}-700 border border-{{ $theme['color'] }}-100 w-fit">
                                                    <i class="fas {{ $theme['icon'] }}"></i>
                                                    {{ str_replace('_', ' ', $submission->status) }}
                                                </span>
                                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest pl-1">
                                                    Stage: {{ str_replace('_', ' ', $submission->current_stage) }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-6">
                                            <div class="text-[11px] text-slate-500 font-medium space-y-1">
                                                <p class="flex items-center gap-1.5">
                                                    <i class="fas fa-calendar-day w-3 opacity-50"></i>
                                                    Sent:
                                                    {{ $submission->formatSubmittedAt('M d, Y') ?? $submission->created_at->format('M d, Y') }}
                                                </p>
                                                @if($submission->published_at)
                                                    <p class="flex items-center gap-1.5 text-cisa-base font-bold">
                                                        <i class="fas fa-certificate w-3"></i>
                                                        Live: {{ $submission->formatPublishedAt('M d, Y') }}
                                                    </p>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-8 py-6 text-right">
                                            <a href="{{ route('author.submissions.show', $submission) }}"
                                                class="inline-flex items-center justify-center h-10 w-10 bg-white border border-slate-200 text-cisa-base rounded-xl hover:bg-cisa-base hover:text-white hover:border-cisa-base transition-all shadow-sm group/btn">
                                                <i
                                                    class="fas fa-arrow-right group-hover/btn:translate-x-0.5 transition-transform"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Area -->
                    @if($submissions->hasPages())
                        <div class="px-8 py-6 bg-slate-50 border-t border-slate-100">
                            {{ $submissions->links() }}
                        </div>
                    @endif
                </div>
            @else
                <!-- Enhanced Empty State -->
                <div
                    class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/40 border border-slate-100 p-16 text-center max-w-4xl mx-auto">
                    <div class="relative w-32 h-32 mx-auto mb-8">
                        <div class="absolute inset-0 bg-cisa-accent/10 rounded-full animate-ping"></div>
                        <div
                            class="relative w-full h-full bg-slate-50 border border-slate-100 rounded-full flex items-center justify-center text-5xl text-slate-300">
                            <i class="fas fa-feather-alt"></i>
                        </div>
                    </div>
                    <h2 class="text-3xl font-black text-cisa-base mb-4">No Submissions Yet</h2>
                    <p class="text-slate-500 text-lg mb-10 max-w-md mx-auto">Your scholarly journey starts here. Submit your
                        manuscript to some of the world's leading interdisciplinary journals.</p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a href="{{ route('journals.index') }}" class="btn-cisa-primary px-10">
                            <i class="fas fa-search-plus mr-2"></i> Browse Journals & Submit
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection