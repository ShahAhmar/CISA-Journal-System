@extends('layouts.admin')

@section('title', 'Payment Review - CISA')
@section('page-title', 'Transaction Review')
@section('page-subtitle', 'Invoice #INV-' . str_pad($payment->id, 5, '0', STR_PAD_LEFT))

@section('content')
    @php
        $routeNamePrefix = isset($journal) ? 'editor' : 'admin';
        $updateStatusRoute = isset($journal) 
            ? route('editor.payments.update-status', [$journal, $payment]) 
            : route('admin.payments.update-status', $payment);
            
        $updateRoute = isset($journal)
            ? route('editor.payments.update', [$journal, $payment])
            : route('admin.payments.update', $payment);
    @endphp
    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8 pb-20">
        <!-- Left Column: Details -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-[2rem] shadow-2xl overflow-hidden border-2 border-slate-100">
                <!-- Header -->
                <div class="bg-cisa-base p-8 border-b-4 border-cisa-accent flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-black text-white uppercase tracking-tight">TRANSACTION DATA</h2>
                        <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mt-1">Generated:
                            {{ $payment->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <div
                        class="px-5 py-2 rounded-xl {{ $payment->status === 'completed' ? 'bg-green-500/10 text-green-500 border-green-500/20' : 'bg-amber-500/10 text-amber-500 border-amber-500/20' }} border-2 text-xs font-black uppercase tracking-widest">
                        {{ ucfirst($payment->status) }}
                    </div>
                </div>

                <div class="p-8 grid grid-cols-2 gap-8 bg-slate-50/50">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">SUBMISSION</label>
                        <p class="text-sm font-black text-cisa-base uppercase line-clamp-2 leading-tight">
                            {{ $payment->submission->title ?? 'N/A' }}</p>
                        <a href="{{ $payment->submission ? route('admin.submissions.show', $payment->submission) : '#' }}"
                            class="inline-block text-[10px] font-black text-cisa-accent uppercase hover:underline mt-2"
                            target="_blank">
                            <i class="fas fa-external-link-alt mr-1"></i> View Submission
                        </a>
                    </div>
                    <div class="text-right space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">AUTHOR</label>
                        <p class="text-sm font-black text-cisa-base uppercase">{{ $payment->user->full_name }}</p>
                        <p class="text-[10px] font-bold text-slate-500 italic">{{ $payment->user->email }}</p>
                    </div>
                </div>

                <div class="p-8 space-y-8">
                    <div class="grid grid-cols-3 gap-8">
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">AMOUNT
                                DUE</label>
                            <p class="text-2xl font-black text-cisa-base tracking-tighter">
                                {{ number_format($payment->amount, 2) }} <span
                                    class="text-sm">{{ $payment->currency }}</span></p>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">TYPE</label>
                            <p class="text-sm font-black text-cisa-base uppercase">
                                {{ $payment->type === 'apc' ? 'APC (PUBLICATION)' : 'SUBMISSION FEE' }}</p>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">PAID VIA</label>
                            <p class="text-sm font-black text-slate-600 uppercase">
                                {{ $payment->payment_method ?? 'NOT SPECIFIED' }}</p>
                        </div>
                    </div>

                    @if($payment->proof_file)
                        <div class="mt-8 pt-8 border-t-2 border-slate-50">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-4">PAYMENT
                                PROOF ATTACHMENT</label>
                            <div
                                class="relative group rounded-3xl overflow-hidden border-2 border-slate-100 bg-slate-50 aspect-video flex items-center justify-center">
                                @php $extension = pathinfo($payment->proof_file, PATHINFO_EXTENSION); @endphp
                                @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp']))
                                    <img src="{{ Storage::url($payment->proof_file) }}" class="w-full h-full object-contain">
                                @else
                                    <div class="text-center">
                                        <i class="fas fa-file-pdf text-6xl text-red-500 mb-4"></i>
                                        <p class="text-sm font-black text-cisa-base uppercase">Document Received</p>
                                    </div>
                                @endif
                                <div
                                    class="absolute inset-0 bg-cisa-base/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all">
                                    <a href="{{ Storage::url($payment->proof_file) }}" target="_blank"
                                        class="px-8 py-3 bg-white text-cisa-base font-black text-xs uppercase tracking-widest rounded-xl shadow-2xl">
                                        <i class="fas fa-search-plus mr-2"></i> View Full Size
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="mt-8 pt-8 border-t-2 border-slate-50 text-center py-10">
                            <i class="fas fa-exclamation-triangle text-amber-500 text-3xl mb-4"></i>
                            <p class="text-sm font-bold text-slate-500 uppercase tracking-widest">No proof file has been
                                uploaded by the author yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column: Verification -->
        <div class="lg:col-span-1 space-y-8">
            <div class="bg-white rounded-[2rem] shadow-2xl p-8 border-2 border-slate-100">
                <h3 class="text-sm font-black text-cisa-base uppercase tracking-widest mb-6">VERIFICATION ACTION</h3>

                <div class="space-y-6">
                    <form method="POST" action="{{ $updateStatusRoute }}" id="approve-form">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="completed">
                        <button type="submit"
                            class="w-full py-5 bg-emerald-600 hover:bg-emerald-700 text-white font-black rounded-2xl shadow-xl transition-all uppercase tracking-[0.2em] text-[10px] flex items-center justify-center gap-3">
                            <i class="fas fa-check-circle"></i>
                            Approve Payment
                        </button>
                    </form>

                    <button onclick="document.getElementById('reject-modal').classList.remove('hidden')"
                        class="w-full py-5 bg-white border-2 border-rose-100 hover:border-rose-500 text-rose-600 font-black rounded-2xl transition-all uppercase tracking-[0.2em] text-[10px] flex items-center justify-center gap-3">
                        <i class="fas fa-times-circle"></i>
                        Reject Proof
                    </button>
                    
                    <p class="mt-4 text-[9px] font-bold text-slate-400 uppercase leading-relaxed text-center">
                        <i class="fas fa-info-circle mr-1"></i> Approving will automatically notify the
                        author and move the submission to copyediting.
                    </p>
                </div>

                <!-- Reject Modal -->
                <div id="reject-modal" class="fixed inset-0 bg-cisa-base/80 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
                    <div class="bg-white rounded-3xl max-w-md w-full p-8 shadow-2xl">
                        <h3 class="text-xl font-black text-cisa-base uppercase tracking-tight mb-4">Reject Payment Proof</h3>
                        <p class="text-sm text-slate-500 font-bold mb-6">Please provide a reason for rejecting this proof. The author will be notified to re-upload.</p>
                        
                        <form method="POST" action="{{ $updateRoute }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="failed">
                            <textarea name="notes" rows="4" required placeholder="e.g. Image is blurry, Incorrect transaction ID..."
                                class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-cisa-accent outline-none font-bold text-cisa-base text-sm mb-6"></textarea>
                            
                            <div class="flex gap-4">
                                <button type="button" onclick="document.getElementById('reject-modal').classList.add('hidden')"
                                    class="flex-1 py-4 bg-slate-100 text-slate-500 font-black rounded-xl uppercase tracking-widest text-[10px]">Cancel</button>
                                <button type="submit"
                                    class="flex-1 py-4 bg-rose-600 text-white font-black rounded-xl uppercase tracking-widest text-[10px]">Confirm Reject</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="bg-slate-50 rounded-[2rem] p-8 border-2 border-slate-100">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">LOG DATA</h3>
                <div class="space-y-4">
                    <div class="flex gap-3">
                        <div class="w-1 bg-cisa-accent h-auto rounded-full"></div>
                        <div>
                            <p class="text-[10px] font-black text-cisa-base uppercase tracking-tight">Invoice Generated</p>
                            <p class="text-[8px] font-bold text-slate-400">
                                {{ $payment->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                    @if($payment->proof_file)
                        <div class="flex gap-3">
                            <div class="w-1 bg-blue-500 h-auto rounded-full"></div>
                            <div>
                                <p class="text-[10px] font-black text-cisa-base uppercase tracking-tight">Proof Uploaded</p>
                                <p class="text-[8px] font-bold text-slate-400">
                                    {{ $payment->updated_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection