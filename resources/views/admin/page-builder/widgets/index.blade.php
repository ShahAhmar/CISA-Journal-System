@extends('layouts.admin')

@section('title', 'Widgets - EMANP')
@section('page-title', 'Widgets')
@section('page-subtitle', 'Manage reusable widgets for your pages')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="bg-white rounded-xl border-2 border-gray-200 p-6 flex justify-between items-center">
        <div>
            <h3 class="text-lg font-bold text-[#0F1B4C]">Widgets Library</h3>
            <p class="text-sm text-gray-600">Total: {{ $widgets->total() }} widgets</p>
        </div>
        <a href="{{ route('admin.page-builder.widgets.create', $journal ?? null) }}" 
           class="bg-[#0056FF] hover:bg-[#0044CC] text-white px-6 py-3 rounded-lg font-semibold transition-colors shadow-lg transform hover:scale-105">
            <i class="fas fa-plus mr-2"></i>Create New Widget
        </a>
    </div>

    <!-- Widgets Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($widgets as $widget)
        <div class="bg-white rounded-xl border-2 border-gray-200 p-6 hover:border-[#0056FF] transition-all transform hover:scale-105">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-[#0056FF] to-[#1D72B8] rounded-lg flex items-center justify-center text-white">
                        <i class="fas fa-cube"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-[#0F1B4C]">{{ $widget->name }}</h4>
                        <p class="text-xs text-gray-500">{{ ucfirst(str_replace('_', ' ', $widget->type)) }}</p>
                    </div>
                </div>
                @if($widget->is_active)
                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">
                    <i class="fas fa-check-circle"></i>
                </span>
                @else
                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-semibold">
                    <i class="fas fa-pause-circle"></i>
                </span>
                @endif
            </div>

            @if($widget->location)
            <div class="mb-3">
                <span class="text-xs text-gray-500">Location:</span>
                <span class="text-xs font-semibold text-[#0056FF] ml-1">{{ ucfirst($widget->location) }}</span>
            </div>
            @endif

            @if($widget->journal)
            <div class="mb-3">
                <span class="text-xs text-gray-500">Journal:</span>
                <span class="text-xs font-semibold text-gray-700 ml-1">{{ $widget->journal->name }}</span>
            </div>
            @else
            <div class="mb-3">
                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">Global Widget</span>
            </div>
            @endif

            <div class="flex items-center justify-end space-x-2 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.page-builder.widgets.edit', $widget) }}" 
                   class="text-blue-600 hover:text-blue-800 p-2 hover:bg-blue-50 rounded-lg transition-colors"
                   title="Edit">
                    <i class="fas fa-edit"></i>
                </a>
                <form action="{{ route('admin.page-builder.widgets.destroy', $widget) }}" 
                      method="POST" 
                      class="inline"
                      onsubmit="return confirm('Are you sure?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="text-red-600 hover:text-red-800 p-2 hover:bg-red-50 rounded-lg transition-colors"
                            title="Delete">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-3 bg-white rounded-xl border-2 border-gray-200 p-12 text-center">
            <i class="fas fa-cubes text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 text-lg font-semibold mb-2">No widgets yet</p>
            <p class="text-gray-400 mb-4">Create your first widget to get started</p>
            <a href="{{ route('admin.page-builder.widgets.create', $journal ?? null) }}" 
               class="inline-block bg-[#0056FF] hover:bg-[#0044CC] text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                <i class="fas fa-plus mr-2"></i>Create First Widget
            </a>
        </div>
        @endforelse
    </div>

    @if($widgets->hasPages())
    <div class="bg-white rounded-xl border-2 border-gray-200 p-4">
        {{ $widgets->links() }}
    </div>
    @endif
</div>
@endsection

