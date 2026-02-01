@extends('layouts.admin')

@section('title', 'Create Issue - CISA')
@section('page-title', 'Create New Issue')
@section('page-subtitle', 'Initialize a new issue for a journal')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-slate-50 border-b border-gray-100 px-8 py-6">
                <h2 class="text-lg font-bold text-cisa-base flex items-center gap-2">
                    <i class="fas fa-layer-group text-cisa-accent"></i> Issue Details
                </h2>
                <p class="text-sm text-gray-500 mt-1">Configure metadata for the new issue.</p>
            </div>

            <div class="p-8">
                <form method="POST" action="{{ route('admin.issues.store') }}">
                    @csrf

                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Journal Association</h3>
                    <div class="mb-8">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Select Journal <span
                                class="text-red-500">*</span></label>
                        <div class="relative">
                            <i class="fas fa-book absolute left-3 top-3.5 text-gray-300"></i>
                            <select name="journal_id" required
                                class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all appearance-none cursor-pointer">
                                <option value="">Choose a journal...</option>
                                @foreach($journals as $journal)
                                    <option value="{{ $journal->id }}" {{ old('journal_id') == $journal->id ? 'selected' : '' }}>
                                        {{ $journal->name }}</option>
                                @endforeach
                            </select>
                            <div
                                class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-500">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>

                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Identification</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Volume <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-400 text-sm font-bold">Vol</span>
                                <input type="number" name="volume" required value="{{ old('volume', 1) }}" min="1"
                                    class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all text-center font-semibold">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Issue No. <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-400 text-sm font-bold">No</span>
                                <input type="number" name="issue_number" required value="{{ old('issue_number', 1) }}"
                                    min="1"
                                    class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all text-center font-semibold">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Year <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fas fa-calendar absolute left-3 top-3.5 text-gray-300"></i>
                                <input type="number" name="year" required value="{{ old('year', date('Y')) }}" min="1900"
                                    max="2100"
                                    class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all text-center font-semibold">
                            </div>
                        </div>
                    </div>

                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Metadata</h3>
                    <div class="space-y-6 mb-8">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Display Title <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="display_title" required value="{{ old('display_title') }}"
                                placeholder="e.g. Special Issue on AI"
                                class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all">
                            <p class="text-xs text-gray-400 mt-1">If blank, standard format (Vol X, No Y) is used.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Description / Editorial Note</label>
                            <textarea name="description" rows="4"
                                class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all placeholder-gray-400"
                                placeholder="Optional description or introduction for this issue...">{{ old('description') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Publication Date</label>
                                <div class="relative">
                                    <i class="fas fa-calendar-day absolute left-3 top-3.5 text-gray-300"></i>
                                    <input type="date" name="published_date"
                                        value="{{ old('published_date', date('Y-m-d')) }}"
                                        class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all">
                                </div>
                            </div>
                            <div class="flex items-center pt-8">
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <div class="relative">
                                        <input type="checkbox" name="is_published" value="1" class="sr-only peer" {{ old('is_published') ? 'checked' : '' }}>
                                        <div
                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-cisa-accent/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-cisa-accent">
                                        </div>
                                    </div>
                                    <span
                                        class="text-sm font-bold text-gray-700 group-hover:text-cisa-accent transition-colors">Publish
                                        Immediately</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                        <a href="{{ route('admin.issues.index') }}"
                            class="px-6 py-2.5 font-bold text-gray-600 hover:text-cisa-base hover:bg-gray-100 rounded-lg transition-colors">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-8 py-2.5 bg-cisa-accent hover:bg-amber-600 text-white font-bold rounded-lg shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all">
                            <i class="fas fa-save mr-2"></i>Create Issue
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection