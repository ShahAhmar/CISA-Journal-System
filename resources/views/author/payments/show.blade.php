@extends('layouts.app')

@section('title', 'Invoice Details - CISA')

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Action Bar -->
        <div class="mb-8 flex items-center justify-between">
            <a href="{{ route('author.payments.index') }}"
                class="text-xs font-black text-slate-400 uppercase tracking-widest hover:text-cisa-base transition-all flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Back to Payments
            </a>
            <div class="flex gap-3">
                <button onclick="window.print()"
                    class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-black text-[10px] uppercase tracking-widest rounded-xl transition-all">
                    <i class="fas fa-print mr-2"></i> Print Invoice
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-8 p-6 bg-green-50 border-2 border-green-500/20 rounded-3xl flex items-center gap-4 animate-bounce">
                <i class="fas fa-check-circle text-2xl text-green-500"></i>
                <p class="text-green-700 font-black uppercase tracking-tight text-sm">{{ session('success') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Invoice Details (Left 2/3) -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border-2 border-slate-100">
                    <!-- Header -->
                    <div
                        class="bg-cisa-base p-10 flex flex-col items-center text-center relative border-b-8 border-cisa-accent">
                        @if($payment->status === 'completed')
                            <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-[0.07]">
                                <h1
                                    class="text-[12rem] font-black uppercase -rotate-12 border-[20px] border-white px-20 py-10 rounded-[4rem]">
                                    APPROVED</h1>
                            </div>
                            <div
                                class="absolute top-10 right-10 bg-green-500 text-white font-black px-8 py-3 rounded-2xl shadow-2xl flex items-center gap-3 animate-pulse">
                                <i class="fas fa-check-double"></i>
                                <span class="uppercase tracking-widest text-xs">Verified & Approved</span>
                            </div>
                        @endif
                        <div class="w-20 h-2 bg-cisa-accent rounded-full mb-8"></div>
                        <h2 class="text-4xl font-black text-white uppercase tracking-tighter mb-2">INVOICE</h2>
                        <p class="text-slate-400 font-black text-xs uppercase tracking-[0.3em]">
                            #INV-{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</p>
                    </div>

                    <!-- Info Grid -->
                    <div class="p-10 grid grid-cols-2 gap-12 bg-slate-50/30">
                        <div>
                            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Billed To:</h4>
                            <div class="space-y-1">
                                <p class="text-lg font-black text-cisa-base uppercase leading-tight">
                                    {{ auth()->user()->full_name }}
                                </p>
                                <p class="text-sm font-bold text-slate-500">{{ auth()->user()->email }}</p>
                                <p class="text-xs font-bold text-slate-400 mt-2">{{ auth()->user()->affiliation }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Invoice Info:
                            </h4>
                            <div class="space-y-1">
                                <p class="text-sm font-black text-cisa-base uppercase italic">Date:
                                    {{ $payment->created_at->format('M d, Y') }}
                                </p>
                                <p class="text-sm font-black text-cisa-base uppercase">Status:
                                    <span
                                        class="{{ $payment->status === 'completed' ? 'text-green-600' : 'text-amber-600' }}">
                                        {{ strtoupper($payment->status) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="p-10 bg-white">
                        <div class="border-b-4 border-cisa-base pb-4 mb-8">
                            <h3 class="text-xs font-black text-cisa-base uppercase tracking-widest">DESCRIPTION OF SERVICES
                            </h3>
                        </div>
                        <div class="flex flex-col gap-6">
                            <div class="flex justify-between items-start">
                                <div class="max-w-md">
                                    <p class="text-sm font-black text-cisa-base uppercase">Article Processing Charge (APC)
                                    </p>
                                    <p
                                        class="text-xs text-slate-400 font-bold mt-2 uppercase tracking-tight leading-relaxed">
                                        Full publication service for manuscript: <br>
                                        <span class="text-slate-600 italic">"{{ $payment->submission->title }}"</span>
                                    </p>
                                </div>
                                <p class="text-xl font-black text-cisa-base">{{ number_format($payment->amount, 2) }}
                                    {{ $payment->currency }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-16 pt-8 border-t-2 border-slate-100 flex justify-end">
                            <div class="text-right space-y-2">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Total Amount Due
                                </p>
                                <p class="text-5xl font-black text-cisa-base tracking-tighter">
                                    {{ number_format($payment->amount, 2) }} <span
                                        class="text-xl">{{ $payment->currency }}</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="p-10 bg-slate-50 text-center">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Thank you for publishing
                            with CISA Journals</p>
                    </div>
                </div>

                <!-- Payment Instructions -->
                <div class="bg-white rounded-[2.5rem] shadow-xl p-10 border-2 border-slate-100">
                    <h3 class="text-xl font-black text-cisa-base uppercase tracking-tight mb-8">PAYMENT INSTRUCTIONS</h3>
                    <div class="space-y-8">
                        @forelse($paymentMethods as $method)
                            <div
                                class="p-8 bg-slate-50 rounded-3xl border-2 border-slate-100 hover:border-cisa-accent transition-all group">
                                <div class="flex items-center gap-4 mb-4">
                                    <div
                                        class="w-12 h-12 bg-cisa-base rounded-2xl flex items-center justify-center text-cisa-accent group-hover:bg-cisa-accent group-hover:text-white transition-all">
                                        <i class="fas fa-university text-xl"></i>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <h4 class="font-black text-cisa-base uppercase tracking-tight">{{ $method->name }}
                                            </h4>
                                            @if($method->fixed_amount)
                                                <span
                                                    class="px-3 py-1 bg-cisa-accent text-cisa-base text-[10px] font-black rounded-lg uppercase tracking-widest">
                                                    {{ number_format($method->fixed_amount, 2) }} {{ $method->currency }}
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                            {{ $method->type }}
                                        </p>
                                    </div>
                                </div>
                                <div
                                    class="mt-4 prose prose-sm max-w-none text-slate-600 font-bold leading-relaxed whitespace-pre-wrap">
                                    {{ $method->details }}
                                </div>
                            </div>
                        @empty
                            <p class="text-slate-500 font-bold py-10 text-center">Contact administration for payment details.
                            </p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Sidebar Actions (Right 1/3) -->
            <div class="lg:col-span-1 space-y-8">
                <!-- Upload Proof -->
                <div
                    class="bg-white rounded-[2.5rem] shadow-2xl p-10 border-2 border-cisa-accent border-dashed overflow-hidden relative group">
                    <div
                        class="absolute -top-10 -right-10 opacity-5 group-hover:scale-110 transition-transform duration-700">
                        <i class="fas fa-cloud-upload-alt text-[15rem]"></i>
                    </div>

                    <h3 class="text-xl font-black text-cisa-base uppercase tracking-tight mb-4 relative z-10">UPLOAD PROOF
                    </h3>
                    <p
                        class="text-xs font-bold text-slate-500 uppercase tracking-widest leading-relaxed mb-8 relative z-10">
                        Please upload a scan or screenshot of your transaction receipt.</p>

                    <form method="POST" action="{{ route('author.payments.proof', $payment) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-6 relative z-10">
                            <!-- Select Method -->
                            <div class="space-y-2">
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Paid
                                    Via</label>
                                <select name="payment_method" required
                                    class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-cisa-accent focus:bg-white outline-none transition-all font-bold text-cisa-base uppercase tracking-wider text-xs">
                                    <option value="">- Select Method -</option>
                                    @foreach($paymentMethods as $method)
                                        <option value="{{ $method->name }}">{{ $method->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- File Input -->
                            <div class="space-y-2">
                                <label
                                    class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Receipt
                                    File</label>
                                <label class="block w-full cursor-pointer">
                                    <div
                                        class="px-5 py-8 border-2 border-slate-200 border-dashed rounded-3xl bg-slate-50 text-center hover:bg-white hover:border-cisa-accent transition-all">
                                        <i class="fas fa-upload text-2xl text-slate-300 mb-2"></i>
                                        <p
                                            class="text-[10px] font-black text-slate-500 uppercase tracking-widest file-name-info">
                                            Click to
                                            Select File</p>
                                        <p class="mt-1 text-[8px] font-bold text-slate-400">PDF, JPG, PNG (MAX 5MB)</p>
                                        <input type="file" name="proof_file" class="hidden" required id="proof_file_input"
                                            onchange="if(this.files[0]) { this.closest('div').querySelector('.file-name-info').innerText = this.files[0].name; this.closest('div').classList.add('border-cisa-accent', 'bg-white'); }">
                                    </div>
                                </label>
                                @error('proof_file') <p class="text-red-500 text-[10px] font-black uppercase mt-2">
                                    {{ $message }}
                                </p> @enderror
                            </div>

                            <button type="submit"
                                class="w-full py-5 bg-cisa-base hover:bg-slate-800 text-white font-black rounded-2.5rem shadow-2xl transition-all uppercase tracking-[0.2em] text-xs flex items-center justify-center gap-3">
                                <i class="fas fa-check-circle"></i>
                                Submit Proof
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Verification Status -->
                @if($payment->proof_file)
                    <div class="bg-white rounded-[2.5rem] shadow-xl p-10 border-2 border-slate-100 overflow-hidden">
                        <h3 class="text-sm font-black text-cisa-base uppercase tracking-widest mb-6">SUBMITTED PROOF</h3>
                        <div class="space-y-6">
                            <div
                                class="p-6 bg-slate-50 rounded-3xl border-2 border-slate-100 flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <i class="fas fa-file-pdf text-2xl text-red-500"></i>
                                    <div>
                                        <p class="text-[10px] font-black text-cisa-base uppercase tracking-tight">Receipt
                                            Uploaded</p>
                                        <p class="text-[8px] font-bold text-slate-400 uppercase">
                                            {{ $payment->updated_at->format('M d, Y h:i A') }}
                                        </p>
                                    </div>
                                </div>
                                <a href="{{ Storage::url($payment->proof_file) }}" target="_blank"
                                    class="text-cisa-accent hover:text-cisa-base transition-all">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            </div>

                            @php
                                $statusConfig = [
                                    'completed' => [
                                        'bg' => 'bg-green-50 border-green-200',
                                        'icon' => 'fa-check-circle text-green-500',
                                        'title' => 'VERIFIED',
                                        'text' => 'Your payment has been successfully verified. The submission is now proceeding to copyediting.',
                                        'color' => 'text-green-700'
                                    ],
                                    'processing' => [
                                        'bg' => 'bg-blue-50 border-blue-200',
                                        'icon' => 'fa-clock text-blue-500',
                                        'title' => 'UNDER REVIEW',
                                        'text' => 'Our editorial team is currently reviewing your payment proof. This typically takes 24-48 hours.',
                                        'color' => 'text-blue-700'
                                    ],
                                    'failed' => [
                                        'bg' => 'bg-rose-50 border-rose-200',
                                        'icon' => 'fa-exclamation-circle text-rose-500',
                                        'title' => 'REJECTED',
                                        'text' => $payment->payment_details['notes'] ?? 'Your payment proof was rejected. Please review the instructions and upload a valid receipt.',
                                        'color' => 'text-rose-700'
                                    ],
                                    'pending' => [
                                        'bg' => 'bg-amber-50 border-amber-200',
                                        'icon' => 'fa-clock text-amber-500',
                                        'title' => 'AWAITING PAYMENT',
                                        'text' => 'Please upload your payment receipt to begin the verification process.',
                                        'color' => 'text-amber-700'
                                    ]
                                ];
                                $config = $statusConfig[$payment->status] ?? $statusConfig['pending'];
                            @endphp
                            <div class="p-6 {{ $config['bg'] }} rounded-3xl border-2 flex flex-col items-center text-center">
                                <i class="fas {{ $config['icon'] }} text-3xl mb-3"></i>
                                <p class="text-[10px] font-black {{ $config['color'] }} uppercase tracking-widest">
                                    {{ $config['title'] }}
                                </p>
                                <p class="mt-2 text-[8px] font-bold text-slate-500 uppercase tracking-tight leading-relaxed">
                                    {{ $config['text'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        @media print {

            header,
            footer,
            .action-bar,
            .upload-proof,
            .verification-status,
            aside {
                display: none !important;
            }

            body {
                background: white !important;
            }

            .max-w-5xl {
                max-width: 100% !important;
                padding: 0 !important;
            }

            .lg\:col-span-2 {
                width: 100% !important;
            }

            .bg-slate-50 {
                background-color: #f1f5f9 !important;
                -webkit-print-color-adjust: exact;
            }
        }

        .rounded-2\.5rem {
            border-radius: 2.5rem;
        }
    </style>
@endsection