@extends('layouts.app')

@section('title', 'Select Journal - Editor Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-gradient-to-r from-[#0056FF] to-[#1D72B8] rounded-2xl shadow-2xl p-8 mb-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold mb-2 flex items-center">
                        <i class="fas fa-user-edit mr-3"></i>Editor Dashboard
                    </h1>
                    <p class="text-blue-100 text-lg">Welcome back, {{ auth()->user()->full_name }}</p>
                    <p class="text-blue-200 text-sm mt-1">Select a journal to manage</p>
                </div>
                <div class="hidden md:block">
                    <i class="fas fa-book-open text-8xl opacity-20"></i>
                </div>
            </div>
        </div>

        <!-- Journal Selection -->
        <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-8">
            <h2 class="text-2xl font-bold text-[#0F1B4C] mb-6 flex items-center">
                <i class="fas fa-list mr-3 text-[#0056FF]"></i>Select Journal
            </h2>
            
            @if($editorJournals->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($editorJournals as $journal)
                        @php
                            $roleConfig = [
                                'journal_manager' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'icon' => 'fa-crown', 'label' => 'Journal Manager'],
                                'editor' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'icon' => 'fa-user-edit', 'label' => 'Editor'],
                                'section_editor' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'icon' => 'fa-user-tie', 'label' => 'Section Editor'],
                            ];
                            $roleInfo = $roleConfig[$journal->pivot->role] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'icon' => 'fa-user', 'label' => ucfirst(str_replace('_', ' ', $journal->pivot->role))];
                        @endphp
                        <a href="{{ route('editor.dashboard', $journal) }}" 
                           class="block border-2 border-gray-200 rounded-xl p-6 hover:border-[#0056FF] hover:shadow-xl transition-all group">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h3 class="font-bold text-[#0F1B4C] text-lg mb-2 group-hover:text-[#0056FF] transition-colors">
                                        {{ $journal->name }}
                                    </h3>
                                    @if($journal->description)
                                        @php
                                            $cleanDescription = \Illuminate\Support\Str::limit(strip_tags($journal->description), 120);
                                        @endphp
                                        <p class="text-sm text-gray-600 mb-3">{{ $cleanDescription }}</p>
                                    @endif
                                </div>
                                <i class="fas fa-arrow-right text-gray-400 group-hover:text-[#0056FF] transition-colors"></i>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="px-3 py-1 {{ $roleInfo['bg'] }} {{ $roleInfo['text'] }} rounded-full text-xs font-semibold">
                                    <i class="fas {{ $roleInfo['icon'] }} mr-1"></i>{{ $roleInfo['label'] }}
                                </span>
                                <span class="text-sm text-gray-500 group-hover:text-[#0056FF] transition-colors">
                                    Manage <i class="fas fa-chevron-right ml-1"></i>
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-book text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 text-lg font-semibold mb-2">No journal assignments</p>
                    <p class="text-gray-400 text-sm">You haven't been assigned to any journals yet.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

