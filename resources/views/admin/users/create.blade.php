@extends('layouts.admin')

@section('title', 'Add User - CISA')
@section('page-title', 'Create New User')
@section('page-subtitle', 'Add a new user to the system')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-slate-50 border-b border-gray-100 px-8 py-6">
                <h2 class="text-lg font-bold text-cisa-base flex items-center gap-2">
                    <i class="fas fa-user-plus text-cisa-accent"></i> User Information
                </h2>
                <p class="text-sm text-gray-500 mt-1">Fill in the details to create a new user account.</p>
            </div>

            <div class="p-8">
                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf

                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Personal Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">First Name <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fas fa-user absolute left-3 top-3.5 text-gray-300"></i>
                                <input type="text" name="first_name" required value="{{ old('first_name') }}"
                                    class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all"
                                    placeholder="John">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Last Name <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fas fa-user absolute left-3 top-3.5 text-gray-300"></i>
                                <input type="text" name="last_name" required value="{{ old('last_name') }}"
                                    class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all"
                                    placeholder="Doe">
                            </div>
                        </div>
                    </div>

                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Account Credentials</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-2">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Email Address <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fas fa-envelope absolute left-3 top-3.5 text-gray-300"></i>
                                <input type="email" name="email" required value="{{ old('email') }}"
                                    class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all"
                                    placeholder="john.doe@example.com">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Password <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fas fa-lock absolute left-3 top-3.5 text-gray-300"></i>
                                <input type="password" name="password" required
                                    class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all"
                                    placeholder="••••••••">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Confirm Password <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fas fa-lock absolute left-3 top-3.5 text-gray-300"></i>
                                <input type="password" name="password_confirmation" required
                                    class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all"
                                    placeholder="••••••••">
                            </div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mb-8 ml-1">Password must be at least 8 characters long.</p>

                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Role & Professional Info</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">System Role <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fas fa-crown absolute left-3 top-3.5 text-gray-300"></i>
                                <select name="role" required
                                    class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all appearance-none">
                                    <option value="" disabled selected>Select a role...</option>
                                    <option value="author" {{ old('role') == 'author' ? 'selected' : '' }}>Author (Standard
                                        User)</option>
                                    <option value="reviewer" {{ old('role') == 'reviewer' ? 'selected' : '' }}>Reviewer
                                    </option>
                                    <option value="editor" {{ old('role') == 'editor' ? 'selected' : '' }}>Editor</option>
                                    <option value="section_editor" {{ old('role') == 'section_editor' ? 'selected' : '' }}>
                                        Section Editor</option>
                                    <option value="copyeditor" {{ old('role') == 'copyeditor' ? 'selected' : '' }}>Copyeditor
                                    </option>
                                    <option value="proofreader" {{ old('role') == 'proofreader' ? 'selected' : '' }}>
                                        Proofreader</option>
                                    <option value="layout_editor" {{ old('role') == 'layout_editor' ? 'selected' : '' }}>
                                        Layout Editor</option>
                                    <option value="journal_manager" {{ old('role') == 'journal_manager' ? 'selected' : '' }}>
                                        Journal Manager</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Site Administrator
                                    </option>
                                </select>
                                <div
                                    class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-500">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Affiliation</label>
                            <div class="relative">
                                <i class="fas fa-university absolute left-3 top-3.5 text-gray-300"></i>
                                <input type="text" name="affiliation" value="{{ old('affiliation') }}"
                                    class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all"
                                    placeholder="University or Institution">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">ORCID ID</label>
                            <div class="relative">
                                <i class="fab fa-orcid absolute left-3 top-3.5 text-gray-300"></i>
                                <input type="text" name="orcid" value="{{ old('orcid') }}"
                                    class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-gray-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-cisa-accent/20 focus:border-cisa-accent transition-all"
                                    placeholder="0000-0000-0000-0000">
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                        <a href="{{ route('admin.users.index') }}"
                            class="px-6 py-2.5 font-bold text-gray-600 hover:text-cisa-base hover:bg-gray-100 rounded-lg transition-colors">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-8 py-2.5 bg-cisa-accent hover:bg-amber-600 text-white font-bold rounded-lg shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all">
                            <i class="fas fa-user-plus mr-2"></i>Create User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection