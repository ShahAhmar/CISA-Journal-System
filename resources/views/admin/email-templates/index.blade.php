@extends('layouts.admin')

@section('title', 'Email Templates - EMANP')
@section('page-title', 'Email Templates')
@section('page-subtitle', 'Manage email templates for automated communications')

@section('content')
@if(session('success'))
    <div class="bg-green-100 border-2 border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
@endif

<div class="mb-6 bg-blue-50 border-2 border-blue-200 rounded-lg p-4">
    <div class="flex items-start">
        <i class="fas fa-info-circle text-blue-600 mr-3 mt-1"></i>
        <div>
            <p class="font-semibold text-blue-900 mb-1">Email Templates</p>
            <p class="text-sm text-blue-800">
                Email templates are journal-specific. Select a journal to edit templates for that journal.
                Templates support placeholders like <code>@{{author_name}}</code>, <code>@{{submission_title}}</code>, etc.
            </p>
        </div>
    </div>
</div>

<!-- Journal Selection -->
@if($journals->count() > 0)
<div class="bg-white rounded-xl border-2 border-gray-200 p-6 mb-6">
    <h3 class="text-lg font-bold text-[#0F1B4C] mb-4">Select Journal</h3>
    <select id="journalSelect" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
        <option value="">-- Select a Journal --</option>
        @foreach($journals as $journal)
            <option value="{{ $journal->id }}">{{ $journal->name }}</option>
        @endforeach
    </select>
</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @foreach($templates as $key => $template)
        <div class="bg-white rounded-xl border-2 border-gray-200 p-6 hover:border-[#0056FF] transition-colors">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-{{ $template['color'] }}-500 rounded-lg flex items-center justify-center">
                    <i class="fas {{ $template['icon'] }} text-white"></i>
                </div>
            </div>
            <h3 class="text-lg font-bold text-[#0F1B4C] mb-2">{{ $template['name'] }}</h3>
            <p class="text-sm text-gray-600 mb-4">{{ $template['description'] }}</p>
            <a href="{{ route('admin.email-templates.edit', $key) }}?journal_id={{ request('journal_id') }}" 
               class="text-[#0056FF] hover:text-[#0044CC] text-sm font-semibold inline-flex items-center">
                Edit Template <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    @endforeach
</div>

<script>
document.getElementById('journalSelect')?.addEventListener('change', function() {
    const journalId = this.value;
    if (journalId) {
        window.location.href = '{{ route("admin.email-templates.index") }}?journal_id=' + journalId;
    } else {
        window.location.href = '{{ route("admin.email-templates.index") }}';
    }
});

// Set selected journal if in URL
const urlParams = new URLSearchParams(window.location.search);
const journalId = urlParams.get('journal_id');
if (journalId) {
    document.getElementById('journalSelect').value = journalId;
}
</script>
@endsection
