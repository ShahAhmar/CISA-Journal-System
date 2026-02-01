@extends('layouts.admin')

@section('title', 'Edit Payment Method - CISA')
@section('page-title', 'Configure Method')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border-2 border-slate-100">
            <!-- Header -->
            <div class="bg-cisa-base p-8 border-b-4 border-cisa-accent flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-black text-white uppercase tracking-tight">UPDATE CONFIGURATION</h2>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-1">Editing:
                        {{ $paymentMethod->name }}
                    </p>
                </div>
                <i class="fas fa-sliders-h text-4xl text-cisa-accent/20"></i>
            </div>

            <form method="POST" action="{{ route('admin.payment-methods.update', $paymentMethod) }}" class="p-8">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Name -->
                    <div class="space-y-2">
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest">Method Name</label>
                        <input type="text" name="name" required value="{{ $paymentMethod->name }}"
                            class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-cisa-accent focus:bg-white outline-none transition-all font-bold text-cisa-base">
                        @error('name') <p class="text-red-500 text-xs font-bold">{{ $message }}</p> @enderror
                    </div>

                    <!-- Type -->
                    <div class="space-y-2">
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest">Method Type</label>
                        <select name="type" required
                            class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-cisa-accent focus:bg-white outline-none transition-all font-bold text-cisa-base">
                            <option value="manual" {{ $paymentMethod->type === 'manual' ? 'selected' : '' }}>Manual (Bank,
                                Mobile, etc.)</option>
                            <option value="gateway" {{ $paymentMethod->type === 'gateway' ? 'selected' : '' }}>Automatic
                                Gateway (API)</option>
                        </select>
                    </div>

                    <!-- Journal -->
                    <div class="space-y-2">
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest">Journal
                            Assignment</label>
                        <select name="journal_id"
                            class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-cisa-accent focus:bg-white outline-none transition-all font-bold text-cisa-base">
                            <option value="">Global (All Journals)</option>
                            @foreach($journals as $journal)
                                <option value="{{ $journal->id }}" {{ $paymentMethod->journal_id == $journal->id ? 'selected' : '' }}>{{ $journal->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Amount & Currency -->
                    <div class="space-y-2">
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest">Pricing
                            (Optional)</label>
                        <div class="flex gap-2">
                            <input type="number" step="0.01" name="fixed_amount" value="{{ $paymentMethod->fixed_amount }}"
                                placeholder="0.00"
                                class="flex-1 px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-cisa-accent focus:bg-white outline-none transition-all font-bold text-cisa-base">
                            <select name="currency"
                                class="w-32 px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-cisa-accent focus:bg-white outline-none transition-all font-bold text-cisa-base uppercase tracking-widest">
                                <option value="USD" {{ $paymentMethod->currency === 'USD' ? 'selected' : '' }}>USD</option>
                                <option value="EUR" {{ $paymentMethod->currency === 'EUR' ? 'selected' : '' }}>EUR</option>
                                <option value="GBP" {{ $paymentMethod->currency === 'GBP' ? 'selected' : '' }}>GBP</option>
                                <option value="NGN" {{ $paymentMethod->currency === 'NGN' ? 'selected' : '' }}>NGN</option>
                                <option value="PKR" {{ $paymentMethod->currency === 'PKR' ? 'selected' : '' }}>PKR</option>
                            </select>
                        </div>
                        <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">Set a fixed amount if this
                            method has a standard fee.</p>
                    </div>

                    <!-- Active -->
                    <div class="space-y-2 flex flex-col justify-center">
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-3">Initial
                            Status</label>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" {{ $paymentMethod->is_active ? 'checked' : '' }} class="sr-only peer">
                            <div
                                class="w-14 h-8 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-cisa-accent">
                            </div>
                            <span class="ml-3 text-sm font-black text-cisa-base uppercase tracking-widest">Active</span>
                        </label>
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2 space-y-2">
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest">Brief
                            Description</label>
                        <input type="text" name="description" value="{{ $paymentMethod->description }}"
                            class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-cisa-accent focus:bg-white outline-none transition-all font-bold text-cisa-base text-sm">
                    </div>

                    <!-- Details (Instruction) -->
                    <div class="md:col-span-2 space-y-2">
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest">Payment
                            Instructions & Details</label>
                        <textarea name="details" rows="6"
                            class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-cisa-accent focus:bg-white outline-none transition-all font-bold text-cisa-base min-h-[150px]">{{ $paymentMethod->details }}</textarea>
                    </div>
                </div>

                <div class="mt-12 flex items-center justify-between gap-4 py-8 border-t-2 border-slate-50">
                    <a href="{{ route('admin.payment-methods.index') }}"
                        class="px-8 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 font-black rounded-xl transition-all uppercase tracking-widest text-sm">
                        Discard
                    </a>
                    <button type="submit"
                        class="px-12 py-4 bg-cisa-accent hover:bg-white text-cisa-base font-black rounded-xl shadow-xl transition-all uppercase tracking-widest text-sm flex items-center gap-3">
                        <i class="fas fa-check-circle"></i>
                        Update Method
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection