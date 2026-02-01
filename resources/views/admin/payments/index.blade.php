@extends('layouts.admin')

@section('title', 'Payments Management - CISA')
@section('page-title', 'Payments Management')
@section('page-subtitle', 'View and manage all payment transactions')

@section('content')
    <div class="space-y-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Total Payments</p>
                    <p class="text-3xl font-bold text-cisa-base">{{ number_format($stats['total']) }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                    <i class="fas fa-credit-card"></i>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Completed</p>
                    <p class="text-3xl font-bold text-emerald-600">{{ number_format($stats['completed']) }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Pending</p>
                    <p class="text-3xl font-bold text-amber-500">{{ number_format($stats['pending']) }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                    <i class="fas fa-clock"></i>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Total Revenue</p>
                    <p class="text-2xl font-bold text-cisa-accent">${{ number_format($stats['total_amount'], 2) }}</p>
                    <p class="text-xs text-gray-400 mt-1">Today: ${{ number_format($stats['today_amount'], 2) }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-amber-50 text-cisa-accent flex items-center justify-center text-xl">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>
        </div>

        <!-- Actions & Filters -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-bold text-cisa-base flex items-center gap-2">
                    <i class="fas fa-filter text-cisa-accent"></i> Filter Payments
                </h3>
                <a href="{{ route('admin.payments.create') }}"
                    class="px-4 py-2.5 bg-cisa-accent hover:bg-amber-600 text-white font-bold rounded-lg shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all text-sm">
                    <i class="fas fa-plus mr-2"></i>Create Payment
                </a>
            </div>

            <form method="GET" action="{{ route('admin.payments.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Status</label>
                    <select name="status"
                        class="w-full px-3 py-2 bg-slate-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-cisa-accent">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Awaiting Payment
                        </option>
                        <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Awaiting Review
                            (Proof Uploaded)</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="refunded" {{ request('status') === 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Type</label>
                    <select name="type"
                        class="w-full px-3 py-2 bg-slate-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-cisa-accent">
                        <option value="">All Types</option>
                        <option value="apc" {{ request('type') === 'apc' ? 'selected' : '' }}>APC</option>
                        <option value="submission_fee" {{ request('type') === 'submission_fee' ? 'selected' : '' }}>Submission
                            Fee</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Journal</label>
                    <select name="journal_id"
                        class="w-full px-3 py-2 bg-slate-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-cisa-accent">
                        <option value="">All Journals</option>
                        @foreach($journals as $journal)
                            <option value="{{ $journal->id }}" {{ request('journal_id') == $journal->id ? 'selected' : '' }}>
                                {{ $journal->journal_initials ?? Str::limit($journal->name, 15) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Date From</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                        class="w-full px-3 py-2 bg-slate-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-cisa-accent">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Date To</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}"
                        class="w-full px-3 py-2 bg-slate-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-cisa-accent">
                </div>

                <div class="md:col-span-5 flex items-center gap-3">
                    <button type="submit"
                        class="px-6 py-2 bg-cisa-base hover:bg-slate-800 text-white rounded-lg font-bold transition-all text-sm">
                        <i class="fas fa-filter mr-2"></i>Apply Filters
                    </button>
                    <a href="{{ route('admin.payments.index') }}"
                        class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-bold transition-colors text-sm">
                        <i class="fas fa-redo mr-2"></i>Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Payments Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 border-b border-gray-100">
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Journal / User
                            </th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Method</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($payments as $payment)
                            <tr class="hover:bg-slate-50 transition-colors group">
                                <td class="px-6 py-4">
                                    <span class="font-mono text-xs text-gray-400">#{{ $payment->id }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-sm text-cisa-base">{{ strip_tags($payment->journal->name) }}
                                    </div>
                                    <div class="text-xs text-gray-500">{{ $payment->user->full_name }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $typeClass = $payment->type === 'apc' ? 'bg-purple-50 text-purple-700 border-purple-100' : 'bg-blue-50 text-blue-700 border-blue-100';
                                    @endphp
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold border {{ $typeClass }}">
                                        {{ $payment->type === 'apc' ? 'APC' : 'Submission Fee' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-cisa-accent">{{ $payment->currency }}
                                        {{ number_format($payment->amount, 2) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($payment->payment_method)
                                        <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs font-semibold">
                                            {{ ucfirst($payment->payment_method) }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColors = [
                                            'completed' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                            'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                                            'processing' => 'bg-blue-50 text-blue-600 border-blue-100',
                                            'failed' => 'bg-red-50 text-red-600 border-red-100',
                                            'refunded' => 'bg-gray-100 text-gray-600 border-gray-200'
                                        ];
                                        $statusClass = $statusColors[$payment->status] ?? 'bg-gray-100 text-gray-600 border-gray-200';
                                    @endphp
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $statusClass }}">
                                        @if($payment->status === 'completed')
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        @endif
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-700">{{ $payment->created_at->format('M d, Y') }}</div>
                                    <div class="text-xs text-gray-400">{{ $payment->created_at->format('h:i A') }}</div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.payments.show', $payment) }}"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-50 text-gray-400 hover:text-cisa-base hover:bg-white border border-transparent hover:border-gray-200 shadow-sm transition-all"
                                        title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-16 text-center">
                                    <div
                                        class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                                        <i class="fas fa-credit-card text-2xl"></i>
                                    </div>
                                    <h3 class="text-sm font-bold text-gray-900 mb-1">No payments found</h3>
                                    <p class="text-xs text-gray-500">Payments will appear here when transactions are made.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($payments->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-slate-50">
                    {{ $payments->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection