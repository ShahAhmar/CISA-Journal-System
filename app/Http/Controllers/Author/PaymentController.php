<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use App\Models\Payment;
use App\Models\Submission;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::where('user_id', auth()->id())
            ->with(['submission', 'journal'])
            ->latest()
            ->paginate(10);

        return view('author.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        if ($payment->user_id !== auth()->id()) {
            abort(403);
        }

        $payment->load(['submission', 'journal']);

        // Get active payment methods for this journal or global
        $paymentMethods = PaymentMethod::where('is_active', true)
            ->where(function ($query) use ($payment) {
                $query->where('journal_id', $payment->journal_id)
                    ->orWhereNull('journal_id');
            })
            ->get();

        return view('author.payments.show', compact('payment', 'paymentMethods'));
    }

    public function uploadProof(Request $request, Payment $payment)
    {
        if ($payment->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'proof_file' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'payment_method' => ['required', 'string'],
        ]);

        if ($request->hasFile('proof_file')) {
            \Log::info('Payment Proof Upload started', [
                'payment_id' => $payment->id,
                'user_id' => auth()->id(),
                'file_name' => $request->file('proof_file')->getClientOriginalName(),
            ]);

            // Delete old proof if exists
            if ($payment->proof_file) {
                Storage::disk('public')->delete($payment->proof_file);
                \Log::info('Old proof deleted', ['path' => $payment->proof_file]);
            }

            $path = $request->file('proof_file')->store('payment_proofs', 'public');
            \Log::info('New proof stored', ['path' => $path]);

            $payment->update([
                'proof_file' => $path,
                'status' => 'processing',
                'payment_method' => $request->payment_method,
            ]);

            // Update submission payment status
            if ($payment->submission) {
                $payment->submission->update(['payment_status' => 'processing']);
                \Log::info('Submission payment status updated to processing', ['submission_id' => $payment->submission_id]);
            }

            return back()->with('success', 'Payment proof uploaded successfully. An administrator will review it soon.');
        }

        \Log::warning('Payment Proof Upload failed: No file found in request', [
            'payment_id' => $payment->id,
            'user_id' => auth()->id(),
        ]);

        return back()->with('error', 'Failed to upload proof.');
    }
}
