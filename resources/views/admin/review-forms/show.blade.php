@extends('layouts.admin')

@section('title', 'Review Form Details - EMANP')
@section('page-title', 'Review Form: ' . $reviewForm->name)
@section('page-subtitle', 'View review form details')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl border-2 border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-xl font-bold text-[#0F1B4C]">{{ $reviewForm->name }}</h3>
                <p class="text-gray-600 mt-1">{{ $reviewForm->description ?? 'No description' }}</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.review-forms.edit', $reviewForm) }}" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors font-semibold">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <a href="{{ route('admin.review-forms.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-semibold">
                    Back
                </a>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <span class="text-sm text-gray-600">Journal:</span>
                <p class="font-semibold text-[#0F1B4C]">{{ $reviewForm->journal->name ?? 'N/A' }}</p>
            </div>
            <div>
                <span class="text-sm text-gray-600">Status:</span>
                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $reviewForm->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                    {{ $reviewForm->is_active ? 'Active' : 'Inactive' }}
                </span>
                @if($reviewForm->is_default)
                <span class="ml-2 px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">
                    Default
                </span>
                @endif
            </div>
        </div>

        <div>
            <h4 class="font-bold text-[#0F1B4C] mb-4">Questions ({{ count($reviewForm->questions ?? []) }})</h4>
            <div class="space-y-3">
                @forelse($reviewForm->questions ?? [] as $index => $question)
                <div class="bg-gray-50 rounded-lg p-4 border-2 border-gray-200">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-2">
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-semibold">
                                    Q{{ $index + 1 }}
                                </span>
                                <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded text-xs font-semibold">
                                    {{ $question['type'] ?? 'text' }}
                                </span>
                                @if($question['required'] ?? false)
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs font-semibold">
                                    Required
                                </span>
                                @endif
                            </div>
                            <p class="font-semibold text-gray-900">{{ $question['question'] ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 text-center py-8">No questions defined</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

