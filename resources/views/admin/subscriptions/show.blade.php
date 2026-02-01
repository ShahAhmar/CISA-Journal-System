@extends('layouts.admin')

@section('title', 'Subscription Details - EMANP')
@section('page-title', 'Subscription Details')
@section('page-subtitle', 'View subscription information')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl border-2 border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-xl font-bold text-[#0F1B4C]">Subscription #{{ $subscription->id }}</h3>
                <p class="text-gray-600 mt-1">{{ $subscription->user->full_name ?? 'N/A' }} - {{ $subscription->journal->name ?? 'N/A' }}</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.subscriptions.edit', $subscription) }}" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors font-semibold">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <a href="{{ route('admin.subscriptions.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-semibold">
                    Back
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="font-bold text-[#0F1B4C] mb-4">User Information</h4>
                <div class="space-y-2 text-sm">
                    <div><span class="text-gray-600">Name:</span> <span class="font-semibold">{{ $subscription->user->full_name ?? 'N/A' }}</span></div>
                    <div><span class="text-gray-600">Email:</span> <span class="font-semibold">{{ $subscription->user->email ?? 'N/A' }}</span></div>
                </div>
            </div>

            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="font-bold text-[#0F1B4C] mb-4">Journal Information</h4>
                <div class="space-y-2 text-sm">
                    <div><span class="text-gray-600">Journal:</span> <span class="font-semibold">{{ $subscription->journal->name ?? 'N/A' }}</span></div>
                </div>
            </div>

            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="font-bold text-[#0F1B4C] mb-4">Subscription Details</h4>
                <div class="space-y-2 text-sm">
                    <div><span class="text-gray-600">Type:</span> <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded text-xs font-semibold">{{ ucfirst($subscription->type) }}</span></div>
                    <div><span class="text-gray-600">Status:</span> 
                        <span class="px-2 py-1 rounded text-xs font-semibold {{ $subscription->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($subscription->status) }}
                        </span>
                    </div>
                    <div><span class="text-gray-600">Start Date:</span> <span class="font-semibold">{{ $subscription->start_date->format('M d, Y') }}</span></div>
                    <div><span class="text-gray-600">End Date:</span> <span class="font-semibold">{{ $subscription->end_date->format('M d, Y') }}</span></div>
                    @if($subscription->renewal_date)
                    <div><span class="text-gray-600">Renewal Date:</span> <span class="font-semibold">{{ $subscription->renewal_date->format('M d, Y') }}</span></div>
                    @endif
                </div>
            </div>

            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="font-bold text-[#0F1B4C] mb-4">Payment Information</h4>
                <div class="space-y-2 text-sm">
                    @if($subscription->amount)
                    <div><span class="text-gray-600">Amount:</span> <span class="font-semibold">${{ number_format($subscription->amount, 2) }}</span></div>
                    @endif
                    @if($subscription->payment_method)
                    <div><span class="text-gray-600">Payment Method:</span> <span class="font-semibold">{{ $subscription->payment_method }}</span></div>
                    @endif
                </div>
            </div>
        </div>

        @if($subscription->notes)
        <div class="mt-6 bg-gray-50 rounded-lg p-4">
            <h4 class="font-bold text-[#0F1B4C] mb-2">Notes</h4>
            <p class="text-sm text-gray-700">{{ $subscription->notes }}</p>
        </div>
        @endif
    </div>
</div>
@endsection

