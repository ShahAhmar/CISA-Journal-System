@extends('layouts.admin')

@section('title', 'Plugin Management - EMANP')
@section('page-title', 'Plugin Management')
@section('page-subtitle', 'Install and manage system plugins')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl border-2 border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-xl font-bold text-[#0F1B4C]">Installed Plugins</h3>
                <p class="text-gray-600 mt-1">Manage system plugins and extensions</p>
            </div>
            <button onclick="document.getElementById('installModal').classList.remove('hidden')" 
               class="px-6 py-3 bg-gradient-to-r from-[#0056FF] to-indigo-600 hover:from-[#0044CC] hover:to-indigo-700 text-white rounded-lg font-semibold transition-colors shadow-lg">
                <i class="fas fa-plus mr-2"></i>Install Plugin
            </button>
        </div>
    </div>

    <!-- Plugins List -->
    @if(count($plugins) > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($plugins as $name => $plugin)
        <div class="bg-white rounded-xl border-2 border-gray-200 p-6 hover:shadow-lg transition-all">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-[#0056FF] rounded-lg flex items-center justify-center text-white">
                        <i class="fas fa-plug text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-[#0F1B4C]">{{ $plugin['name'] ?? $name }}</h4>
                        <p class="text-xs text-gray-500">v{{ $plugin['version'] ?? '1.0.0' }}</p>
                    </div>
                </div>
            </div>
            
            @if(isset($plugin['description']))
            <p class="text-sm text-gray-600 mb-4">{{ $plugin['description'] }}</p>
            @endif
            
            <div class="flex space-x-2">
                <form action="{{ route('admin.plugins.uninstall', $name) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to uninstall this plugin?')">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors text-sm font-semibold">
                        <i class="fas fa-trash mr-1"></i>Uninstall
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="bg-white rounded-xl border-2 border-gray-200 p-12 text-center">
        <i class="fas fa-plug text-6xl text-gray-400 mb-4"></i>
        <h3 class="text-xl font-bold text-gray-700 mb-2">No Plugins Installed</h3>
        <p class="text-gray-600 mb-6">Install plugins to extend system functionality</p>
        <button onclick="document.getElementById('installModal').classList.remove('hidden')" 
           class="px-6 py-3 bg-[#0056FF] text-white rounded-lg hover:bg-[#0044CC] transition-colors font-semibold">
            <i class="fas fa-plus mr-2"></i>Install First Plugin
        </button>
    </div>
    @endif

    <!-- Install Plugin Modal -->
    <div id="installModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl p-8 max-w-md w-full mx-4">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-[#0F1B4C]">Install Plugin</h3>
                <button onclick="document.getElementById('installModal').classList.add('hidden')" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form method="POST" action="{{ route('admin.plugins.install') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Plugin Name</label>
                        <input type="text" name="name" required class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Version</label>
                        <input type="text" name="version" required value="1.0.0" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                        <textarea name="description" rows="3" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]"></textarea>
                    </div>
                    <div class="flex space-x-3">
                        <button type="submit" class="flex-1 px-4 py-2 bg-[#0056FF] text-white rounded-lg hover:bg-[#0044CC] transition-colors font-semibold">
                            Install
                        </button>
                        <button type="button" onclick="document.getElementById('installModal').classList.add('hidden')" class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-semibold">
                            Cancel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

