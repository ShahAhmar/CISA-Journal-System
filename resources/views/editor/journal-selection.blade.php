@extends('layouts.app')

@section('title', 'Select Journal - Editor Dashboard | CISA')

@section('content')
    <div class="min-h-screen bg-slate-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Hero Header -->
            <div class="bg-cisa-base rounded-2xl shadow-xl p-8 mb-8 text-white relative overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
                </div>

                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between">
                    <div>
                        <div
                            class="inline-flex items-center px-3 py-1 bg-white/10 backdrop-blur-sm rounded-full border border-white/20 mb-4">
                            <span class="w-2 h-2 bg-blue-400 rounded-full mr-2 animate-pulse"></span>
                            <span class="text-white text-xs font-bold uppercase tracking-wider">Editor Workspace</span>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-serif font-bold mb-2 flex items-center">
                            Select Journal
                        </h1>
                        <p class="text-blue-200 text-lg font-light">
                            Choose a journal to access its editorial dashboard.
                        </p>
                    </div>
                    <div class="hidden md:block">
                        <div
                            class="w-20 h-20 bg-white/10 rounded-full flex items-center justify-center border-2 border-white/20">
                            <i class="fas fa-layer-group text-4xl text-cisa-accent"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Journal Selection Grid -->
            <h2 class="text-xl font-bold text-cisa-base font-serif mb-6 flex items-center px-2">
                <span class="w-1 h-6 bg-cisa-accent mr-3 rounded-full"></span>
                Your Journals
            </h2>

            @if($editorJournals->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($editorJournals as $journal)
                        @php
                            $roleConfig = [
                                'journal_manager' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-800', 'icon' => 'fa-crown', 'label' => 'Manager'],
                                'editor' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'icon' => 'fa-user-edit', 'label' => 'Editor'],
                                'section_editor' => ['bg' => 'bg-teal-100', 'text' => 'text-teal-800', 'icon' => 'fa-user-tie', 'label' => 'Section Editor'],
                            ];
                            $roleInfo = $roleConfig[$journal->pivot->role] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'icon' => 'fa-user', 'label' => ucfirst(str_replace('_', ' ', $journal->pivot->role))];
                        @endphp
                        <a href="{{ route('editor.dashboard', $journal) }}"
                            class="group bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-xl hover:border-cisa-accent transition-all duration-300 transform hover:-translate-y-1 block relative overflow-hidden">

                            <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                                <i class="fas fa-book text-8xl transform rotate-12"></i>
                            </div>

                            <div class="relative z-10">
                                <div class="flex items-center justify-between mb-4">
                                    <span
                                        class="px-3 py-1 {{ $roleInfo['bg'] }} {{ $roleInfo['text'] }} rounded-full text-[10px] font-bold uppercase tracking-wider flex items-center gap-1">
                                        <i class="fas {{ $roleInfo['icon'] }}"></i> {{ $roleInfo['label'] }}
                                    </span>
                                    <i
                                        class="fas fa-external-link-alt text-gray-300 group-hover:text-cisa-accent transition-colors"></i>
                                </div>

                                <h3
                                    class="font-serif font-bold text-xl text-cisa-base mb-2 group-hover:text-cisa-accent transition-colors">
                                    {{ $journal->name }}
                                </h3>

                                @if($journal->description)
                                    <p class="text-sm text-gray-500 mb-6 line-clamp-3 leading-relaxed">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($journal->description), 120) }}
                                    </p>
                                @else
                                    <div class="h-6 mb-6"></div>
                                @endif

                                <div
                                    class="flex items-center text-xs font-bold text-cisa-base uppercase tracking-wider group-hover:underline decoration-cisa-accent underline-offset-4">
                                    Enter Dashboard <i class="fas fa-arrow-right ml-1 text-cisa-accent"></i>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-16 text-center">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300">
                        <i class="fas fa-book-open text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-serif font-bold text-gray-600 mb-2">No active assignments</h3>
                    <p class="text-gray-400">You are not currently assigned to any journals as an editor.</p>
                </div>
            @endif
        </div>
    </div>
@endsection