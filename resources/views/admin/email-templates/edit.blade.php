@extends('layouts.admin')

@section('title', 'Edit Email Template - EMANP')
@section('page-title', 'Edit Email Template')
@section('page-subtitle', $template['name'])

@section('content')
@if(session('success'))
    <div class="bg-green-100 border-2 border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
@endif

<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl border-2 border-gray-200 p-8">
        <div class="mb-6">
            <p class="text-gray-600 mb-4">{{ $template['description'] }}</p>
            
            @if($placeholders)
            <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-4 mb-6">
                <h4 class="font-semibold text-blue-900 mb-2">Available Placeholders:</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    @foreach($placeholders as $placeholder => $description)
                        <div class="flex items-center">
                            <code class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm mr-2">{{ $placeholder }}</code>
                            <span class="text-sm text-blue-700">{{ $description }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <form method="POST" action="{{ route('admin.email-templates.update', $templateKey) }}">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Journal *</label>
                <select name="journal_id" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                    <option value="">-- Select Journal --</option>
                    @foreach($journals as $j)
                        <option value="{{ $j->id }}" {{ old('journal_id', $journal?->id) == $j->id ? 'selected' : '' }}>
                            {{ $j->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email Subject *</label>
                <input type="text" name="subject" required 
                       value="{{ old('subject', $existingTemplate['subject'] ?? '') }}"
                       placeholder="e.g., Submission Received - @{{journal_name}}"
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email Body *</label>
                <textarea name="body" required rows="15"
                          placeholder="Enter email body content. You can use placeholders like @{{author_name}}, @{{submission_title}}, etc."
                          class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF] font-mono text-sm">{{ old('body', $existingTemplate['body'] ?? '') }}</textarea>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.email-templates.index') }}" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-semibold transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors">
                    <i class="fas fa-save mr-2"></i>Save Template
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

