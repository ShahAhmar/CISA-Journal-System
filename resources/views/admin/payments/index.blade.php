@extends('layouts.admin')

@section('title', 'Payments Management - EMANP')
@section('page-title', 'Payments Management')
@section('page-subtitle', 'View and manage all payment transactions')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-semibold">Total Payments</p>
                    <p class="text-3xl font-bold mt-2">{{ number_format($stats['total']) }}</p>
                </div>
                <i class="fas fa-credit-card text-4xl opacity-50"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-semibold">Completed</p>
                    <p class="text-3xl font-bold mt-2">{{ number_format($stats['completed']) }}</p>
                </div>
                <i class="fas fa-check-circle text-4xl opacity-50"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-semibold">Pending</p>
                    <p class="text-3xl font-bold mt-2">{{ number_format($stats['pending']) }}</p>
                </div>
                <i class="fas fa-clock text-4xl opacity-50"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-semibold">Total Revenue</p>
                    <p class="text-3xl font-bold mt-2">${{ number_format($stats['total_amount'], 2) }}</p>
                    <p class="text-purple-100 text-xs mt-1">Today: ${{ number_format($stats['today_amount'], 2) }}</p>
                </div>
                <i class="fas fa-dollar-sign text-4xl opacity-50"></i>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold text-[#0F1B4C]">
                <i class="fas fa-credit-card mr-2 text-[#0056FF]"></i>Payment Management
            </h3>
            <a href="{{ route('admin.payments.create') }}" 
               class="px-6 py-3 bg-gradient-to-r from-[#0056FF] to-indigo-600 hover:from-[#0044CC] hover:to-indigo-700 text-white rounded-lg font-semibold transition-colors shadow-lg">
                <i class="fas fa-plus mr-2"></i>Create Payment
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6">
        <form method="GET" action="{{ route('admin.payments.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF]">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                    <option value="refunded" {{ request('status') === 'refunded' ? 'selected' : '' }}>Refunded</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Type</label>
                <select name="type" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF]">
                    <option value="">All Types</option>
                    <option value="apc" {{ request('type') === 'apc' ? 'selected' : '' }}>APC</option>
                    <option value="submission_fee" {{ request('type') === 'submission_fee' ? 'selected' : '' }}>Submission Fee</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Journal</label>
                <select name="journal_id" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF]">
                    <option value="">All Journals</option>
                    @foreach($journals as $journal)
                    <option value="{{ $journal->id }}" {{ request('journal_id') == $journal->id ? 'selected' : '' }}>
                        {{ $journal->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Date From</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" 
                       class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF]">
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Date To</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" 
                       class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF]">
            </div>
            
            <div class="md:col-span-5 flex items-center space-x-3">
                <button type="submit" class="px-6 py-2 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors">
                    <i class="fas fa-filter mr-2"></i>Apply Filters
                </button>
                <a href="{{ route('admin.payments.index') }}" class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-semibold transition-colors">
                    <i class="fas fa-redo mr-2"></i>Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Payments Table -->
    <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-[#0F1B4C]">
                <i class="fas fa-list mr-2 text-[#0056FF]"></i>All Payments
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-[#0056FF] to-[#1D72B8]">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Journal</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">User</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Type</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Amount</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Method</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Date</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-white uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($payments as $payment)
                    <tr class="hover:bg-blue-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900">#{{ $payment->id }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-semibold text-gray-900">{{ $payment->journal->name }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-700">{{ $payment->user->full_name }}</div>
                            <div class="text-xs text-gray-500">{{ $payment->user->email }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                {{ $payment->type === 'apc' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $payment->type === 'apc' ? 'APC' : 'Submission Fee' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-[#0F1B4C]">
                                {{ $payment->currency }} {{ number_format($payment->amount, 2) }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-700">
                                @if($payment->payment_method)
                                    <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs font-semibold">
                                        {{ ucfirst($payment->payment_method) }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                {{ $payment->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                   ($payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($payment->status === 'failed' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-700">{{ $payment->created_at->format('M d, Y') }}</div>
                            <div class="text-xs text-gray-500">{{ $payment->created_at->format('h:i A') }}</div>
                        </td>
                        <td class="px-6 py-4 text-right text-sm font-medium">
                            <a href="{{ route('admin.payments.show', $payment) }}" 
                               class="text-[#0056FF] hover:text-[#0044CC] font-semibold">
                                <i class="fas fa-eye mr-1"></i>View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-12 text-center">
                            <i class="fas fa-credit-card text-6xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500 text-lg font-semibold">No payments found</p>
                            <p class="text-gray-400">Payments will appear here when transactions are made</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($payments->hasPages())
        <div class="p-6 border-t border-gray-200">
            {{ $payments->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

