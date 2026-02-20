@extends('layouts.admin')

@section('title', 'Journal Pages - EMANP')
@section('page-title', 'Journal Pages Management')
@section('page-subtitle', 'Edit all journal pages like WordPress pages section')

@section('content')
<div class="space-y-6">
    @if(session('success'))
    <div class="bg-green-100 border-2 border-green-500 text-green-800 px-6 py-4 rounded-xl flex items-center justify-between">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-2xl mr-3"></i>
            <span class="font-semibold">{{ session('success') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif
    
    <!-- Journal Selector -->
    <div class="bg-white rounded-xl border-2 border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-[#0F1B4C] mb-2">Select Journal</h3>
                <p class="text-sm text-gray-600">Choose a journal to edit its pages</p>
            </div>
            <form method="GET" action="{{ route('admin.journal-pages.index') }}" class="flex items-center space-x-3">
                <select name="journal" 
                        onchange="this.form.submit()"
                        class="px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF]">
                    <option value="">Select Journal</option>
                    @foreach($journals as $j)
                    <option value="{{ $j->id }}" {{ ($journal && $journal->id === $j->id) ? 'selected' : '' }}>
                        {{ $j->name }}
                    </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>

    @if($journal)
    <!-- Pages Grid -->
    <div class="bg-white rounded-xl border-2 border-gray-200 p-6">
        <div class="mb-6">
            <h3 class="text-xl font-bold text-[#0F1B4C] mb-2">
                <i class="fas fa-book mr-2 text-[#0056FF]"></i>{{ $journal->name }} - Pages
            </h3>
            <p class="text-sm text-gray-600">Click on any page to edit its content</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($pages as $page)
            <a href="{{ route('admin.journal-pages.edit', [$journal, $page['type']]) }}?live=true" 
               class="bg-gradient-to-br from-white to-gray-50 rounded-xl border-2 border-gray-200 hover:border-[#0056FF] p-6 transition-all duration-300 transform hover:scale-105 hover:shadow-xl group">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-[#0056FF] to-[#1D72B8] rounded-xl flex items-center justify-center text-white text-2xl group-hover:scale-110 transition-transform">
                        <i class="{{ $page['icon'] }}"></i>
                    </div>
                    @if($page['has_content'])
                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">
                        <i class="fas fa-check-circle mr-1"></i>Has Content
                    </span>
                    @else
                    <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-semibold">
                        <i class="fas fa-exclamation-circle mr-1"></i>Empty
                    </span>
                    @endif
                </div>
                
                <h4 class="text-lg font-bold text-[#0F1B4C] mb-2 group-hover:text-[#0056FF] transition-colors">
                    {{ $page['name'] }}
                </h4>
                
                <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                    {{ $page['content_preview'] }}
                </p>
                
                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                    <span class="text-xs text-gray-500">
                        <i class="fas fa-clock mr-1"></i>
                        Updated: {{ $page['last_updated']->diffForHumans() }}
                    </span>
                    <span class="text-[#0056FF] font-semibold text-sm group-hover:translate-x-1 transition-transform inline-flex items-center">
                        Edit <i class="fas fa-arrow-right ml-2"></i>
                    </span>
                </div>
            </a>
            @endforeach
        </div>

        <!-- Quick Actions -->
        <div class="mt-8 pt-6 border-t border-gray-200">
            <h4 class="text-lg font-bold text-[#0F1B4C] mb-4">Quick Actions</h4>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.journals.edit', $journal) }}" 
                   class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-semibold transition-colors">
                    <i class="fas fa-cog mr-2"></i>Journal Settings
                </a>
                <a href="{{ route('admin.journal.page-builder.homepage', $journal) }}" 
                   class="px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg font-semibold transition-colors">
                    <i class="fas fa-puzzle-piece mr-2"></i>Homepage Builder
                </a>
                <a href="{{ route('journals.show', $journal) }}" 
                   target="_blank"
                   class="px-4 py-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg font-semibold transition-colors">
                    <i class="fas fa-external-link-alt mr-2"></i>View Journal
                </a>
            </div>
        </div>
    </div>
    @else
    <!-- No Journal Selected -->
    <div class="bg-white rounded-xl border-2 border-gray-200 p-12 text-center">
        <i class="fas fa-book-open text-6xl text-gray-300 mb-4"></i>
        <h3 class="text-2xl font-bold text-gray-700 mb-2">No Journal Selected</h3>
        <p class="text-gray-600 mb-6">Please select a journal from the dropdown above to manage its pages</p>
        <a href="{{ route('admin.journals.create') }}" 
           class="inline-block bg-[#0056FF] hover:bg-[#0044CC] text-white px-6 py-3 rounded-lg font-semibold transition-colors">
            <i class="fas fa-plus mr-2"></i>Create New Journal
        </a>
    </div>
    @endif
</div>
@endsection

