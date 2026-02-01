@extends('layouts.admin')

@section('title', 'Journal Pages - CISA')
@section('page-title', 'Journal Pages Management')
@section('page-subtitle', 'Edit all journal pages like WordPress pages section')

@section('content')
    <div class="space-y-6">
        <!-- Journal Selector -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-cisa-base mb-2">Select Journal</h3>
                    <p class="text-sm text-gray-500">Choose a journal to edit its pages</p>
                </div>
                <form method="GET" action="{{ route('admin.journal-pages.index') }}" class="flex items-center gap-3">
                    <select name="journal" onchange="this.form.submit()"
                        class="px-4 py-2.5 bg-slate-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all font-semibold text-cisa-base">
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
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-cisa-base mb-2 flex items-center gap-2">
                        <i class="fas fa-book text-cisa-accent"></i> {{ $journal->name }} - Pages
                    </h3>
                    <p class="text-sm text-gray-500">Click on any page to edit its content</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($pages as $page)
                        <a href="{{ route('admin.journal-pages.edit', [$journal, $page['type']]) }}?live=true"
                            class="bg-white rounded-xl border border-gray-200 hover:border-cisa-accent p-6 transition-all duration-300 hover:shadow-lg group">
                            <div class="flex items-start justify-between mb-4">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-cisa-accent to-amber-600 rounded-lg flex items-center justify-center text-white text-xl group-hover:scale-110 transition-transform shadow-md">
                                    <i class="{{ $page['icon'] }}"></i>
                                </div>
                                @if($page['has_content'])
                                    <span
                                        class="px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-full text-xs font-bold border border-emerald-100">
                                        <i class="fas fa-check-circle mr-1"></i>Has Content
                                    </span>
                                @else
                                    <span
                                        class="px-2.5 py-1 bg-gray-100 text-gray-500 rounded-full text-xs font-bold border border-gray-200">
                                        <i class="fas fa-exclamation-circle mr-1"></i>Empty
                                    </span>
                                @endif
                            </div>

                            <h4 class="text-base font-bold text-cisa-base mb-2 group-hover:text-cisa-accent transition-colors">
                                {{ $page['name'] }}
                            </h4>

                            <p class="text-sm text-gray-600 mb-4 line-clamp-2 leading-relaxed">
                                {{ $page['content_preview'] }}
                            </p>

                            <div class="flex items-center gap-2 pt-4 border-t border-gray-100">
                                <a href="{{ route('admin.journal-pages.edit', [$journal, $page['type']]) }}?live=true"
                                    class="flex-1 text-cisa-base font-bold text-xs bg-slate-50 hover:bg-slate-100 py-2 rounded text-center transition-all">
                                    <i class="fas fa-edit mr-1"></i> Standard
                                </a>
                                @if($page['setting_id'])
                                    <a href="{{ route('admin.visual-editor.edit', $page['setting_id']) }}" target="_blank"
                                        class="flex-1 text-white font-bold text-xs bg-cisa-accent hover:bg-amber-600 py-2 rounded text-center transition-all shadow-sm">
                                        <i class="fas fa-magic mr-1"></i> Visual
                                    </a>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Quick Actions -->
                <div class="mt-8 pt-6 border-t border-gray-100">
                    <h4 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Quick Actions</h4>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('admin.journals.edit', $journal) }}"
                            class="px-4 py-2.5 bg-slate-50 hover:bg-slate-100 text-gray-700 hover:text-cisa-base rounded-lg font-bold transition-all border border-gray-200 text-sm">
                            <i class="fas fa-cog mr-2"></i>Journal Settings
                        </a>
                        <a href="{{ route('admin.journal.page-builder.homepage', $journal) }}"
                            class="px-4 py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg font-bold transition-all border border-blue-100 text-sm">
                            <i class="fas fa-puzzle-piece mr-2"></i>Homepage Builder
                        </a>
                        <a href="{{ route('journals.show', $journal) }}" target="_blank"
                            class="px-4 py-2.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 rounded-lg font-bold transition-all border border-emerald-100 text-sm">
                            <i class="fas fa-external-link-alt mr-2"></i>View Journal
                        </a>
                    </div>
                </div>
            </div>
        @else
            <!-- No Journal Selected -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-16 text-center">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300">
                    <i class="fas fa-book-open text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-cisa-base mb-2">No Journal Selected</h3>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">Please select a journal from the dropdown above to manage its
                    pages</p>
                <a href="{{ route('admin.journals.create') }}"
                    class="inline-flex items-center px-6 py-3 bg-cisa-accent hover:bg-amber-600 text-white rounded-lg font-bold shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all">
                    <i class="fas fa-plus mr-2"></i>Create New Journal
                </a>
            </div>
        @endif
    </div>
@endsection