@extends('layouts.admin')

@section('title', 'Announcements - EMANP')
@section('page-title', 'Announcements')
@section('page-subtitle', 'Create and manage platform announcements')

@section('content')
@if(session('success'))
    <div class="bg-green-100 border-2 border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-xl border-2 border-gray-200 p-6 mb-6 flex justify-between items-center">
    <div>
        <h3 class="text-lg font-bold text-[#0F1B4C]">Announcements</h3>
        <p class="text-sm text-gray-600">Manage platform-wide and journal-specific announcements</p>
    </div>
    <a href="{{ route('admin.announcements.create') }}" class="bg-[#0056FF] hover:bg-[#0044CC] text-white px-6 py-3 rounded-lg font-semibold transition-colors inline-flex items-center">
        <i class="fas fa-plus mr-2"></i>Create Announcement
    </a>
</div>

@if($announcements->count() > 0)
    <div class="bg-white rounded-xl border-2 border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b-2 border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-bold text-[#0F1B4C]">Title</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-[#0F1B4C]">Type</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-[#0F1B4C]">Journal</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-[#0F1B4C]">Status</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-[#0F1B4C]">Published</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-[#0F1B4C]">Email Sent</th>
                        <th class="px-6 py-4 text-right text-sm font-bold text-[#0F1B4C]">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($announcements as $announcement)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-900">{{ $announcement->title }}</div>
                                <div class="text-sm text-gray-500 mt-1">{{ Str::limit(strip_tags($announcement->content), 60) }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($announcement->type === 'call_for_papers') bg-blue-100 text-blue-700
                                    @elseif($announcement->type === 'new_issue') bg-green-100 text-green-700
                                    @elseif($announcement->type === 'maintenance') bg-red-100 text-red-700
                                    @else bg-gray-100 text-gray-700
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $announcement->type)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $announcement->journal ? $announcement->journal->name : 'Platform-Wide' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($announcement->is_published)
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Published</span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">Draft</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $announcement->published_at ? \Carbon\Carbon::parse($announcement->published_at)->format('M d, Y') : '-' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($announcement->emails_sent)
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                        <i class="fas fa-check mr-1"></i>Sent
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">Not Sent</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('admin.announcements.edit', $announcement) }}" 
                                       class="text-[#0056FF] hover:text-[#0044CC] transition-colors"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($announcement->is_published && $announcement->send_email_notification)
                                        <form action="{{ route('admin.announcements.resend-emails', $announcement) }}" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirm('Resend email notifications to all users?');">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-800 transition-colors" title="Resend Emails">
                                                <i class="fas fa-envelope"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.announcements.destroy', $announcement) }}" 
                                          method="POST" 
                                          class="inline"
                                          onsubmit="return confirm('Are you sure you want to delete this announcement?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 transition-colors" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t-2 border-gray-200">
            {{ $announcements->links() }}
        </div>
    </div>
@else
    <div class="bg-white rounded-xl border-2 border-gray-200 p-8 text-center">
        <i class="fas fa-bullhorn text-gray-400 text-6xl mb-4"></i>
        <h3 class="text-xl font-bold text-gray-700 mb-2">No Announcements Yet</h3>
        <p class="text-gray-600 mb-6">Create your first announcement to notify users about important updates.</p>
        <a href="{{ route('admin.announcements.create') }}" class="bg-[#0056FF] hover:bg-[#0044CC] text-white px-8 py-3 rounded-lg font-semibold transition-colors inline-flex items-center">
            <i class="fas fa-plus mr-2"></i>Create First Announcement
        </a>
    </div>
@endif
@endsection

