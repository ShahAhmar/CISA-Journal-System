@extends('layouts.admin')

@section('title', 'Edit User - EMANP')
@section('page-title', 'Edit User')
@section('page-subtitle', 'Update user information and assign journal roles')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg mb-6">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-600 mr-3"></i>
                <p class="text-green-800 font-semibold">{{ session('success') }}</p>
            </div>
        </div>
    @endif
    
    @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg mb-6">
            <div class="flex items-start">
                <i class="fas fa-exclamation-circle text-red-600 mr-3 mt-1"></i>
                <div>
                    <p class="text-red-800 font-semibold mb-2">Please fix the following errors:</p>
                    <ul class="list-disc list-inside text-red-700">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Basic User Information -->
    <div class="bg-white rounded-xl border-2 border-gray-200 p-8">
        <h3 class="text-xl font-bold text-[#0F1B4C] mb-6 flex items-center">
            <i class="fas fa-user mr-3 text-[#0056FF]"></i>Basic Information
        </h3>
        
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">First Name *</label>
                    <input type="text" name="first_name" required value="{{ old('first_name', $user->first_name) }}"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Last Name *</label>
                    <input type="text" name="last_name" required value="{{ old('last_name', $user->last_name) }}"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email *</label>
                    <input type="email" name="email" required value="{{ old('email', $user->email) }}"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]"
                           placeholder="+123456789">
                </div>
            </div>
            
            <div class="mb-6 bg-blue-50 border-l-4 border-blue-400 p-4 rounded-lg">
                <div class="flex items-start">
                    <i class="fas fa-key text-blue-600 mr-3 mt-1"></i>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-blue-800 mb-2">Update Password (Leave blank to keep current)</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1">New Password</label>
                                <input type="password" name="password" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded focus:border-blue-500 focus:outline-none transition-colors">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1">Confirm New Password</label>
                                <input type="password" name="password_confirmation" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded focus:border-blue-500 focus:outline-none transition-colors">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Global Role *</label>
                <select name="role" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                    <option value="author" {{ old('role', $user->role) == 'author' ? 'selected' : '' }}>Author</option>
                    <option value="editor" {{ old('role', $user->role) == 'editor' ? 'selected' : '' }}>Editor</option>
                    <option value="reviewer" {{ old('role', $user->role) == 'reviewer' ? 'selected' : '' }}>Reviewer</option>
                    <option value="copyeditor" {{ old('role', $user->role) == 'copyeditor' ? 'selected' : '' }}>Copyeditor</option>
                    <option value="proofreader" {{ old('role', $user->role) == 'proofreader' ? 'selected' : '' }}>Proofreader</option>
                    <option value="journal_manager" {{ old('role', $user->role) == 'journal_manager' ? 'selected' : '' }}>Journal Manager</option>
                    <option value="section_editor" {{ old('role', $user->role) == 'section_editor' ? 'selected' : '' }}>Section Editor</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrator</option>
                    <option value="administrator" {{ old('role', $user->role) == 'administrator' ? 'selected' : '' }}>Super Administrator</option>
                </select>
                <p class="text-xs text-gray-500 mt-1">This is the user's global role. Super Administrator has full access.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Affiliation</label>
                    <input type="text" name="affiliation" value="{{ old('affiliation', $user->affiliation) }}"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">ORCID</label>
                    <input type="text" name="orcid" value="{{ old('orcid', $user->orcid) }}"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                </div>
            </div>
            
            <div class="mb-6">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                           class="w-4 h-4 text-[#0056FF] border-gray-300 rounded focus:ring-[#0056FF]">
                    <span class="text-sm font-semibold text-gray-700">Active User</span>
                </label>
            </div>
            
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.users.index') }}" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-semibold transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors">
                    Update User
                </button>
            </div>
        </form>
    </div>
    
    <!-- Journal Roles Assignment -->
    <div class="bg-white rounded-xl border-2 border-gray-200 p-8">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-[#0F1B4C] flex items-center">
                <i class="fas fa-book mr-3 text-[#0056FF]"></i>Journal Roles Assignment
            </h3>
            <button type="button" onclick="addJournalRole()" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold text-sm transition-colors">
                <i class="fas fa-plus mr-2"></i>Add Journal Role
            </button>
        </div>
        
        <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-4 mb-6">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-blue-600 mr-3 mt-1"></i>
                <div>
                    <p class="font-semibold text-blue-900 mb-1">Journal-Specific Roles</p>
                    <p class="text-sm text-blue-800">
                        Assign roles to this user for specific journals. A user can have different roles in different journals.
                        Available roles: Journal Manager, Editor, Section Editor, Reviewer, Copyeditor, Proofreader, Sub-Editor.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Current Journal Roles -->
        @if($user->journals->count() > 0)
        <div class="mb-6">
            <h4 class="font-semibold text-[#0F1B4C] mb-4">Current Journal Roles</h4>
            <div class="space-y-3">
                @foreach($user->journals as $journal)
                    @php
                        $pivot = $journal->pivot;
                        $roleConfig = [
                            'journal_manager' => ['bg' => 'bg-red-100', 'text' => 'text-red-600', 'icon' => 'fa-crown'],
                            'editor' => ['bg' => 'bg-green-100', 'text' => 'text-green-600', 'icon' => 'fa-user-edit'],
                            'section_editor' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-600', 'icon' => 'fa-user-tie'],
                            'reviewer' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-600', 'icon' => 'fa-user-check'],
                            'copyeditor' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-600', 'icon' => 'fa-spell-check'],
                            'proofreader' => ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-600', 'icon' => 'fa-check-double'],
                            'sub_editor' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-600', 'icon' => 'fa-user'],
                        ];
                        $roleInfo = $roleConfig[$pivot->role] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-600', 'icon' => 'fa-user'];
                    @endphp
                    <div class="flex items-center justify-between bg-[#F7F9FC] border-2 border-gray-200 rounded-lg p-4">
                        <div class="flex items-center flex-1">
                            <div class="w-10 h-10 {{ $roleInfo['bg'] }} rounded-lg flex items-center justify-center mr-4">
                                <i class="fas {{ $roleInfo['icon'] }} {{ $roleInfo['text'] }}"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-[#0F1B4C]">{{ $journal->name }}</p>
                                <p class="text-sm text-gray-600">
                                    <span class="font-semibold">Role:</span> {{ ucfirst(str_replace('_', ' ', $pivot->role)) }}
                                    @if($pivot->section)
                                        <span class="ml-2">• Section: {{ $pivot->section }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('admin.users.remove-journal-role', [$user, $journal, $pivot->role]) }}" class="inline" onsubmit="return confirm('Are you sure you want to remove this journal role?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold text-sm transition-colors">
                                <i class="fas fa-times mr-1"></i>Remove
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="text-center py-8 text-gray-500 mb-6">
            <i class="fas fa-book text-4xl mb-3 text-gray-300"></i>
            <p>No journal roles assigned yet</p>
        </div>
        @endif
        
        <!-- Add New Journal Role Form -->
        <div id="addRoleForm" class="hidden bg-[#F7F9FC] border-2 border-gray-200 rounded-lg p-6">
            <h4 class="font-semibold text-[#0F1B4C] mb-4">Assign New Journal Role</h4>
            <form method="POST" action="{{ route('admin.users.assign-journal-role', $user) }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Journal *</label>
                        <select name="journal_id" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                            <option value="">Select Journal</option>
                            @foreach($journals as $journal)
                                @if(!$user->journals->contains($journal->id))
                                    <option value="{{ $journal->id }}">{{ $journal->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Role *</label>
                        <select name="role" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                            <option value="">Select Role</option>
                            <option value="journal_manager">Journal Manager</option>
                            <option value="editor">Editor</option>
                            <option value="section_editor">Section Editor</option>
                            <option value="reviewer">Reviewer</option>
                            <option value="copyeditor">Copyeditor</option>
                            <option value="proofreader">Proofreader</option>
                            <option value="sub_editor">Sub-Editor</option>
                        </select>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Section (Optional - for Section Editor)</label>
                    <input type="text" name="section" placeholder="Section name"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="cancelAddRole()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-semibold transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors">
                        <i class="fas fa-check mr-1"></i>Assign Role
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function addJournalRole() {
    document.getElementById('addRoleForm').classList.remove('hidden');
}

function cancelAddRole() {
    document.getElementById('addRoleForm').classList.add('hidden');
    document.querySelector('#addRoleForm form').reset();
}
</script>
@endsection
