@extends('layouts.app')

@section('title', 'My Payments - CISA')

@section('content')
    <!-- Hero Section -->
    <section class="bg-cisa-base text-white py-12 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0"
                style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 20px 20px;">
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center">
                <h1 class="text-3xl md:text-5xl font-black mb-4 uppercase tracking-tighter">My Payments</h1>
                <p class="text-lg text-amber-200 font-bold uppercase tracking-widest">Manage your invoices and payment
                    proofs</p>
            </div>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-3xl shadow-2xl border-2 border-slate-100 overflow-hidden">
            <div
                class="p-8 border-b-2 border-slate-50 flex flex-col md:flex-row md:items-center justify-between gap-6 bg-slate-50/50">
                <div>
                    <h2 class="text-xl font-black text-cisa-base uppercase tracking-tight">Financial Transaction Log</h2>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Audit trail of all
                        Article Processing Charges and fees</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="flex flex-col items-end">
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Verified</span>
                        <span
                            class="text-sm font-black text-green-600">{{ $payments->where('status', 'completed')->count() }}
                            Payments</span>
                    </div>
                    <div class="w-px h-8 bg-slate-200"></div>
                    <div class="flex flex-col items-end">
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Under Review</span>
                        <span
                            class="text-sm font-black text-blue-600">{{ $payments->where('status', 'processing')->count() }}
                            Items</span>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50 border-b-2 border-slate-200">
                            <th class="px-6 py-4 text-left text-[11px] font-black text-slate-500 uppercase tracking-widest">
                                Submission / Invoice ID</th>
                            <th class="px-6 py-4 text-left text-[11px] font-black text-slate-500 uppercase tracking-widest">
                                Amount</th>
                            <th class="px-6 py-4 text-left text-[11px] font-black text-slate-500 uppercase tracking-widest">
                                Date Issued</th>
                            <th class="px-6 py-4 text-left text-[11px] font-black text-slate-500 uppercase tracking-widest">
                                Status</th>
                            <th
                                class="px-6 py-4 text-right text-[11px] font-black text-slate-500 uppercase tracking-widest">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-slate-50">
                        @forelse($payments as $payment)
                            <tr class="hover:bg-slate-50/80 transition-all">
                                <td class="px-6 py-6">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-sm font-black text-cisa-base uppercase">#INV-{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</span>
                                        <span
                                            class="text-xs text-slate-500 font-bold mt-1 line-clamp-1 italic">{{ $payment->submission->title ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-6 font-black text-cisa-base">
                                    {{ number_format($payment->amount, 2) }} {{ $payment->currency }}
                                </td>
                                <td class="px-6 py-6 text-sm font-bold text-slate-600">
                                    {{ $payment->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-6">
                                    @php
                                        $statusClasses = [
                                            'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                                            'processing' => 'bg-blue-100 text-blue-700 border-blue-200',
                                            'completed' => 'bg-green-100 text-green-700 border-green-200',
                                            'failed' => 'bg-red-100 text-red-700 border-red-200',
                                        ];
                                        $class = $statusClasses[$payment->status] ?? 'bg-slate-100 text-slate-700 border-slate-200';
                                    @endphp
                                    <span
                                        class="px-4 py-1.5 rounded-full border-2 {{ $class }} text-[10px] font-black uppercase tracking-widest">
                                        {{ strtoupper($payment->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-6 text-right">
                                    <a href="{{ route('author.payments.show', $payment) }}"
                                        class="inline-flex items-center gap-2 px-6 py-2.5 bg-cisa-base hover:bg-slate-800 text-white font-black text-[10px] uppercase tracking-widest rounded-xl transition-all shadow-xl shadow-slate-200">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <i class="fas fa-receipt text-5xl text-slate-200 mb-4"></i>
                                    <p class="text-slate-500 font-bold uppercase tracking-widest text-xs">No payment records
                                        found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($payments->hasPages())
                <div class="px-8 py-6 border-t-2 border-slate-50">
                    {{ $payments->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection