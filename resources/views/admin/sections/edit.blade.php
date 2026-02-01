@extends('layouts.admin')

@section('title', 'Edit Section - ' . $section->title)
@section('page-title', 'Edit Section')
@section('page-subtitle', $section->title)

@section('content')
    <div class="max-w-4xl mx-auto py-10">
        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <!-- Form Header -->
            <div class="bg-cisa-base p-10 relative overflow-hidden">
                <div class="absolute inset-0 opacity-10"
                    style="background-image: radial-gradient(circle, white 0.5px, transparent 0.5px); background-size: 30px 30px;">
                </div>
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-3">
                        <span
                            class="px-3 py-1 bg-white/10 text-white text-[10px] font-black uppercase tracking-widest rounded-full border border-white/20">
                            Editorial Core
                        </span>
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span>
                        <span class="text-xs font-bold text-slate-300">{{ $section->title }}</span>
                    </div>
                    <h3 class="text-3xl font-black text-white tracking-tight">Refine Section</h3>
                    <p class="text-slate-300 mt-2 font-medium">Modify existing manuscript parameters and editorial
                        assignments.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.sections.update', [$journal, $section]) }}" class="p-10 space-y-8">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Title -->
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">
                            Section Identity <span class="text-cisa-base">*</span>
                        </label>
                        <input type="text" name="title" required value="{{ old('title', $section->title) }}"
                            class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-cisa-base font-bold placeholder:text-slate-300 focus:outline-none focus:border-cisa-base focus:bg-white transition-all shadow-sm">
                        @error('title')
                            <p class="text-red-500 text-[10px] font-black uppercase tracking-wider mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">
                            Scope & Purpose
                        </label>
                        <textarea name="description" rows="4"
                            class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-cisa-base font-bold placeholder:text-slate-300 focus:outline-none focus:border-cisa-base focus:bg-white transition-all shadow-sm">{{ old('description', $section->description) }}</textarea>
                    </div>

                    <!-- Section Editor -->
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">
                            Editorial Oversight
                        </label>
                        <div class="relative">
                            <select name="section_editor_id"
                                class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-cisa-base font-bold focus:outline-none focus:border-cisa-base focus:bg-white transition-all shadow-sm appearance-none">
                                <option value="">Journal Editor (Default)</option>
                                @foreach($editors as $editor)
                                    <option value="{{ $editor->id }}" {{ old('section_editor_id', $section->section_editor_id) == $editor->id ? 'selected' : '' }}>
                                        {{ $editor->full_name }}
                                    </option>
                                @endforeach
                            </select>
                            <div
                                class="absolute inset-y-0 right-0 flex items-center px-6 pointer-events-none text-slate-400">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Review Type -->
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">
                            Review Protocol <span class="text-cisa-base">*</span>
                        </label>
                        <div class="relative">
                            <select name="review_type" required
                                class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-cisa-base font-bold focus:outline-none focus:border-cisa-base focus:bg-white transition-all shadow-sm appearance-none">
                                <option value="double_blind" {{ old('review_type', $section->review_type) === 'double_blind' ? 'selected' : '' }}>Double-Blind Review</option>
                                <option value="single_blind" {{ old('review_type', $section->review_type) === 'single_blind' ? 'selected' : '' }}>Single-Blind Review</option>
                                <option value="open" {{ old('review_type', $section->review_type) === 'open' ? 'selected' : '' }}>Open Review</option>
                            </select>
                            <div
                                class="absolute inset-y-0 right-0 flex items-center px-6 pointer-events-none text-slate-400">
                                <i class="fas fa-microscope text-xs"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Word Limits -->
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">
                            Min word Count
                        </label>
                        <input type="number" name="word_limit_min" min="0"
                            value="{{ old('word_limit_min', $section->word_limit_min) }}"
                            class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-cisa-base font-bold focus:outline-none focus:border-cisa-base focus:bg-white transition-all shadow-sm">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">
                            Max word Count
                        </label>
                        <input type="number" name="word_limit_max" min="0"
                            value="{{ old('word_limit_max', $section->word_limit_max) }}"
                            class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-cisa-base font-bold focus:outline-none focus:border-cisa-base focus:bg-white transition-all shadow-sm">
                    </div>

                    <!-- Order -->
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">
                            Sequence (Order)
                        </label>
                        <input type="number" name="order" min="0" value="{{ old('order', $section->order) }}"
                            class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-cisa-base font-bold focus:outline-none focus:border-cisa-base focus:bg-white transition-all shadow-sm">
                    </div>

                    <!-- Active Status -->
                    <div class="flex items-center pt-8">
                        <label class="relative inline-flex items-center cursor-pointer group">
                            <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $section->is_active) ? 'checked' : '' }}>
                            <div
                                class="w-14 h-7 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-cisa-base">
                            </div>
                            <span
                                class="ml-4 text-[10px] font-black text-slate-400 uppercase tracking-widest group-hover:text-cisa-base transition-colors">Section
                                Active</span>
                        </label>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-col md:flex-row items-center gap-4 pt-10 border-t border-slate-100">
                    <button type="submit"
                        class="w-full md:w-auto px-10 py-4 bg-cisa-gradient text-white rounded-2xl font-black text-sm uppercase tracking-widest shadow-xl shadow-cisa-base/20 hover:scale-[1.02] transition-all">
                        Update Section
                    </button>
                    <a href="{{ route('admin.sections.index', $journal) }}"
                        class="w-full md:w-auto px-10 py-4 bg-slate-100 text-slate-500 rounded-2xl font-black text-sm uppercase tracking-widest text-center hover:bg-slate-200 transition-all">
                        Discard Changes
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection