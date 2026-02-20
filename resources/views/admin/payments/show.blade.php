@extends('layouts.admin')

@section('title', 'Payment Details - #' . $payment->id)
@section('page-title', 'Payment Details')
@section('page-subtitle', 'Transaction #' . $payment->id)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Payment Info Card -->
    <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-[#0F1B4C]">Payment Information</h3>
            <span class="px-4 py-2 rounded-full text-sm font-semibold
                {{ $payment->status === 'completed' ? 'bg-green-100 text-green-800' : 
                   ($payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                   ($payment->status === 'failed' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                {{ ucfirst($payment->status) }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Payment ID</label>
                <p class="text-lg font-bold text-[#0F1B4C]">#{{ $payment->id }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Transaction ID</label>
                <p class="text-lg font-semibold text-[#0056FF]">{{ $payment->transaction_id ?? 'N/A' }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Journal</label>
                <p class="text-lg text-[#0F1B4C]">{{ $payment->journal->name }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">User</label>
                <p class="text-lg text-[#0F1B4C]">{{ $payment->user->full_name }}</p>
                <p class="text-sm text-gray-500">{{ $payment->user->email }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Payment Type</label>
                <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                    {{ $payment->type === 'apc' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                    {{ $payment->type === 'apc' ? 'Article Processing Charge (APC)' : 'Submission Fee' }}
                </span>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Amount</label>
                <p class="text-2xl font-bold text-[#0056FF]">
                    {{ $payment->currency }} {{ number_format($payment->amount, 2) }}
                </p>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Payment Method</label>
                <p class="text-lg text-[#0F1B4C]">
                    {{ $payment->payment_method ? ucfirst($payment->payment_method) : 'N/A' }}
                </p>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Date</label>
                <p class="text-lg text-[#0F1B4C]">{{ $payment->created_at->format('F d, Y h:i A') }}</p>
            </div>
        </div>

        @if($payment->submission)
        <div class="mt-6 pt-6 border-t border-gray-200">
            <label class="block text-sm font-semibold text-gray-600 mb-2">Related Submission</label>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="font-semibold text-[#0F1B4C]">{{ $payment->submission->title }}</p>
                <a href="{{ route('admin.submissions.show', $payment->submission) }}" 
                   class="text-[#0056FF] hover:text-[#0044CC] text-sm font-semibold mt-2 inline-flex items-center">
                    <i class="fas fa-external-link-alt mr-1"></i>View Submission
                </a>
            </div>
        </div>
        @endif

        @if($payment->payment_details)
        <div class="mt-6 pt-6 border-t border-gray-200">
            <label class="block text-sm font-semibold text-gray-600 mb-2">Payment Details</label>
            <div class="bg-gray-50 rounded-lg p-4">
                <pre class="text-xs text-gray-700">{{ json_encode($payment->payment_details, JSON_PRETTY_PRINT) }}</pre>
            </div>
        </div>
        @endif
    </div>

    <!-- Update Payment -->
    <div class="bg-white rounded-xl shadow-lg border-2 border-gray-200 p-6">
        <h3 class="text-lg font-bold text-[#0F1B4C] mb-4">Update Payment Details</h3>
        <form method="POST" action="{{ route('admin.payments.update', $payment) }}">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Payment Method</label>
                    <select name="payment_method" 
                            class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF]">
                        <option value="">Select Payment Method</option>
                        <option value="stripe" {{ $payment->payment_method === 'stripe' ? 'selected' : '' }}>Stripe</option>
                        <option value="paypal" {{ $payment->payment_method === 'paypal' ? 'selected' : '' }}>PayPal</option>
                        <option value="bank_transfer" {{ $payment->payment_method === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        <option value="manual" {{ $payment->payment_method === 'manual' ? 'selected' : '' }}>Manual Entry</option>
                        <option value="cash" {{ $payment->payment_method === 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="check" {{ $payment->payment_method === 'check' ? 'selected' : '' }}>Check</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Transaction ID</label>
                    <input type="text" name="transaction_id" 
                           value="{{ $payment->transaction_id }}"
                           class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF]"
                           placeholder="Enter transaction ID">
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                    <select name="status" required
                            class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF]">
                        <option value="pending" {{ $payment->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ $payment->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="failed" {{ $payment->status === 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="refunded" {{ $payment->status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Notes</label>
                    <textarea name="notes" rows="3"
                              class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-[#0056FF]"
                              placeholder="Add notes...">{{ $payment->payment_details['notes'] ?? '' }}</textarea>
                </div>
            </div>
            
            <div class="flex items-center justify-end">
                <button type="submit" 
                        class="px-6 py-2 bg-[#0056FF] hover:bg-[#0044CC] text-white rounded-lg font-semibold transition-colors">
                    <i class="fas fa-save mr-2"></i>Update Payment
                </button>
            </div>
        </form>
    </div>

    <!-- Actions -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.payments.index') }}" 
           class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-semibold transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Back to Payments
        </a>
    </div>
</div>
@endsection

