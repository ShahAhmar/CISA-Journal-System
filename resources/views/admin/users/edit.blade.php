@extends('layouts.admin')

@section('title', 'Edit User - CISA')
@section('page-title', 'Edit User Profile')
@section('page-subtitle', 'Update user information and permissions')

@section('content')
    <div class="max-w-6xl mx-auto space-y-8">
        <!-- User Overview Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 flex flex-col md:flex-row items-center gap-8">
            <div
                class="w-24 h-24 rounded-full bg-cisa-base text-white flex items-center justify-center text-3xl font-bold ring-4 ring-slate-100">
                {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
            </div>
            <div class="flex-1 text-center md:text-left">
                <h1 class="text-2xl font-bold text-cisa-base mb-1">{{ $user->full_name }}</h1>
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 text-sm text-gray-500">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-envelope text-cisa-accent"></i> {{ $user->email }}
                    </span>
                    <span class="hidden md:inline text-gray-300">|</span>
                    <span class="flex items-center gap-2">
                        <i class="fas fa-crown text-gray-400"></i> Global Role: <span
                            class="uppercase font-bold text-gray-700">{{ $user->role }}</span>
                    </span>
                    <span class="hidden md:inline text-gray-300">|</span>
                    <span class="flex items-center gap-2">
                        <i class="fas fa-calendar-alt text-gray-400"></i> Joined {{ $user->created_at->format('M Y') }}
                    </span>
                </div>
                <div class="mt-4 flex flex-wrap justify-center md:justify-start gap-2">
                    @foreach($user->journals as $journal)
                        <span
                            class="px-2 py-1 rounded bg-slate-50 border border-gray-200 text-xs text-gray-600 flex items-center gap-1">
                            <i class="fas fa-book text-gray-400"></i> {{ Str::limit($journal->name, 20) }}
                            <span class="text-gray-300">|</span>
                            <span
                                class="font-bold text-cisa-base">{{ ucfirst(str_replace('_', ' ', $journal->pivot->role)) }}</span>
                        </span>
                    @endforeach
                </div>
            </div>

            <div class="flex flex-col gap-2 w-full md:w-auto">
                @if($user->is_active)
                    <span
                        class="px-4 py-2 bg-emerald-50 text-emerald-600 rounded-lg text-sm font-bold border border-emerald-100 flex items-center justify-center gap-2">
                        <i class="fas fa-check-circle"></i> Account Active
                    </span>
                @else
                    <span
                        class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm font-bold border border-gray-200 flex items-center justify-center gap-2">
                        <i class="fas fa-ban"></i> Account Disabled
                    </span>
                @endif
            </div>
        </div>

        <!-- Edit Form & Roles Container -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Info Column -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Basic Information Form -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-slate-50 border-b border-gray-100 px-8 py-5 flex justify-between items-center">
                        <h3 class="font-bold text-cisa-base flex items-center gap-2">
                            <i class="fas fa-user-edit text-cisa-accent"></i> Edit Profile
                        </h3>
                    </div>

                    <div class="p-8">
                        <form method="POST" action="{{ route('admin.users.update', $user) }}">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">First Name <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="first_name" required
                                        value="{{ old('first_name', $user->first_name) }}"
                                        class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Last Name <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="last_name" required
                                        value="{{ old('last_name', $user->last_name) }}"
                                        class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all">
                                </div>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Email Address <span
                                        class="text-red-500">*</span></label>
                                <input type="email" name="email" required value="{{ old('email', $user->email) }}"
                                    class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Global Role <span
                                            class="text-red-500">*</span></label>
                                    <select name="role" required
                                        class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all">
                                        <option value="author" {{ old('role', $user->role) == 'author' ? 'selected' : '' }}>
                                            Author</option>
                                        <option value="reviewer" {{ old('role', $user->role) == 'reviewer' ? 'selected' : '' }}>Reviewer</option>
                                        <option value="editor" {{ old('role', $user->role) == 'editor' ? 'selected' : '' }}>
                                            Editor</option>
                                        <option value="section_editor" {{ old('role', $user->role) == 'section_editor' ? 'selected' : '' }}>Section Editor</option>
                                        <option value="copyeditor" {{ old('role', $user->role) == 'copyeditor' ? 'selected' : '' }}>Copyeditor</option>
                                        <option value="proofreader" {{ old('role', $user->role) == 'proofreader' ? 'selected' : '' }}>Proofreader</option>
                                        <option value="journal_manager" {{ old('role', $user->role) == 'journal_manager' ? 'selected' : '' }}>Journal Manager</option>
                                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                            Administrator</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Account Status</label>
                                    <select name="is_active"
                                        class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all">
                                        <option value="1" {{ old('is_active', $user->is_active) ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="0" {{ !old('is_active', $user->is_active) ? 'selected' : '' }}>
                                            Disabled</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Affiliation</label>
                                    <input type="text" name="affiliation"
                                        value="{{ old('affiliation', $user->affiliation) }}"
                                        class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">ORCID</label>
                                    <input type="text" name="orcid" value="{{ old('orcid', $user->orcid) }}"
                                        class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all">
                                </div>
                            </div>

                            <div class="flex justify-end gap-4 pt-4 border-t border-gray-100">
                                <a href="{{ route('admin.users.index') }}"
                                    class="px-6 py-2.5 font-bold text-gray-600 hover:text-cisa-base hover:bg-gray-100 rounded-lg transition-colors">
                                    Cancel
                                </a>
                                <button type="submit"
                                    class="px-8 py-2.5 bg-cisa-accent hover:bg-amber-600 text-white font-bold rounded-lg shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all">
                                    <i class="fas fa-save mr-2"></i>Update User
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar / Journal Assignments -->
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-slate-800 border-b border-gray-700 px-6 py-4 flex justify-between items-center">
                        <h3 class="text-white font-bold text-sm uppercase tracking-wider">Journal Assignments</h3>
                        <button type="button" onclick="document.getElementById('addRoleForm').classList.toggle('hidden')"
                            class="w-8 h-8 rounded-lg bg-slate-700 hover:bg-cisa-accent text-white flex items-center justify-center transition-colors">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>

                    <!-- Add Role Form (Hidden by default) -->
                    <div id="addRoleForm" class="hidden bg-slate-50 p-6 border-b border-gray-200">
                        <h4 class="font-bold text-cisa-base text-sm mb-4">Assign New Role</h4>
                        <form method="POST" action="{{ route('admin.users.assign-journal-role', $user) }}">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 mb-1">Journal</label>
                                    <select name="journal_id" required
                                        class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-cisa-accent">
                                        <option value="">Select Journal...</option>
                                        @foreach($journals as $journal)
                                            @if(!$user->journals->contains($journal->id))
                                                <option value="{{ $journal->id }}">{{ $journal->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 mb-1">Role</label>
                                    <select name="role" required
                                        class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-cisa-accent">
                                        <option value="journal_manager">Journal Manager</option>
                                        <option value="editor">Editor</option>
                                        <option value="section_editor">Section Editor</option>
                                        <option value="reviewer">Reviewer</option>
                                        <option value="copyeditor">Copyeditor</option>
                                        <option value="proofreader">Proofreader</option>
                                        <option value="layout_editor">Layout Editor</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 mb-1">Section (Optional)</label>
                                    <input type="text" name="section"
                                        class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-cisa-accent"
                                        placeholder="e.g. Articles">
                                </div>
                                <button type="submit"
                                    class="w-full py-2 bg-cisa-base hover:bg-slate-700 text-white rounded-lg text-xs font-bold transition-colors">Assign
                                    Role</button>
                            </div>
                        </form>
                    </div>

                    <div class="divide-y divide-gray-100">
                        @forelse($user->journals as $journal)
                            <div class="p-4 flex items-start justify-between group hover:bg-slate-50 transition-colors">
                                <div>
                                    <h4 class="font-bold text-cisa-base text-sm mb-0.5">{{ $journal->name }}</h4>
                                    <div class="flex items-center gap-2">
                                        @php
                                            $roleColors = [
                                                'journal_manager' => 'text-red-600 bg-red-50',
                                                'editor' => 'text-green-600 bg-green-50',
                                                'reviewer' => 'text-purple-600 bg-purple-50',
                                                'section_editor' => 'text-blue-600 bg-blue-50',
                                                'layout_editor' => 'text-orange-600 bg-orange-50'
                                            ];
                                            $colorClass = $roleColors[$journal->pivot->role] ?? 'text-gray-600 bg-gray-50';
                                        @endphp
                                        <span class="px-2 py-0.5 rounded text-[10px] uppercase font-bold {{ $colorClass }}">
                                            {{ str_replace('_', ' ', $journal->pivot->role) }}
                                        </span>
                                        @if($journal->pivot->section)
                                            <span class="text-xs text-gray-400">• {{ $journal->pivot->section }}</span>
                                        @endif
                                    </div>
                                </div>
                                <form method="POST"
                                    action="{{ route('admin.users.remove-journal-role', [$user, $journal, $journal->pivot->role]) }}"
                                    onsubmit="return confirm('Remove role?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-gray-300 hover:text-red-500 transition-colors p-1">
                                        <i class="fas fa-times-circle"></i>
                                    </button>
                                </form>
                            </div>
                        @empty
                            <div class="p-8 text-center">
                                <i class="fas fa-book-reader text-gray-200 text-3xl mb-2"></i>
                                <p class="text-sm text-gray-400">No journal specific roles.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="bg-blue-50 rounded-xl border border-blue-100 p-6">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-shield-alt text-blue-500 mt-1"></i>
                        <div>
                            <h4 class="font-bold text-blue-900 text-sm mb-1">Security Note</h4>
                            <p class="text-xs text-blue-700 leading-relaxed">
                                Passwords can only be changed by users themselves via their profile settings for security
                                reasons. Administrators can only reset account status or roles.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection