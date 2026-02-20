@extends('layouts.admin')

@section('title', 'Add Payment Method - CISA')
@section('page-title', 'Add New Payment Method')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border-2 border-slate-100">
            <!-- Header -->
            <div class="bg-cisa-base p-8 border-b-4 border-cisa-accent flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-black text-white uppercase tracking-tight">METHOD CONFIGURATION</h2>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-1">Define new payment gateway or
                        manual method</p>
                </div>
                <i class="fas fa-wallet text-4xl text-cisa-accent/20"></i>
            </div>

            <form method="POST" action="{{ route('admin.payment-methods.store') }}" class="p-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Name -->
                    <div class="space-y-2">
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest">Method Name</label>
                        <input type="text" name="name" required placeholder="e.g. Bank of England Transfer"
                            class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-cisa-accent focus:bg-white outline-none transition-all font-bold text-cisa-base">
                        @error('name') <p class="text-red-500 text-xs font-bold">{{ $message }}</p> @enderror
                    </div>

                    <!-- Service Type -->
                    <div class="space-y-2">
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest">Service
                            Type</label>
                        <select name="service_type" required
                            class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-cisa-accent focus:bg-white outline-none transition-all font-bold text-cisa-base">
                            <option value="general">General Payment Method</option>
                            <option value="plagiarism_check">Plagiarism Checker Fee</option>
                            <option value="apc">Article Processing Charge (APC)</option>
                            <option value="fast_track">Fast Track Review</option>
                        </select>
                        <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">Select "Plagiarism Checker
                            Fee" to
                            link this to the detection tool.</p>
                    </div>

                    <!-- Journal -->
                    <div class="space-y-2">
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest">Journal
                            Assignment</label>
                        <select name="journal_id"
                            class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-cisa-accent focus:bg-white outline-none transition-all font-bold text-cisa-base">
                            <option value="">Global (All Journals)</option>
                            @foreach($journals as $journal)
                                <option value="{{ $journal->id }}">{{ $journal->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Method Type -->
                    <div class="space-y-2">
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest">Gateway
                            Type</label>
                        <select name="type" required
                            class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-cisa-accent focus:bg-white outline-none transition-all font-bold text-cisa-base">
                            <option value="manual">Manual (Bank Transfer, Mobile Money)</option>
                            <option value="gateway">Automatic Gateway (Stripe, PayPal)</option>
                        </select>
                    </div>

                    <!-- Regional Pricing -->
                    <div class="md:col-span-2 bg-slate-50 rounded-2xl p-6 border-2 border-slate-100">
                        <label
                            class="block text-xs font-black text-cisa-base uppercase tracking-widest mb-4 flex items-center gap-2">
                            <i class="fas fa-globe-africa"></i> Regional Pricing Configuration
                        </label>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Default Price -->
                            <div class="space-y-2">
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Global /
                                    Standard Fee</label>
                                <div class="flex gap-2">
                                    <input type="number" step="0.01" name="fixed_amount" placeholder="0.00"
                                        class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl focus:border-cisa-accent outline-none font-bold text-cisa-base">
                                    <select name="currency"
                                        class="px-3 py-3 bg-white border-2 border-slate-200 rounded-xl font-bold text-xs uppercase">
                                        <option value="USD">USD</option>
                                        <option value="EUR">EUR</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Africa Price -->
                            <div class="space-y-2">
                                <label class="block text-[10px] font-bold text-cisa-accent uppercase tracking-widest">Africa
                                    Region Fee</label>
                                <input type="number" step="0.01" name="fees[africa]" placeholder="e.g. 10.00"
                                    class="w-full px-4 py-3 bg-white border-2 border-cisa-accent/30 rounded-xl focus:border-cisa-accent outline-none font-bold text-cisa-base">
                            </div>

                            <!-- Developing Nations Price -->
                            <div class="space-y-2">
                                <label
                                    class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Developing
                                    Nations</label>
                                <input type="number" step="0.01" name="fees[developing]" placeholder="e.g. 15.00"
                                    class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl focus:border-cisa-accent outline-none font-bold text-cisa-base">
                            </div>
                        </div>
                        <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-3">
                            <i class="fas fa-info-circle mr-1"></i> Use "Africa Region Fee" to set specific subsidized rates
                            for African authors.
                        </p>
                    </div>

                    <!-- Active -->
                    <div class="space-y-2 flex flex-col justify-center">
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-3">Initial
                            Status</label>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" checked class="sr-only peer">
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
                        <input type="text" name="description" placeholder="A short internal note about this method"
                            class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-cisa-accent focus:bg-white outline-none transition-all font-bold text-cisa-base text-sm">
                    </div>

                    <!-- Details (Instruction) -->
                    <div class="md:col-span-2 space-y-2">
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest">Payment
                            Instructions & Details</label>
                        <textarea name="details" rows="6"
                            placeholder="Account numbers, SWIFT codes, or API configuration keys..."
                            class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-cisa-accent focus:bg-white outline-none transition-all font-bold text-cisa-base min-h-[150px]"></textarea>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">These details will be
                            shown to authors on their invoice.</p>
                    </div>
                </div>

                <div class="mt-12 flex items-center justify-between gap-4 py-8 border-t-2 border-slate-50">
                    <a href="{{ route('admin.payment-methods.index') }}"
                        class="px-8 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 font-black rounded-xl transition-all uppercase tracking-widest text-sm">
                        Discard
                    </a>
                    <button type="submit"
                        class="px-12 py-4 bg-cisa-base hover:bg-slate-800 text-white font-black rounded-xl shadow-xl transition-all uppercase tracking-widest text-sm flex items-center gap-3">
                        <i class="fas fa-save"></i>
                        Save Method
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection