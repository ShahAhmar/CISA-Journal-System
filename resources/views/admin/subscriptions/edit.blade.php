@extends('layouts.admin')

@section('title', 'Edit Subscription - EMANP')
@section('page-title', 'Edit Subscription')
@section('page-subtitle', 'Update subscription details')

@section('content')
<div class="bg-white rounded-xl border-2 border-gray-200 p-6 max-w-4xl mx-auto">
    <form method="POST" action="{{ route('admin.subscriptions.update', $subscription) }}">
        @csrf
        @method('PUT')
        
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">User *</label>
                    <select name="user_id" required class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id', $subscription->user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->full_name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Journal *</label>
                    <select name="journal_id" required class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                        @foreach($journals as $journal)
                            <option value="{{ $journal->id }}" {{ old('journal_id', $subscription->journal_id) == $journal->id ? 'selected' : '' }}>
                                {{ $journal->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Type *</label>
                    <select name="type" required class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                        <option value="individual" {{ old('type', $subscription->type) == 'individual' ? 'selected' : '' }}>Individual</option>
                        <option value="institutional" {{ old('type', $subscription->type) == 'institutional' ? 'selected' : '' }}>Institutional</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status *</label>
                    <select name="status" required class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                        <option value="active" {{ old('status', $subscription->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="expired" {{ old('status', $subscription->status) == 'expired' ? 'selected' : '' }}>Expired</option>
                        <option value="cancelled" {{ old('status', $subscription->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Start Date *</label>
                    <input type="date" name="start_date" value="{{ old('start_date', $subscription->start_date->format('Y-m-d')) }}" required 
                           class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">End Date *</label>
                    <input type="date" name="end_date" value="{{ old('end_date', $subscription->end_date->format('Y-m-d')) }}" required 
                           class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Renewal Date</label>
                    <input type="date" name="renewal_date" value="{{ old('renewal_date', $subscription->renewal_date?->format('Y-m-d')) }}" 
                           class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Amount</label>
                    <input type="number" name="amount" value="{{ old('amount', $subscription->amount) }}" step="0.01" min="0"
                           class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Payment Method</label>
                    <input type="text" name="payment_method" value="{{ old('payment_method', $subscription->payment_method) }}"
                           class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Notes</label>
                <textarea name="notes" rows="3" 
                          class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-[#0056FF]">{{ old('notes', $subscription->notes) }}</textarea>
            </div>

            <div class="flex space-x-3 pt-4">
                <button type="submit" class="px-6 py-3 bg-[#0056FF] text-white rounded-lg hover:bg-[#0044CC] transition-colors font-semibold">
                    <i class="fas fa-save mr-2"></i>Update Subscription
                </button>
                <a href="{{ route('admin.subscriptions.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-semibold">
                    Cancel
                </a>
            </div>
        </div>
    </form>
</div>
@endsection

