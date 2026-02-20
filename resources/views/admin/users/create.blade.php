@extends('layouts.admin')

@section('title', 'Add New User - EMANP')
@section('page-title', 'Add New User')
@section('page-subtitle', 'Create a new user account')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl border-2 border-gray-200 p-8">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">First Name *</label>
                    <input type="text" name="first_name" required value="{{ old('first_name') }}"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Last Name *</label>
                    <input type="text" name="last_name" required value="{{ old('last_name') }}"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                </div>
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email *</label>
                <input type="email" name="email" required value="{{ old('email') }}"
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Password *</label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password *</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                </div>
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Role *</label>
                <select name="role" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                    <option value="author" {{ old('role') == 'author' ? 'selected' : '' }}>Author</option>
                    <option value="editor" {{ old('role') == 'editor' ? 'selected' : '' }}>Editor</option>
                    <option value="reviewer" {{ old('role') == 'reviewer' ? 'selected' : '' }}>Reviewer</option>
                    <option value="copyeditor" {{ old('role') == 'copyeditor' ? 'selected' : '' }}>Copyeditor</option>
                    <option value="proofreader" {{ old('role') == 'proofreader' ? 'selected' : '' }}>Proofreader</option>
                    <option value="journal_manager" {{ old('role') == 'journal_manager' ? 'selected' : '' }}>Journal Manager</option>
                    <option value="section_editor" {{ old('role') == 'section_editor' ? 'selected' : '' }}>Section Editor</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                </select>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Affiliation</label>
                    <input type="text" name="affiliation" value="{{ old('affiliation') }}"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">ORCID</label>
                    <input type="text" name="orcid" value="{{ old('orcid') }}"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                </div>
            </div>
            
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.users.index') }}" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-semibold transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors">
                    Create User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

