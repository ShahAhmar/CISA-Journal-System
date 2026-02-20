@extends('layouts.admin')

@section('title', 'Subscriptions - EMANP')
@section('page-title', 'Subscription Management')
@section('page-subtitle', 'Manage journal subscriptions')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl border-2 border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-xl font-bold text-[#0F1B4C]">Subscriptions</h3>
                <p class="text-gray-600 mt-1">Manage individual and institutional subscriptions</p>
            </div>
            <a href="{{ route('admin.subscriptions.create') }}" 
               class="px-6 py-3 bg-gradient-to-r from-[#0056FF] to-indigo-600 hover:from-[#0044CC] hover:to-indigo-700 text-white rounded-lg font-semibold transition-colors shadow-lg">
                <i class="fas fa-plus mr-2"></i>Create Subscription
            </a>
        </div>
    </div>

    <!-- Subscriptions List -->
    <div class="bg-white rounded-xl border-2 border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-[#0056FF] to-[#1D72B8]">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">User</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Journal</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Type</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Start Date</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">End Date</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($subscriptions as $subscription)
                    <tr class="hover:bg-blue-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900">{{ $subscription->user->full_name ?? 'N/A' }}</div>
                            <div class="text-xs text-gray-500">{{ $subscription->user->email ?? '' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $subscription->journal->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-semibold">
                                {{ ucfirst($subscription->type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold 
                                {{ $subscription->status === 'active' ? 'bg-green-100 text-green-700' : 
                                   ($subscription->status === 'expired' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700') }}">
                                {{ ucfirst($subscription->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $subscription->start_date->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $subscription->end_date->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.subscriptions.show', $subscription) }}" class="text-[#0056FF] hover:text-[#0044CC]">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.subscriptions.edit', $subscription) }}" class="text-green-600 hover:text-green-700">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.subscriptions.destroy', $subscription) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-user-tag text-4xl mb-3 text-gray-400"></i>
                            <p>No subscriptions found</p>
                            <a href="{{ route('admin.subscriptions.create') }}" class="text-[#0056FF] hover:text-[#0044CC] font-semibold mt-2 inline-block">
                                Create First Subscription
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($subscriptions->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $subscriptions->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

