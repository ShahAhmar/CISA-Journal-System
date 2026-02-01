@extends('layouts.admin')

@section('title', 'Admin Dashboard | CISA')
@section('page-title', 'Admin Dashboard')
@section('page-subtitle', 'Comprehensive overview of your journal publishing platform')

@section('content')
    <!-- Hero Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Total Journals -->
        <a href="{{ route('admin.journals.index') }}"
            class="group bg-white rounded-xl p-6 border border-gray-100 shadow-sm hover:shadow-lg hover:border-cisa-accent transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div
                    class="w-14 h-14 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fas fa-book text-2xl"></i>
                </div>
                <div class="text-right">
                    <div
                        class="text-3xl font-serif font-bold text-cisa-base group-hover:text-cisa-accent transition-colors">
                        {{ $stats['journals'] }}</div>
                    <div class="text-sm font-bold text-gray-400 uppercase tracking-wider">Total Journals</div>
                </div>
            </div>
            <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                <span class="text-xs text-green-600 font-bold flex items-center bg-green-50 px-2 py-1 rounded">
                    <i class="fas fa-arrow-up mr-1"></i> 12%
                </span>
                <span class="text-xs text-gray-400">vs last month</span>
            </div>
        </a>

        <!-- Active Journals -->
        <a href="{{ route('admin.journals.index') }}"
            class="group bg-white rounded-xl p-6 border border-gray-100 shadow-sm hover:shadow-lg hover:border-cisa-accent transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div
                    class="w-14 h-14 bg-green-50 text-green-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
                <div class="text-right">
                    <div
                        class="text-3xl font-serif font-bold text-cisa-base group-hover:text-cisa-accent transition-colors">
                        {{ $stats['active_journals'] }}</div>
                    <div class="text-sm font-bold text-gray-400 uppercase tracking-wider">Active Journals</div>
                </div>
            </div>
            <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                <span class="text-xs text-green-600 font-bold flex items-center bg-green-50 px-2 py-1 rounded">
                    <i class="fas fa-arrow-up mr-1"></i> 8%
                </span>
                <span class="text-xs text-gray-400">vs last month</span>
            </div>
        </a>

        <!-- Total Users -->
        <a href="{{ route('admin.users.index') }}"
            class="group bg-white rounded-xl p-6 border border-gray-100 shadow-sm hover:shadow-lg hover:border-cisa-accent transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div
                    class="w-14 h-14 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fas fa-users text-2xl"></i>
                </div>
                <div class="text-right">
                    <div
                        class="text-3xl font-serif font-bold text-cisa-base group-hover:text-cisa-accent transition-colors">
                        {{ $stats['users'] }}</div>
                    <div class="text-sm font-bold text-gray-400 uppercase tracking-wider">Total Users</div>
                </div>
            </div>
            <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                <span class="text-xs text-green-600 font-bold flex items-center bg-green-50 px-2 py-1 rounded">
                    <i class="fas fa-arrow-up mr-1"></i> 15%
                </span>
                <span class="text-xs text-gray-400">vs last month</span>
            </div>
        </a>

        <!-- Total Submissions -->
        <a href="{{ route('admin.submissions.index') }}"
            class="group bg-white rounded-xl p-6 border border-gray-100 shadow-sm hover:shadow-lg hover:border-cisa-accent transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div
                    class="w-14 h-14 bg-orange-50 text-orange-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fas fa-file-upload text-2xl"></i>
                </div>
                <div class="text-right">
                    <div
                        class="text-3xl font-serif font-bold text-cisa-base group-hover:text-cisa-accent transition-colors">
                        {{ $stats['submissions'] }}</div>
                    <div class="text-sm font-bold text-gray-400 uppercase tracking-wider">Total Submissions</div>
                </div>
            </div>
            <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                <span class="text-xs text-green-600 font-bold flex items-center bg-green-50 px-2 py-1 rounded">
                    <i class="fas fa-arrow-up mr-1"></i> 22%
                </span>
                <span class="text-xs text-gray-400">vs last month</span>
            </div>
        </a>

        <!-- Pending Submissions -->
        <a href="{{ route('admin.submissions.index', ['status' => 'submitted']) }}"
            class="group bg-white rounded-xl p-6 border border-gray-100 shadow-sm hover:shadow-lg hover:border-cisa-accent transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div
                    class="w-14 h-14 bg-yellow-50 text-yellow-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fas fa-clock text-2xl"></i>
                </div>
                <div class="text-right">
                    <div
                        class="text-3xl font-serif font-bold text-cisa-base group-hover:text-cisa-accent transition-colors">
                        {{ $stats['pending_submissions'] }}</div>
                    <div class="text-sm font-bold text-gray-400 uppercase tracking-wider">Pending Review</div>
                </div>
            </div>
            <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                <span class="text-xs text-green-600 font-bold flex items-center bg-green-50 px-2 py-1 rounded">
                    <i class="fas fa-arrow-down mr-1"></i> 3%
                </span>
                <span class="text-xs text-gray-400">vs last month</span>
            </div>
        </a>

        <!-- Published Articles -->
        <a href="{{ route('admin.submissions.index', ['status' => 'published']) }}"
            class="group bg-white rounded-xl p-6 border border-gray-100 shadow-sm hover:shadow-lg hover:border-cisa-accent transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div
                    class="w-14 h-14 bg-teal-50 text-teal-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fas fa-check-double text-2xl"></i>
                </div>
                <div class="text-right">
                    <div
                        class="text-3xl font-serif font-bold text-cisa-base group-hover:text-cisa-accent transition-colors">
                        {{ $stats['published_articles'] }}</div>
                    <div class="text-sm font-bold text-gray-400 uppercase tracking-wider">Published Articles</div>
                </div>
            </div>
            <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                <span class="text-xs text-green-600 font-bold flex items-center bg-green-50 px-2 py-1 rounded">
                    <i class="fas fa-arrow-up mr-1"></i> 18%
                </span>
                <span class="text-xs text-gray-400">vs last month</span>
            </div>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Recent Journals -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-bold text-cisa-base font-serif flex items-center">
                    <span class="w-1 h-6 bg-cisa-accent mr-3 rounded-full"></span>
                    Recent Journals
                </h3>
                <a href="{{ route('admin.journals.index') }}"
                    class="text-xs font-bold text-gray-500 hover:text-cisa-accent flex items-center transition-colors">
                    VIEW ALL <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>

            <div class="p-6">
                @if($recentJournals->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentJournals as $journal)
                            <div
                                class="flex items-center justify-between p-4 bg-slate-50 rounded-xl hover:bg-white hover:shadow-md transition-all border border-transparent hover:border-gray-100 group">
                                <div class="flex items-center space-x-4">
                                    <div
                                        class="w-10 h-10 bg-white border border-gray-200 text-cisa-base rounded-lg flex items-center justify-center shadow-sm group-hover:border-cisa-accent/30 transition-colors">
                                        <i class="fas fa-book"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-cisa-base text-sm group-hover:text-cisa-accent transition-colors">
                                            {{ Str::limit(strip_tags($journal->name), 30) }}</h4>
                                        <p class="text-xs text-gray-500">{{ $journal->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <span
                                        class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider {{ $journal->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600' }}">
                                        {{ $journal->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                    <a href="{{ route('admin.journals.edit', $journal) }}"
                                        class="text-gray-400 hover:text-cisa-accent transition-colors" title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div
                            class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                            <i class="fas fa-book-open text-2xl"></i>
                        </div>
                        <p class="text-gray-500 font-medium mb-3">No journals yet</p>
                        <a href="{{ route('admin.journals.create') }}" class="btn-cisa-primary py-2 px-4 text-xs">
                            Create First Journal
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Submissions -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-bold text-cisa-base font-serif flex items-center">
                    <span class="w-1 h-6 bg-cisa-accent mr-3 rounded-full"></span>
                    Recent Submissions
                </h3>
                <a href="{{ route('admin.submissions.index') }}"
                    class="text-xs font-bold text-gray-500 hover:text-cisa-accent flex items-center transition-colors">
                    VIEW ALL <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>

            @if($recentSubmissions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-100 bg-slate-50">
                                <th class="text-left py-3 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Title
                                </th>
                                <th class="text-left py-3 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Status
                                </th>
                                <th class="text-left py-3 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Date
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($recentSubmissions as $submission)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="py-3 px-6">
                                        <div class="font-bold text-cisa-base text-sm mb-0.5">
                                            {{ Str::limit($submission->title, 25) }}</div>
                                        <div class="text-[11px] text-gray-400">
                                            {{ Str::limit($submission->author->full_name ?? 'N/A', 20) }}</div>
                                    </td>
                                    <td class="py-3 px-6">
                                        <span class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider
                                                    @if($submission->status == 'published') bg-green-100 text-green-700
                                                    @elseif($submission->status == 'submitted') bg-orange-100 text-orange-700
                                                    @elseif($submission->status == 'under_review') bg-blue-100 text-blue-700
                                                    @elseif($submission->status == 'accepted') bg-green-100 text-green-700
                                                    @else bg-gray-100 text-gray-600
                                                    @endif">
                                            {{ str_replace('_', ' ', $submission->status) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-6 text-xs text-gray-500 font-mono">
                                        {{ $submission->created_at->format('M d') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                        <i class="fas fa-file-alt text-2xl"></i>
                    </div>
                    <p class="text-gray-500">No submissions yet</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Pending Tasks -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm mb-8 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-bold text-cisa-base font-serif flex items-center">
                <span class="w-1 h-6 bg-cisa-accent mr-3 rounded-full"></span>
                Action Required
            </h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-0 divide-y md:divide-y-0 md:divide-x divide-gray-100">
            <!-- Review Requests -->
            <a href="{{ route('admin.reviews.index') }}?status=pending"
                class="p-8 hover:bg-slate-50 transition-colors group text-center md:text-left">
                <div class="flex flex-col md:flex-row items-center md:items-start justify-between mb-4">
                    <div
                        class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-3 md:mb-0 group-hover:scale-110 transition-transform">
                        <i class="fas fa-user-check text-xl"></i>
                    </div>
                    <span
                        class="text-3xl font-serif font-bold text-cisa-base group-hover:text-cisa-accent transition-colors">{{ $pendingTasks['review_requests'] ?? 0 }}</span>
                </div>
                <h4 class="font-bold text-gray-800">Review Requests</h4>
                <p class="text-sm text-gray-500 mt-1">Pending reviewer assignments</p>
            </a>

            <!-- Revision Submissions -->
            <a href="{{ route('admin.submissions.index', ['status' => 'revision_required']) }}"
                class="p-8 hover:bg-slate-50 transition-colors group text-center md:text-left">
                <div class="flex flex-col md:flex-row items-center md:items-start justify-between mb-4">
                    <div
                        class="w-12 h-12 bg-orange-50 text-orange-600 rounded-xl flex items-center justify-center mb-3 md:mb-0 group-hover:scale-110 transition-transform">
                        <i class="fas fa-edit text-xl"></i>
                    </div>
                    <span
                        class="text-3xl font-serif font-bold text-cisa-base group-hover:text-cisa-accent transition-colors">{{ $pendingTasks['revision_submissions'] ?? 0 }}</span>
                </div>
                <h4 class="font-bold text-gray-800">Revisions</h4>
                <p class="text-sm text-gray-500 mt-1">Submissions requiring approval</p>
            </a>

            <!-- Decisions Required -->
            <a href="{{ route('admin.submissions.index', ['status' => 'submitted']) }}"
                class="p-8 hover:bg-slate-50 transition-colors group text-center md:text-left">
                <div class="flex flex-col md:flex-row items-center md:items-start justify-between mb-4">
                    <div
                        class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center mb-3 md:mb-0 group-hover:scale-110 transition-transform">
                        <i class="fas fa-gavel text-xl"></i>
                    </div>
                    <span
                        class="text-3xl font-serif font-bold text-cisa-base group-hover:text-cisa-accent transition-colors">{{ $pendingTasks['decisions_required'] ?? 0 }}</span>
                </div>
                <h4 class="font-bold text-gray-800">Decisions</h4>
                <p class="text-sm text-gray-500 mt-1">Awaiting editorial decision</p>
            </a>
        </div>
    </div>

    <!-- Activity Log -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <h3 class="text-lg font-bold text-cisa-base font-serif mb-6 flex items-center">
            <i class="fas fa-history mr-3 text-gray-400"></i>Recent System Activity
        </h3>

        <div class="space-y-4">
            <div class="flex items-start space-x-4 p-4 bg-slate-50 rounded-lg border border-gray-100">
                <div
                    class="w-8 h-8 bg-white border border-gray-200 rounded-full flex items-center justify-center flex-shrink-0 text-cisa-base shadow-sm">
                    <i class="fas fa-user text-xs"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm text-gray-700 font-medium">
                        <span class="text-cisa-base font-bold">{{ auth()->user()->full_name }}</span> accessed the admin
                        dashboard
                    </p>
                    <p class="text-xs text-gray-400 mt-1">{{ now()->format('M d, Y h:i A') }}</p>
                </div>
            </div>

            <!-- Placeholder static activities for design -->
            <div class="flex items-start space-x-4 p-4 bg-slate-50 rounded-lg border border-gray-100">
                <div
                    class="w-8 h-8 bg-white border border-gray-200 rounded-full flex items-center justify-center flex-shrink-0 text-green-600 shadow-sm">
                    <i class="fas fa-check text-xs"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm text-gray-700 font-medium">
                        System health check completed successfully
                    </p>
                    <p class="text-xs text-gray-400 mt-1">{{ now()->subHours(5)->format('M d, Y h:i A') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection