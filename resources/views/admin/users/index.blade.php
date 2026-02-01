@extends('layouts.admin')

@section('title', 'User Management - CISA')
@section('page-title', 'User Management')
@section('page-subtitle', 'Manage global users, roles, and permissions')

@section('content')
    <!-- Stats Overview -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
            <div class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Total Users</div>
            <div class="text-2xl font-bold text-cisa-base">{{ $stats['total'] }}</div>
        </div>
        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
            <div class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Authors</div>
            <div class="text-2xl font-bold text-blue-600">{{ $stats['authors'] }}</div>
        </div>
        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
            <div class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Editors & Reviewers</div>
            <div class="text-2xl font-bold text-cisa-accent">{{ $stats['editors'] + $stats['reviewers'] }}</div>
        </div>
        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
            <div class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Administrators</div>
            <div class="text-2xl font-bold text-purple-600">{{ $stats['admins'] ?? 0 }}</div>
        </div>
    </div>

    <!-- Header Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div class="relative max-w-sm w-full">
            <i class="fas fa-search absolute left-3 top-3 text-gray-300"></i>
            <input type="text"
                class="block w-full pl-10 pr-3 py-2.5 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-cisa-accent/50 focus:border-cisa-accent text-sm placeholder-gray-400 transition-all shadow-sm"
                placeholder="Search users...">
        </div>

        <a href="{{ route('admin.users.create') }}"
            class="inline-flex items-center justify-center px-4 py-2.5 bg-cisa-accent hover:bg-amber-600 text-white font-bold rounded-lg shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all text-sm group">
            <i class="fas fa-plus mr-2 group-hover:rotate-90 transition-transform"></i>
            <span>Add New User</span>
        </a>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 border-b border-gray-100">
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">User Profile</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">System Role</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Journal Roles</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($users as $user)
                        <tr
                            class="hover:bg-slate-50 transition-colors group {{ $user->is_active ? '' : 'bg-gray-50 opacity-75' }}">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-cisa-base text-white flex items-center justify-center font-bold text-sm shadow-sm ring-2 ring-white">
                                        {{ substr($user->full_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-cisa-base text-sm">{{ $user->full_name }}</div>
                                        <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                        @if($user->affiliation)
                                            <div class="text-[10px] text-gray-400 mt-0.5">{{ Str::limit($user->affiliation, 30) }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $roleColors = [
                                        'admin' => 'bg-purple-50 text-purple-700 border-purple-100',
                                        'editor' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                        'reviewer' => 'bg-blue-50 text-blue-700 border-blue-100',
                                        'author' => 'bg-slate-50 text-slate-600 border-slate-200'
                                    ];
                                    $roleClass = $roleColors[$user->role] ?? 'bg-gray-50 text-gray-600';
                                @endphp
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $roleClass }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($user->journals->count() > 0)
                                    <div class="flex flex-col gap-1">
                                        @foreach($user->journals as $journal)
                                            <div class="flex items-center gap-2">
                                                <span class="w-1.5 h-1.5 rounded-full bg-cisa-accent"></span>
                                                <span
                                                    class="text-xs font-medium text-gray-700">{{ $journal->journal_initials ?? Str::limit($journal->name, 15) }}</span>
                                                <span
                                                    class="text-[10px] text-gray-400 bg-gray-100 px-1 rounded">{{ ucfirst($journal->pivot->role) }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400 italic">No specific assignments</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($user->terminated_at)
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-50 text-red-600 border border-red-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Terminated
                                    </span>
                                @elseif($user->suspended_at)
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-600 border border-amber-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Suspended
                                    </span>
                                @elseif(!$user->is_active)
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-500 border border-gray-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Disabled
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div
                                    class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-cisa-accent hover:bg-amber-50 transition-all font-bold"
                                        title="Edit User">
                                        <i class="fas fa-pen"></i>
                                    </a>

                                    @if($user->terminated_at)
                                        <form action="{{ route('admin.users.restore-terminated', $user) }}" method="POST"
                                            class="inline" onsubmit="return confirm('Restore this user?');">
                                            @csrf
                                            <button type="submit"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 transition-all"
                                                title="Restore">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        </form>
                                    @elseif($user->is_active && !$user->suspended_at)
                                        <form action="{{ route('admin.users.suspend', $user) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Suspend this user?');">
                                            @csrf
                                            <button type="submit"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-amber-600 hover:bg-amber-50 transition-all"
                                                title="Suspend">
                                                <i class="fas fa-pause"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.users.disable', $user) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Disable this user account?');">
                                            @csrf
                                            <button type="submit"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-slate-600 hover:bg-slate-100 transition-all"
                                                title="Disable">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.users.enable', $user) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Re-enable this user?');">
                                            @csrf
                                            <button type="submit"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 transition-all"
                                                title="Enable">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif

                                    @if(!$user->terminated_at)
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Delete this user?');">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-all"
                                                title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div
                                    class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                                    <i class="fas fa-users text-3xl"></i>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-1">No users found</h3>
                                <p class="text-gray-500 text-sm">Add your first user to get started.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-slate-50">
                {{ $users->links() }}
            </div>
        @endif
    </div>
@endsection