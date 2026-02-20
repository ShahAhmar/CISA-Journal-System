@extends('layouts.admin')

@section('title', 'Users Management - EMANP')
@section('page-title', 'Users Management')
@section('page-subtitle', 'Manage authors, editors, reviewers, and administrators')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
        <div class="text-2xl font-bold text-[#0F1B4C]">{{ $stats['total'] }}</div>
        <div class="text-xs text-gray-600">Total Users</div>
    </div>
    <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
        <div class="text-2xl font-bold text-blue-600">{{ $stats['authors'] }}</div>
        <div class="text-xs text-gray-600">Authors</div>
    </div>
    <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
        <div class="text-2xl font-bold text-green-600">{{ $stats['editors'] }}</div>
        <div class="text-xs text-gray-600">Editors</div>
    </div>
    <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
        <div class="text-2xl font-bold text-purple-600">{{ $stats['reviewers'] }}</div>
        <div class="text-xs text-gray-600">Reviewers</div>
    </div>
</div>

<!-- Actions -->
<div class="bg-white rounded-xl border-2 border-gray-200 p-6 mb-6 flex justify-between items-center">
    <div>
        <h3 class="text-lg font-bold text-[#0F1B4C]">All Users</h3>
        <p class="text-sm text-gray-600">Manage user accounts and roles</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="bg-[#0056FF] hover:bg-[#0044CC] text-white px-6 py-3 rounded-lg font-semibold transition-colors">
        <i class="fas fa-plus mr-2"></i>Add New User
    </a>
</div>

<!-- Users Table -->
<div class="bg-white rounded-xl border-2 border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-[#0F1B4C] text-white">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Name</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Email</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Role</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Journal Assignments</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Affiliation</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($users as $user)
                    <tr class="hover:bg-[#F7F9FC] transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-[#0F1B4C]">{{ $user->full_name }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold 
                                @if($user->role == 'admin') bg-red-100 text-red-700
                                @elseif($user->role == 'editor') bg-green-100 text-green-700
                                @elseif($user->role == 'reviewer') bg-purple-100 text-purple-700
                                @else bg-blue-100 text-blue-700
                                @endif">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($user->journals->count() > 0)
                                <div class="space-y-1">
                                    @foreach($user->journals as $journal)
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs font-semibold text-[#0F1B4C]">{{ $journal->name }}</span>
                                            <span class="px-2 py-0.5 rounded text-xs bg-blue-50 text-blue-700">
                                                {{ ucfirst(str_replace('_', ' ', $journal->pivot->role)) }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-xs text-gray-400 italic">No journal assignments</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $user->affiliation ?? 'N/A' }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-[#0056FF] hover:text-[#0044CC] transition-colors mr-3" title="Edit User">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-users text-4xl mb-3"></i>
                            <p>No users found</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection

