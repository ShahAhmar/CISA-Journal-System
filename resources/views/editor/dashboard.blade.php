@extends('layouts.app')

@section('title', $journal->name . ' - Editor Dashboard | CISA')

@section('content')
    <div class="min-h-screen bg-slate-50 py-8">
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
                            {{ $journal->name }}
                        </h1>
                        <p class="text-blue-200 text-lg font-light">
                            Oversee editorial processes and manage submissions.
                        </p>
                    </div>
                    <div class="flex items-center gap-6 mt-6 md:mt-0">
                        @if($notifications->count() > 0)
                            <button onclick="showNotificationPopup()"
                                class="relative bg-white/10 hover:bg-white/20 rounded-full p-4 transition-all group">
                                <i class="fas fa-bell text-2xl text-cisa-accent group-hover:scale-110 transition-transform"></i>
                                <span
                                    class="absolute top-1 right-1 bg-red-500 text-white text-[10px] font-bold rounded-full w-5 h-5 flex items-center justify-center border-2 border-cisa-base">{{ $notifications->count() }}</span>
                            </button>
                        @endif
                        <div class="hidden md:block">
                            <div
                                class="w-20 h-20 bg-white/10 rounded-full flex items-center justify-center border-2 border-white/20">
                                <i class="fas fa-edit text-4xl text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notification Popup Modal -->
            @if($notifications->count() > 0)
                <div id="notificationPopup"
                    class="hidden fixed inset-0 bg-cisa-base/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
                    <div
                        class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto transform scale-100 transition-all">
                        <div
                            class="sticky top-0 bg-slate-50 border-b border-gray-100 p-6 flex items-center justify-between z-10">
                            <h3 class="text-xl font-bold text-cisa-base flex items-center font-serif">
                                <span class="w-1 h-6 bg-cisa-accent mr-3 rounded-full"></span>
                                Reviewer Notifications
                            </h3>
                            <button onclick="hideNotificationPopup()"
                                class="text-gray-400 hover:text-cisa-base transition-colors">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                        <div class="p-6 space-y-4">
                            @foreach($notifications as $notification)
                                @php
                                    $data = $notification->data;
                                    $isAccepted = $data['action'] === 'accepted';
                                @endphp
                                <div class="border rounded-xl p-5 notification-item {{ $isAccepted ? 'bg-green-50 border-green-100' : 'bg-red-50 border-red-100' }}"
                                    data-notification-id="{{ $notification->id }}">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 mr-4">
                                            <div
                                                class="w-10 h-10 rounded-full flex items-center justify-center {{ $isAccepted ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                                <i class="fas {{ $isAccepted ? 'fa-check' : 'fa-times' }}"></i>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between mb-1">
                                                <h4 class="font-bold text-gray-900">
                                                    {{ $isAccepted ? 'Review Accepted' : 'Review Declined' }}
                                                </h4>
                                                <span class="text-xs text-gray-500 font-mono">
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                            <p class="text-sm text-gray-600 mb-3 leading-relaxed">
                                                <span class="font-bold text-gray-800">{{ $data['reviewer_name'] }}</span> has
                                                {{ $isAccepted ? 'accepted' : 'declined' }} request for <br>
                                                <span class="italic text-gray-500">"{{ $data['submission_title'] }}"</span>
                                            </p>

                                            @if(!$isAccepted && !empty($data['decline_reason']))
                                                <div class="bg-white/60 rounded p-3 mb-3 border-l-2 border-red-300">
                                                    <p class="text-xs font-bold text-red-800 uppercase tracking-wide mb-1">Reason
                                                        provided:</p>
                                                    <p class="text-sm text-gray-700 italic">"{{ $data['decline_reason'] }}"</p>
                                                </div>
                                            @endif

                                            <div class="flex items-center gap-3">
                                                <a href="{{ route('editor.submissions.show', ['journal' => $data['journal_slug'], 'submission' => $data['submission_id']]) }}"
                                                    onclick="markAsRead('{{ $notification->id }}')"
                                                    class="inline-flex items-center text-xs font-bold uppercase tracking-wider text-cisa-base hover:text-cisa-accent">
                                                    View Submission <i class="fas fa-arrow-right ml-1"></i>
                                                </a>
                                                <button onclick="markAsRead('{{ $notification->id }}')"
                                                    class="text-xs text-gray-400 hover:text-gray-600">
                                                    Mark as read
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="sticky bottom-0 bg-slate-50 p-4 border-t border-gray-100 flex justify-end">
                            <button onclick="markAllAsRead()"
                                class="text-xs font-bold text-gray-500 hover:text-cisa-base uppercase tracking-wider transition-colors">
                                Mark All Read
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Filter Stats Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-3 mb-8">
                @php
                    $filters = [
                        'submitted' => ['icon' => 'clock', 'color' => 'yellow', 'label' => 'Pending'],
                        'under_review' => ['icon' => 'search', 'color' => 'blue', 'label' => 'Reviewing'],
                        'revision_requested' => ['icon' => 'edit', 'color' => 'orange', 'label' => 'Revision'],
                        'accepted' => ['icon' => 'check-circle', 'color' => 'green', 'label' => 'Accepted'],
                        'rejected' => ['icon' => 'times-circle', 'color' => 'red', 'label' => 'Rejected'],
                        'withdrawn' => ['icon' => 'undo', 'color' => 'gray', 'label' => 'Withdrawn'],
                        'published' => ['icon' => 'book', 'color' => 'purple', 'label' => 'Published'],
                    ];
                @endphp

                @foreach($filters as $key => $meta)
                    <a href="{{ route('editor.dashboard', ['journal' => $journal, 'status' => $key]) }}"
                        class="bg-white rounded-lg border p-4 hover:shadow-md transition-all group text-center
                                  {{ ($statusFilter ?? null) === $key ? 'border-' . $meta['color'] . '-500 ring-1 ring-' . $meta['color'] . '-500 bg-' . $meta['color'] . '-50' : 'border-gray-100 hover:border-gray-300' }}">
                        <div class="text-{{ $meta['color'] }}-500 mb-2 group-hover:scale-110 transition-transform inline-block">
                            <i class="fas fa-{{ $meta['icon'] }} text-xl"></i>
                        </div>
                        <div class="text-2xl font-bold text-gray-800 leading-none mb-1">{{ $stats[$key] ?? 0 }}</div>
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">{{ $meta['label'] }}</div>
                    </a>
                @endforeach
            </div>

            <!-- Recent Submissions Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex items-center justify-between bg-slate-50/50">
                    <div class="flex items-center gap-4">
                        <h2 class="text-xl font-bold text-cisa-base font-serif flex items-center">
                            <span class="w-1 h-6 bg-cisa-accent mr-3 rounded-full"></span>
                            Recent Submissions
                        </h2>
                        @if(!empty($statusFilter))
                            <span
                                class="px-2 py-1 bg-cisa-base/10 text-cisa-base rounded text-xs font-bold uppercase tracking-wider">
                                {{ str_replace('_', ' ', $statusFilter) }}
                            </span>
                        @endif
                    </div>
                    <div class="flex items-center gap-3">
                        @if(!empty($statusFilter))
                            <a href="{{ route('editor.dashboard', $journal) }}"
                                class="text-xs font-bold text-gray-400 hover:text-red-500 flex items-center transition-colors">
                                <i class="fas fa-times mr-1"></i> CLEAR
                            </a>
                        @endif
                        <a href="{{ route('editor.submissions.index', $journal) }}"
                            class="btn-cisa-primary py-2 px-4 text-xs">
                            View All
                        </a>
                    </div>
                </div>

                @if($recentSubmissions->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr
                                    class="bg-slate-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-bold">
                                    <th class="px-6 py-4">Submission Details</th>
                                    <th class="px-6 py-4">Author</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4">Date</th>
                                    <th class="px-6 py-4 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($recentSubmissions as $submission)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-gray-800 text-sm mb-1 line-clamp-1"
                                                title="{{ $submission->title }}">
                                                {{ Str::limit($submission->title, 50) }}
                                            </div>
                                            <div class="text-xs text-gray-400 font-mono">ID: #{{ $submission->id }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div
                                                    class="w-6 h-6 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-bold mr-2">
                                                    {{ substr($submission->author->full_name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="text-sm text-gray-700 font-medium">
                                                        {{ $submission->author->full_name }}</div>
                                                    <div class="text-[10px] text-gray-400">{{ $submission->author->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @php
                                                $statusColors = [
                                                    'submitted' => 'bg-yellow-100 text-yellow-700',
                                                    'under_review' => 'bg-blue-100 text-blue-700',
                                                    'accepted' => 'bg-green-100 text-green-700',
                                                    'rejected' => 'bg-red-100 text-red-700',
                                                    'published' => 'bg-purple-100 text-purple-700',
                                                    'revision_requested' => 'bg-orange-100 text-orange-700',
                                                    'withdrawn' => 'bg-gray-100 text-gray-600',
                                                ];
                                                $cls = $statusColors[$submission->status] ?? 'bg-gray-50 text-gray-500';
                                            @endphp
                                            <span
                                                class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider {{ $cls }}">
                                                {{ str_replace('_', ' ', $submission->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-xs text-gray-500">
                                            {{ $submission->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('editor.submissions.show', [$journal, $submission]) }}"
                                                    class="text-gray-400 hover:text-cisa-base transition-colors" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if(in_array($submission->status, ['submitted', 'under_review']))
                                                    <a href="{{ route('editor.submissions.show', [$journal, $submission]) }}#actions"
                                                        class="text-cisa-accent hover:text-cisa-base transition-colors"
                                                        title="Decision">
                                                        <i class="fas fa-gavel"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-16 text-center">
                        <div
                            class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                            <i class="fas fa-inbox text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-500 mb-2">No submissions found</h3>
                        <p class="text-gray-400 text-sm">Use the filters above or wait for new submissions.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            @if($notifications->count() > 0)
                window.addEventListener('DOMContentLoaded', function () {
                    setTimeout(function () { showNotificationPopup(); }, 1000);
                });
            @endif

                function showNotificationPopup() {
                    document.getElementById('notificationPopup').classList.remove('hidden');
                }

            function hideNotificationPopup() {
                document.getElementById('notificationPopup').classList.add('hidden');
            }

            function markAsRead(notificationId) {
                fetch(`/notifications/${notificationId}/read`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const item = document.querySelector(`[data-notification-id="${notificationId}"]`);
                            if (item) {
                                item.style.opacity = '0.5';
                                item.style.pointerEvents = 'none';
                            }
                        }
                    })
                    .catch(console.error);
            }

            function markAllAsRead() {
                const ids = Array.from(document.querySelectorAll('.notification-item')).map(el => el.dataset.notificationId);
                fetch('/notifications/mark-all-read', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ notification_ids: ids })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            hideNotificationPopup();
                            setTimeout(() => window.location.reload(), 500);
                        }
                    })
                    .catch(console.error);
            }

            document.addEventListener('click', function (event) {
                const popup = document.getElementById('notificationPopup');
                // Only close if clicking the backdrop (not the modal content itself)
                if (popup && event.target === popup) {
                    hideNotificationPopup();
                }
            });
        </script>
    @endpush
@endsection