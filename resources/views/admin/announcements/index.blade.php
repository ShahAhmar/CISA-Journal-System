@extends('layouts.admin')

@section('title', 'Announcements - CISA')
@section('page-title', 'Announcements')
@section('page-subtitle', 'Manage system-wide and journal-specific notifications')

@section('content')
<!-- Actions & Search -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
    <div class="relative max-w-md w-full">
         <i class="fas fa-search absolute left-3 top-3 text-gray-300"></i>
         <input type="text" 
                class="block w-full pl-10 pr-3 py-2.5 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-cisa-accent/50 focus:border-cisa-accent text-sm placeholder-gray-400 transition-all shadow-sm"
                placeholder="Search announcements...">
    </div>
    
    <a href="{{ route('admin.announcements.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-cisa-accent hover:bg-amber-600 text-white font-bold rounded-lg shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all text-sm group">
        <i class="fas fa-bullhorn mr-2 group-hover:scale-110 transition-transform"></i>
        <span>Create Announcement</span>
    </a>
</div>

<!-- Announcements List -->
@if($announcements->count() > 0)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 border-b border-gray-100">
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Announcement</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Context</th>
                         <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                         <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($announcements as $announcement)
                        <tr class="hover:bg-slate-50 transition-colors group">
                             <td class="px-6 py-4">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-amber-50 text-cisa-accent flex items-center justify-center font-bold shadow-sm border border-amber-100">
                                        <i class="fas fa-bullhorn"></i>
                                    </div>
                                    <div>
                                        <div class="font-bold text-cisa-base text-sm mb-1">{{ $announcement->title }}</div>
                                        <div class="text-xs text-gray-500 line-clamp-1 max-w-xs">{{ Str::limit(strip_tags($announcement->content), 60) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                    <span class="text-xs font-bold text-gray-600">
                                        {{ $announcement->journal ? $announcement->journal->name : 'Platform-Wide' }}
                                    </span>
                                    @php
                                        $typeColors = [
                                            'call_for_papers' => 'text-blue-600 bg-blue-50 border-blue-100',
                                            'new_issue' => 'text-emerald-600 bg-emerald-50 border-emerald-100',
                                            'maintenance' => 'text-red-600 bg-red-50 border-red-100',
                                            'general' => 'text-gray-600 bg-gray-100 border-gray-200'
                                        ];
                                        $typeClass = $typeColors[$announcement->type] ?? 'text-gray-600 bg-gray-100 border-gray-200';
                                    @endphp
                                    <span class="inline-flex self-start px-2 py-0.5 rounded text-[10px] font-bold border {{ $typeClass }}">
                                        {{ ucfirst(str_replace('_', ' ', $announcement->type)) }}
                                    </span>
                                </div>
                            </td>
                             <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                     @if($announcement->is_published)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100 w-fit">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Published
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-500 border border-gray-200 w-fit">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Draft
                                        </span>
                                    @endif
                                    
                                    @if($announcement->emails_sent)
                                        <span class="text-[10px] text-green-600 flex items-center gap-1">
                                            <i class="fas fa-paper-plane"></i> Sent to users
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium text-gray-600">
                                    {{ $announcement->published_at ? \Carbon\Carbon::parse($announcement->published_at)->format('M d, Y') : '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.announcements.edit', $announcement) }}" 
                                       class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-cisa-accent hover:bg-amber-50 transition-all font-bold"
                                       title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    
                                     @if($announcement->is_published && $announcement->send_email_notification)
                                        <form action="{{ route('admin.announcements.resend-emails', $announcement) }}" method="POST" class="inline" onsubmit="return confirm('Resend notifications?');">
                                            @csrf
                                            <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-all font-bold" title="Resend Emails">
                                                <i class="fas fa-envelope"></i>
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" class="inline" onsubmit="return confirm('Delete announcement?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-all" title="Delete">
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
         @if($announcements->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-slate-50">
                {{ $announcements->links() }}
            </div>
        @endif
    </div>
@else
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300">
             <i class="fas fa-bullhorn text-4xl"></i>
        </div>
        <h3 class="text-xl font-bold text-cisa-base mb-2">No Announcements</h3>
        <p class="text-gray-500 mb-8 max-w-md mx-auto">Create announcements to keep your users informed about calls for papers, new issues, or maintenance.</p>
        <a href="{{ route('admin.announcements.create') }}" class="inline-flex px-8 py-3 bg-cisa-accent hover:bg-amber-600 text-white font-bold rounded-lg shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all">
            <i class="fas fa-plus mr-2"></i>Create First Announcement
        </a>
    </div>
@endif
@endsection
