@extends('layouts.admin')

@section('title', 'Sections Management - ' . $journal->name)
@section('page-title', 'Sections Management')
@section('page-subtitle', $journal->name)

@section('content')
    <div class="space-y-8">
        <!-- Header -->
        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <span
                            class="px-3 py-1 bg-cisa-base/10 text-cisa-base text-[10px] font-black uppercase tracking-widest rounded-full border border-cisa-base/20">
                            Editorial Structure
                        </span>
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                        <span class="text-xs font-bold text-slate-400">{{ $journal->name }}</span>
                    </div>
                    <h3 class="text-3xl font-black text-cisa-base tracking-tight">Sections Management</h3>
                    <p class="text-slate-500 mt-2 font-medium">Define manuscript types and assign specialized editorial
                        oversight.</p>
                </div>
                <a href="{{ route('admin.sections.create', $journal) }}"
                    class="inline-flex items-center px-8 py-4 bg-cisa-gradient text-white rounded-2xl font-black text-sm uppercase tracking-widest shadow-xl shadow-cisa-base/20 hover:scale-[1.02] transition-all group">
                    <i class="fas fa-plus-circle mr-3 group-hover:rotate-90 transition-transform"></i>
                    Create New Section
                </a>
            </div>
        </div>

        <!-- Sections List -->
        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-8 border-b border-slate-50 flex items-center justify-between bg-slate-50/50">
                <h2 class="text-xl font-black text-cisa-base tracking-tight flex items-center">
                    <div
                        class="w-8 h-8 bg-cisa-base text-cisa-accent rounded-lg flex items-center justify-center mr-3 shadow-lg shadow-cisa-base/20">
                        <i class="fas fa-layer-group text-xs"></i>
                    </div>
                    Active Journal Sections
                </h2>
                <span
                    class="px-4 py-1 bg-white border border-slate-200 rounded-full text-[10px] font-black uppercase tracking-widest text-slate-500 shadow-sm">
                    {{ $sections->count() }} Total
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead>
                        <tr class="bg-cisa-base">
                            <th
                                class="px-8 py-5 text-left text-[10px] font-black text-cisa-accent uppercase tracking-[0.2em]">
                                Order</th>
                            <th
                                class="px-8 py-5 text-left text-[10px] font-black text-cisa-accent uppercase tracking-[0.2em]">
                                Section Identity</th>
                            <th
                                class="px-8 py-5 text-left text-[10px] font-black text-cisa-accent uppercase tracking-[0.2em]">
                                Editorial Oversight</th>
                            <th
                                class="px-8 py-5 text-left text-[10px] font-black text-cisa-accent uppercase tracking-[0.2em]">
                                Parameters</th>
                            <th
                                class="px-8 py-5 text-left text-[10px] font-black text-cisa-accent uppercase tracking-[0.2em]">
                                Review Policy</th>
                            <th
                                class="px-8 py-5 text-left text-[10px] font-black text-cisa-accent uppercase tracking-[0.2em]">
                                Status</th>
                            <th
                                class="px-8 py-5 text-right text-[10px] font-black text-cisa-accent uppercase tracking-[0.2em]">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-50">
                        @forelse($sections as $section)
                            <tr class="hover:bg-slate-50/50 transition-all group">
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center justify-center w-8 h-8 bg-slate-100 text-slate-600 rounded-lg text-xs font-black border border-slate-200">
                                        {{ $section->order }}
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="text-base font-black text-cisa-base tracking-tight">{{ $section->title }}</div>
                                    @if($section->description)
                                        <div class="text-xs text-slate-400 mt-1 font-medium italic">
                                            {{ Str::limit($section->description, 60) }}</div>
                                    @endif
                                </td>
                                <td class="px-8 py-6">
                                    @if($section->sectionEditor)
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-[10px] font-black text-slate-500 border-2 border-white shadow-sm">
                                                {{ substr($section->sectionEditor->full_name, 0, 2) }}
                                            </div>
                                            <span
                                                class="text-sm font-bold text-slate-700">{{ $section->sectionEditor->full_name }}</span>
                                        </div>
                                    @else
                                        <span class="inline-flex items-center text-xs font-bold text-slate-400 italic">
                                            <i class="fas fa-user-slash mr-2 opacity-50"></i>Unassigned
                                        </span>
                                    @endif
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex flex-col gap-1">
                                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Word
                                            Count</span>
                                        <span class="text-xs font-bold text-slate-700">
                                            @if($section->word_limit_min || $section->word_limit_max)
                                                {{ $section->word_limit_min ?? '0' }} - {{ $section->word_limit_max ?? '∞' }}
                                            @else
                                                Unlimited
                                            @endif
                                        </span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    @php
                                        $reviewThemes = [
                                            'double_blind' => 'bg-indigo-50 text-indigo-700 border-indigo-100',
                                            'single_blind' => 'bg-purple-50 text-purple-700 border-purple-100',
                                            'open' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                        ];
                                        $rTheme = $reviewThemes[$section->review_type] ?? 'bg-slate-50 text-slate-700 border-slate-100';
                                    @endphp
                                    <span
                                        class="px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest border {{ $rTheme }}">
                                        {{ str_replace('_', ' ', $section->review_type) }}
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-2">
                                        <span class="relative flex h-2 w-2">
                                            <span
                                                class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $section->is_active ? 'bg-emerald-400' : 'bg-slate-400' }} opacity-75"></span>
                                            <span
                                                class="relative inline-flex rounded-full h-2 w-2 {{ $section->is_active ? 'bg-emerald-500' : 'bg-slate-500' }}"></span>
                                        </span>
                                        <span
                                            class="text-[10px] font-black uppercase tracking-widest {{ $section->is_active ? 'text-emerald-700' : 'text-slate-500' }}">
                                            {{ $section->is_active ? 'Active' : 'Archived' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div
                                        class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('admin.sections.edit', [$journal, $section]) }}"
                                            class="p-2 bg-slate-100 hover:bg-cisa-base hover:text-white text-slate-600 rounded-lg transition-all shadow-sm">
                                            <i class="fas fa-pen text-xs"></i>
                                        </a>
                                        <form action="{{ route('admin.sections.destroy', [$journal, $section]) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Are you sure you want to delete this section?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 bg-slate-100 hover:bg-red-600 hover:text-white text-slate-600 rounded-lg transition-all shadow-sm">
                                                <i class="fas fa-trash-alt text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-8 py-24 text-center">
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-200 mb-6">
                                            <i class="fas fa-layer-group text-4xl"></i>
                                        </div>
                                        <h3 class="text-xl font-black text-cisa-base tracking-tight mb-2">Initialize Journal
                                            Architecture</h3>
                                        <p class="text-slate-400 max-w-xs mx-auto mb-8 font-medium italic">Your journal
                                            currently has no structured sections. Establish your first section to begin
                                            accepting submissions.</p>
                                        <a href="{{ route('admin.sections.create', $journal) }}"
                                            class="inline-flex items-center px-8 py-4 bg-cisa-base text-cisa-accent rounded-2xl font-black text-sm uppercase tracking-widest hover:scale-105 transition-all shadow-xl shadow-cisa-base/20">
                                            <i class="fas fa-plus-circle mr-3"></i>
                                            Create First Section
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection