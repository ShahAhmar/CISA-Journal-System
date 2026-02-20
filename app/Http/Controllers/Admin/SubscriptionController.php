<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Journal;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::with(['user', 'journal'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        $users = User::all();
        $journals = Journal::where('is_active', true)->get();
        
        return view('admin.subscriptions.index', compact('subscriptions', 'users', 'journals'));
    }

    public function create()
    {
        $users = User::all();
        $journals = Journal::where('is_active', true)->get();
        
        return view('admin.subscriptions.create', compact('users', 'journals'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'journal_id' => 'required|exists:journals,id',
            'type' => 'required|in:individual,institutional',
            'status' => 'required|in:active,expired,cancelled',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'renewal_date' => 'nullable|date',
            'amount' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        Subscription::create($validated);

        return redirect()->route('admin.subscriptions.index')
            ->with('success', 'Subscription created successfully!');
    }

    public function show(Subscription $subscription)
    {
        $subscription->load(['user', 'journal']);
        return view('admin.subscriptions.show', compact('subscription'));
    }

    public function edit(Subscription $subscription)
    {
        $users = User::all();
        $journals = Journal::where('is_active', true)->get();
        
        return view('admin.subscriptions.edit', compact('subscription', 'users', 'journals'));
    }

    public function update(Request $request, Subscription $subscription)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'journal_id' => 'required|exists:journals,id',
            'type' => 'required|in:individual,institutional',
            'status' => 'required|in:active,expired,cancelled',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'renewal_date' => 'nullable|date',
            'amount' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $subscription->update($validated);

        return redirect()->route('admin.subscriptions.index')
            ->with('success', 'Subscription updated successfully!');
    }

    public function destroy(Subscription $subscription)
    {
        $subscription->delete();

        return redirect()->route('admin.subscriptions.index')
            ->with('success', 'Subscription deleted successfully!');
    }
}
