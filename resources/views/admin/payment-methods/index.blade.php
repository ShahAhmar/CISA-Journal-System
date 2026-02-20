@extends('layouts.admin')

@section('title', 'Payment Methods - CISA')
@section('page-title', 'Payment Methods')
@section('page-subtitle', 'Configure manual and automatic methods for handling journal payments')

@section('content')
    <div class="space-y-6">
        <!-- Header Action -->
        <div
            class="flex items-center justify-between bg-cisa-base rounded-2xl p-6 border-b-4 border-cisa-accent shadow-2xl">
            <div>
                <h2 class="text-2xl font-black text-white tracking-tight uppercase">Payment Configurations</h2>
                <p class="text-slate-400 text-sm font-bold uppercase tracking-widest mt-1">Manage Bank Transfers & Gateways
                </p>
            </div>
            <a href="{{ route('admin.payment-methods.create') }}"
                class="px-8 py-4 bg-cisa-accent hover:bg-white text-cisa-base font-black rounded-xl shadow-[0_0_20px_rgba(245,158,11,0.3)] hover:shadow-gold transition-all duration-300 transform hover:-translate-y-1 flex items-center gap-3">
                <i class="fas fa-plus-circle text-xl"></i>
                <span>ADD NEW METHOD</span>
            </a>
        </div>

        <!-- Methods Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($paymentMethods as $method)
                <div
                    class="group bg-white rounded-2xl border-2 border-slate-100 p-6 shadow-sm hover:shadow-xl hover:border-cisa-accent transition-all duration-300 relative overflow-hidden">
                    <!-- Status Badge -->
                    <div class="absolute top-4 right-4">
                        @if($method->is_active)
                            <span
                                class="px-3 py-1 bg-emerald-500/10 text-emerald-600 text-[10px] font-black uppercase tracking-widest rounded-full border border-emerald-500/20">Active</span>
                        @else
                            <span
                                class="px-3 py-1 bg-slate-100 text-slate-400 text-[10px] font-black uppercase tracking-widest rounded-full border border-slate-200">Inactive</span>
                        @endif
                    </div>

                    <div class="flex items-start gap-4 mb-6">
                        <div
                            class="w-16 h-16 rounded-2xl bg-slate-50 flex items-center justify-center text-3xl transition-transform duration-500 group-hover:scale-110">
                            @if($method->type === 'manual')
                                <i class="fas fa-university text-cisa-accent"></i>
                            @else
                                <i class="fas fa-bolt text-indigo-500"></i>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-cisa-base leading-tight">{{ $method->name }}</h3>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">
                                {{ $method->journal ? $method->journal->name : 'Global Method' }}
                            </p>
                        </div>
                    </div>

                    <div class="space-y-4 mb-6">
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 min-h-[60px]">
                            <p class="text-slate-600 text-sm font-medium line-clamp-2">
                                {{ $method->description ?? 'No description provided.' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-6 border-t border-slate-100">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.payment-methods.edit', $method) }}"
                                class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 hover:bg-cisa-base hover:text-white flex items-center justify-center transition-all duration-300">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.payment-methods.destroy', $method) }}" method="POST" class="inline"
                                onsubmit="return confirm('Delete this method?')">
                                @csrf
                                @method('DELETE')
                                <button
                                    class="w-10 h-10 rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white flex items-center justify-center transition-all duration-300">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                        <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                            Updated {{ $method->updated_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-2xl border-2 border-dashed border-slate-200 p-16 text-center">
                    <div
                        class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300">
                        <i class="fas fa-credit-card text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-black text-cisa-base mb-2">No Payment Methods</h3>
                    <p class="text-slate-500 font-bold uppercase tracking-wider text-sm mb-8">Click the button above to add your
                        first payment method.</p>
                    <a href="{{ route('admin.payment-methods.create') }}"
                        class="inline-flex items-center gap-2 px-8 py-3 bg-cisa-base text-white font-black rounded-xl hover:bg-slate-800 transition-all">
                        <i class="fas fa-plus"></i>
                        <span>CREATE METHOD</span>
                    </a>
                </div>
            @endforelse
        </div>
    </div>
@endsection