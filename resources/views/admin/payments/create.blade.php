@extends('layouts.admin')

@section('title', 'Create Payment - EMANP')
@section('page-title', 'Create New Payment')
@section('page-subtitle', 'Add payment record manually')

@section('content')
<div class="max-w-4xl mx-auto">
    <form method="POST" action="{{ route('admin.payments.store') }}" class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-8 space-y-6">
        @csrf
        
        <!-- Journal Selection -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Journal <span class="text-red-500">*</span>
            </label>
            <select name="journal_id" required
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF]">
                <option value="">Select Journal</option>
                @foreach($journals as $journal)
                <option value="{{ $journal->id }}" {{ old('journal_id') == $journal->id ? 'selected' : '' }}>
                    {{ $journal->name }}
                </option>
                @endforeach
            </select>
            @error('journal_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- User Selection -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                User <span class="text-red-500">*</span>
            </label>
            <select name="user_id" required
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF]">
                <option value="">Select User</option>
                @foreach($users as $user)
                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                    {{ $user->full_name }} ({{ $user->email }})
                </option>
                @endforeach
            </select>
            @error('user_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Payment Type -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Payment Type <span class="text-red-500">*</span>
            </label>
            <select name="type" required
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF]">
                <option value="">Select Type</option>
                <option value="apc" {{ old('type') === 'apc' ? 'selected' : '' }}>Article Processing Charge (APC)</option>
                <option value="submission_fee" {{ old('type') === 'submission_fee' ? 'selected' : '' }}>Submission Fee</option>
            </select>
            @error('type')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Amount & Currency -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Amount <span class="text-red-500">*</span>
                </label>
                <input type="number" name="amount" step="0.01" min="0" required
                       value="{{ old('amount') }}"
                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF]"
                       placeholder="0.00">
                @error('amount')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Currency <span class="text-red-500">*</span>
                </label>
                <select name="currency" required
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF]">
                    <option value="USD" {{ old('currency', 'USD') === 'USD' ? 'selected' : '' }}>USD</option>
                    <option value="EUR" {{ old('currency') === 'EUR' ? 'selected' : '' }}>EUR</option>
                    <option value="GBP" {{ old('currency') === 'GBP' ? 'selected' : '' }}>GBP</option>
                    <option value="PKR" {{ old('currency') === 'PKR' ? 'selected' : '' }}>PKR</option>
                    <option value="INR" {{ old('currency') === 'INR' ? 'selected' : '' }}>INR</option>
                </select>
                @error('currency')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Payment Method -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Payment Method
            </label>
            <select name="payment_method"
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF]">
                <option value="">Select Payment Method</option>
                <option value="stripe" {{ old('payment_method') === 'stripe' ? 'selected' : '' }}>Stripe</option>
                <option value="paypal" {{ old('payment_method') === 'paypal' ? 'selected' : '' }}>PayPal</option>
                <option value="bank_transfer" {{ old('payment_method') === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                <option value="manual" {{ old('payment_method') === 'manual' ? 'selected' : '' }}>Manual Entry</option>
                <option value="cash" {{ old('payment_method') === 'cash' ? 'selected' : '' }}>Cash</option>
                <option value="check" {{ old('payment_method') === 'check' ? 'selected' : '' }}>Check</option>
            </select>
            @error('payment_method')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Transaction ID -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Transaction ID
            </label>
            <input type="text" name="transaction_id"
                   value="{{ old('transaction_id') }}"
                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF]"
                   placeholder="Enter transaction ID (optional)">
            @error('transaction_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Status -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Status <span class="text-red-500">*</span>
            </label>
            <select name="status" required
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF]">
                <option value="pending" {{ old('status', 'pending') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="failed" {{ old('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                <option value="refunded" {{ old('status') === 'refunded' ? 'selected' : '' }}>Refunded</option>
            </select>
            @error('status')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submission (Optional) -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Related Submission (Optional)
            </label>
            <input type="number" name="submission_id"
                   value="{{ old('submission_id') }}"
                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF]"
                   placeholder="Submission ID (optional)">
            <p class="text-xs text-gray-500 mt-1">Enter submission ID if this payment is related to a specific article</p>
            @error('submission_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Notes -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Notes (Optional)
            </label>
            <textarea name="notes" rows="4"
                      class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF]"
                      placeholder="Add any additional notes about this payment...">{{ old('notes') }}</textarea>
            @error('notes')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
            <a href="{{ route('admin.payments.index') }}" 
               class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-semibold transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Cancel
            </a>
            <button type="submit" 
                    class="px-6 py-3 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors shadow-lg">
                <i class="fas fa-save mr-2"></i>Create Payment
            </button>
        </div>
    </form>
</div>
@endsection

