@extends('layouts.admin')

@section('title', 'Review Forms - EMANP')
@section('page-title', 'Review Forms Management')
@section('page-subtitle', 'Create and manage custom review forms')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl border-2 border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-xl font-bold text-[#0F1B4C]">Review Forms</h3>
                <p class="text-gray-600 mt-1">Manage custom review forms for journals</p>
            </div>
            <a href="{{ route('admin.review-forms.create') }}" 
               class="px-6 py-3 bg-gradient-to-r from-[#0056FF] to-indigo-600 hover:from-[#0044CC] hover:to-indigo-700 text-white rounded-lg font-semibold transition-colors shadow-lg">
                <i class="fas fa-plus mr-2"></i>Create Review Form
            </a>
        </div>
    </div>

    <!-- Review Forms List -->
    <div class="bg-white rounded-xl border-2 border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-[#0056FF] to-[#1D72B8]">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Name</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Journal</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Questions</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($forms as $form)
                    <tr class="hover:bg-blue-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900">{{ $form->name }}</div>
                            @if($form->description)
                            <div class="text-xs text-gray-500">{{ Str::limit($form->description, 50) }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $form->journal->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                                {{ count($form->questions ?? []) }} questions
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $form->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                {{ $form->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            @if($form->is_default)
                            <span class="ml-2 px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">
                                Default
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.review-forms.show', $form) }}" class="text-[#0056FF] hover:text-[#0044CC]">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.review-forms.edit', $form) }}" class="text-green-600 hover:text-green-700">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.review-forms.destroy', $form) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-clipboard-list text-4xl mb-3 text-gray-400"></i>
                            <p>No review forms created yet</p>
                            <a href="{{ route('admin.review-forms.create') }}" class="text-[#0056FF] hover:text-[#0044CC] font-semibold mt-2 inline-block">
                                Create First Review Form
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($forms->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $forms->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

