<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\Journal;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = PaymentMethod::with('journal')->latest()->get();
        return view('admin.payment-methods.index', compact('paymentMethods'));
    }

    public function create()
    {
        $journals = Journal::where('is_active', true)->orderBy('name')->get();
        return view('admin.payment-methods.create', compact('journals'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:manual,gateway',
            'service_type' => 'required|string',
            'journal_id' => 'nullable|exists:journals,id',
            'description' => 'nullable|string',
            'fixed_amount' => 'nullable|numeric|min:0',
            'currency' => 'required|string|size:3',
            'details' => 'nullable|string',
            'is_active' => 'boolean',
            'fees' => 'nullable|array',
        ]);

        PaymentMethod::create($validated);

        return redirect()->route('admin.payment-methods.index')
            ->with('success', 'Payment method created successfully!');
    }

    public function edit(PaymentMethod $paymentMethod)
    {
        $journals = Journal::where('is_active', true)->orderBy('name')->get();
        return view('admin.payment-methods.edit', compact('paymentMethod', 'journals'));
    }

    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:manual,gateway',
            'service_type' => 'required|string',
            'journal_id' => 'nullable|exists:journals,id',
            'description' => 'nullable|string',
            'fixed_amount' => 'nullable|numeric|min:0',
            'currency' => 'required|string|size:3',
            'details' => 'nullable|string',
            'is_active' => 'boolean',
            'fees' => 'nullable|array',
        ]);

        $paymentMethod->update($validated);

        return redirect()->route('admin.payment-methods.index')
            ->with('success', 'Payment method updated successfully!');
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();
        return redirect()->route('admin.payment-methods.index')
            ->with('success', 'Payment method deleted successfully!');
    }
}
