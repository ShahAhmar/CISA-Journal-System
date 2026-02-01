<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Journal;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['journal', 'submission', 'user']);

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by type
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        // Filter by journal
        if ($request->has('journal_id') && $request->journal_id) {
            $query->where('journal_id', $request->journal_id);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $payments = $query->latest()->paginate(20);
        $journals = Journal::where('is_active', true)->orderBy('name')->get();

        // Statistics
        $stats = [
            'total' => Payment::count(),
            'completed' => Payment::where('status', 'completed')->count(),
            'pending' => Payment::whereIn('status', ['pending', 'processing'])->count(),
            'failed' => Payment::where('status', 'failed')->count(),
            'total_amount' => Payment::where('status', 'completed')->sum('amount'),
            'today_amount' => Payment::where('status', 'completed')
                ->whereDate('created_at', today())
                ->sum('amount'),
        ];

        return view('admin.payments.index', compact('payments', 'journals', 'stats'));
    }

    public function show(Payment $payment)
    {
        $payment->load(['journal', 'submission', 'user']);
        return view('admin.payments.show', compact('payment'));
    }

    public function create()
    {
        $journals = Journal::where('is_active', true)->orderBy('name')->get();
        $users = \App\Models\User::orderBy('first_name')->get();

        return view('admin.payments.create', compact('journals', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'journal_id' => 'required|exists:journals,id',
            'user_id' => 'required|exists:users,id',
            'type' => 'required|in:apc,submission_fee',
            'amount' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
            'payment_method' => 'nullable|string|max:255',
            'status' => 'required|in:pending,processing,completed,failed,refunded',
            'transaction_id' => 'nullable|string|max:255',
            'submission_id' => 'nullable|exists:submissions,id',
            'notes' => 'nullable|string|max:1000',
        ]);

        $payment = Payment::create([
            'journal_id' => $validated['journal_id'],
            'user_id' => $validated['user_id'],
            'submission_id' => $validated['submission_id'] ?? null,
            'type' => $validated['type'],
            'amount' => $validated['amount'],
            'currency' => $validated['currency'],
            'status' => $validated['status'],
            'payment_method' => $validated['payment_method'] ?? null,
            'transaction_id' => $validated['transaction_id'] ?? null,
            'payment_details' => $validated['notes'] ? ['notes' => $validated['notes']] : null,
        ]);

        return redirect()->route('admin.payments.show', $payment)
            ->with('success', 'Payment created successfully!');
    }

    public function updateStatus(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,failed,refunded',
        ]);

        $payment->update([
            'status' => $request->status,
        ]);

        // Workflow Trigger: If payment completed, update submission
        if ($request->status === 'completed' && $payment->submission) {
            $payment->submission->update([
                'payment_status' => 'paid',
                'current_stage' => 'copyediting' // Paper can now proceed to copyediting
            ]);

            \App\Models\SubmissionLog::create([
                'submission_id' => $payment->submission_id,
                'user_id' => auth()->id(),
                'action' => 'payment_verified',
                'message' => 'Payment verified by administrator. Submission moved to copyediting stage.',
            ]);
        }

        return back()->with('success', 'Payment status updated successfully!');
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'payment_method' => 'nullable|string|max:255',
            'transaction_id' => 'nullable|string|max:255',
            'status' => 'required|in:pending,processing,completed,failed,refunded',
            'notes' => 'nullable|string|max:1000',
        ]);

        $paymentDetails = $payment->payment_details ?? [];
        if ($validated['notes']) {
            $paymentDetails['notes'] = $validated['notes'];
        }

        $payment->update([
            'payment_method' => $validated['payment_method'] ?? $payment->payment_method,
            'transaction_id' => $validated['transaction_id'] ?? $payment->transaction_id,
            'status' => $validated['status'],
            'payment_details' => $paymentDetails,
        ]);

        // Workflow Trigger: If payment completed, update submission
        if ($validated['status'] === 'completed' && $payment->submission) {
            $payment->submission->update([
                'payment_status' => 'paid',
                'current_stage' => 'copyediting'
            ]);

            \App\Models\SubmissionLog::create([
                'submission_id' => $payment->submission_id,
                'user_id' => auth()->id(),
                'action' => 'payment_verified',
                'message' => 'Payment verified and updated by administrator. Submission moved to copyediting.',
            ]);
        }

        return back()->with('success', 'Payment updated successfully!');
    }
}

