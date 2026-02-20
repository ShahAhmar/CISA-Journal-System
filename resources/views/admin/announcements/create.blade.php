@extends('layouts.admin')

@section('title', 'Create Announcement - EMANP')
@section('page-title', 'Create Announcement')
@section('page-subtitle', 'Create a new platform announcement')

@section('content')
<div class="max-w-4xl mx-auto">
    @if($errors->any())
        <div class="bg-red-100 border-2 border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-xl border-2 border-gray-200 p-8">
        <form method="POST" action="{{ route('admin.announcements.store') }}">
            @csrf
            
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Title *</label>
                <input type="text" name="title" required 
                       value="{{ old('title') }}"
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]"
                       placeholder="Enter announcement title">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Type *</label>
                    <select name="type" required 
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                        <option value="">-- Select Type --</option>
                        <option value="general" {{ old('type') == 'general' ? 'selected' : '' }}>General</option>
                        <option value="call_for_papers" {{ old('type') == 'call_for_papers' ? 'selected' : '' }}>Call for Papers</option>
                        <option value="new_issue" {{ old('type') == 'new_issue' ? 'selected' : '' }}>New Issue</option>
                        <option value="maintenance" {{ old('type') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Journal (Optional - Leave empty for platform-wide)</label>
                    <select name="journal_id" 
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                        <option value="">-- Platform-Wide Announcement --</option>
                        @foreach($journals as $journal)
                            <option value="{{ $journal->id }}" {{ old('journal_id') == $journal->id ? 'selected' : '' }}>
                                {{ $journal->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Content *</label>
                <textarea name="content" required rows="10"
                          class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]"
                          placeholder="Enter announcement content...">{{ old('content') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Published Date (Optional)</label>
                    <input type="date" name="published_at" 
                           value="{{ old('published_at') }}"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Schedule For (Optional)</label>
                    <input type="datetime-local" name="scheduled_at" 
                           value="{{ old('scheduled_at') }}"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                    <p class="text-xs text-gray-500 mt-1">Schedule announcement for future date/time</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="flex items-center">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}
                               class="w-4 h-4 text-[#0056FF] border-gray-300 rounded focus:ring-[#0056FF]">
                        <span class="text-sm font-semibold text-gray-700">Publish Immediately</span>
                    </label>
                </div>
                <div class="flex items-center">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="send_email_notification" value="1" {{ old('send_email_notification', true) ? 'checked' : '' }}
                               class="w-4 h-4 text-[#0056FF] border-gray-300 rounded focus:ring-[#0056FF]">
                        <span class="text-sm font-semibold text-gray-700">Send Email Notification to All Users</span>
                    </label>
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.announcements.index') }}" 
                   class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-semibold transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors">
                    <i class="fas fa-save mr-2"></i>Create Announcement
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

