@extends('layouts.admin')

@section('title', 'Create Announcement - CISA')
@section('page-title', 'Create Announcement')
@section('page-subtitle', 'Broadcast a new message to users')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-slate-50 border-b border-gray-100 px-8 py-6">
                <h2 class="text-lg font-bold text-cisa-base flex items-center gap-2">
                    <i class="fas fa-bullhorn text-cisa-accent"></i> New Announcement
                </h2>
                <p class="text-sm text-gray-500 mt-1">Compose and schedule a new notification for your users.</p>
            </div>

            <div class="p-8">
                <form method="POST" action="{{ route('admin.announcements.store') }}">
                    @csrf

                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Message Details</h3>
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Title <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="title" required value="{{ old('title') }}"
                            class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all font-semibold text-cisa-base"
                            placeholder="e.g. Call for Papers: Special Issue on AI">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Announcement Type <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fas fa-tag absolute left-3 top-3.5 text-gray-300"></i>
                                <select name="type" required
                                    class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all appearance-none">
                                    <option value="" disabled selected>Select type...</option>
                                    <option value="general" {{ old('type') == 'general' ? 'selected' : '' }}>General
                                        Announcement</option>
                                    <option value="call_for_papers" {{ old('type') == 'call_for_papers' ? 'selected' : '' }}>
                                        Call for Papers</option>
                                    <option value="new_issue" {{ old('type') == 'new_issue' ? 'selected' : '' }}>New Issue
                                        Release</option>
                                    <option value="maintenance" {{ old('type') == 'maintenance' ? 'selected' : '' }}>System
                                        Maintenance</option>
                                </select>
                                <div
                                    class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-500">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Scope (Journal)</label>
                            <div class="relative">
                                <i class="fas fa-book absolute left-3 top-3.5 text-gray-300"></i>
                                <select name="journal_id"
                                    class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all appearance-none">
                                    <option value="">Platform-Wide (All Journals)</option>
                                    @foreach($journals as $journal)
                                        <option value="{{ $journal->id }}" {{ old('journal_id') == $journal->id ? 'selected' : '' }}>{{ $journal->name }}</option>
                                    @endforeach
                                </select>
                                <div
                                    class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-500">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Content <span
                                class="text-red-500">*</span></label>
                        <textarea name="content" required rows="8"
                            class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all leading-relaxed"
                            placeholder="Type your announcement message here...">{{ old('content') }}</textarea>
                    </div>

                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Publication & Notification
                    </h3>
                    <div
                        class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8 p-6 bg-slate-50 rounded-xl border border-gray-100">
                        <div>
                            <label class="flex items-start gap-3 cursor-pointer group">
                                <div class="relative mt-1">
                                    <input type="checkbox" name="is_published" value="1" class="sr-only peer" {{ old('is_published') ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-cisa-accent/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-cisa-accent">
                                    </div>
                                </div>
                                <div>
                                    <span
                                        class="text-sm font-bold text-gray-700 group-hover:text-cisa-accent transition-colors block">Publish
                                        Immediately</span>
                                    <span class="text-xs text-gray-500">If unchecked, it will be saved as a draft.</span>
                                </div>
                            </label>

                            <div class="mt-4">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Scheduled Publication
                                    (Optional)</label>
                                <input type="datetime-local" name="scheduled_at" value="{{ old('scheduled_at') }}"
                                    class="w-full px-4 py-2 bg-white border border-gray-200 rounded-lg focus:outline-none focus:border-cisa-accent text-sm">
                            </div>
                        </div>

                        <div>
                            <label class="flex items-start gap-3 cursor-pointer group">
                                <div class="relative mt-1">
                                    <input type="checkbox" name="send_email_notification" value="1" class="sr-only peer" {{ old('send_email_notification', true) ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-500/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                </div>
                                <div>
                                    <span
                                        class="text-sm font-bold text-gray-700 group-hover:text-blue-600 transition-colors block">Email
                                        Notification</span>
                                    <span class="text-xs text-gray-500">Send an email blast to all relevant users upon
                                        publication.</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                        <a href="{{ route('admin.announcements.index') }}"
                            class="px-6 py-2.5 font-bold text-gray-600 hover:text-cisa-base hover:bg-gray-100 rounded-lg transition-colors">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-8 py-2.5 bg-cisa-accent hover:bg-amber-600 text-white font-bold rounded-lg shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all">
                            <i class="fas fa-paper-plane mr-2"></i>Create Announcement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection