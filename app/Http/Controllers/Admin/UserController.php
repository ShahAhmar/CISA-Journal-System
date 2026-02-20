<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('journals');

        // Filter by role
        if ($request->has('role') && $request->role != 'all') {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(20);

        $stats = [
            'total' => User::count(),
            'authors' => User::where('role', 'author')->count(),
            'editors' => User::where('role', 'editor')->count(),
            'reviewers' => User::where('role', 'reviewer')->count(),
            'admins' => User::where('role', 'admin')->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    public function create()
    {
        $journals = Journal::where('is_active', true)->get();
        return view('admin.users.create', compact('journals'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:author,editor,reviewer,admin,copyeditor,proofreader,journal_manager,section_editor'],
            'affiliation' => ['nullable', 'string'],
            'orcid' => ['nullable', 'string'],
        ]);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role'],
            'affiliation' => $validated['affiliation'] ?? null,
            'orcid' => $validated['orcid'] ?? null,
            'is_active' => true,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $journals = Journal::where('is_active', true)->get();
        $user->load('journals');
        return view('admin.users.edit', compact('user', 'journals'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:author,editor,reviewer,admin,copyeditor,proofreader,journal_manager,section_editor,administrator,super-admin'],
            'affiliation' => ['nullable', 'string'],
            'orcid' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);

        $updateData = [
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => $validated['role'],
            'affiliation' => $validated['affiliation'] ?? null,
            'orcid' => $validated['orcid'] ?? null,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->filled('password')) {
            $updateData['password'] = bcrypt($validated['password']);
        }

        $user->update($updateData);

        // Sync Spatie roles with the role column
        if (isset($validated['role'])) {
            $user->syncRoles([$validated['role']]);
        }

        // Refresh user to ensure latest data
        $user->refresh();

        return redirect()->route('admin.users.edit', $user)->with('success', 'User updated successfully. Credentials and role updated.');
    }

    public function assignJournalRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'journal_id' => ['required', 'exists:journals,id'],
            'role' => ['required', 'string', 'in:journal_manager,editor,section_editor,reviewer,copyeditor,proofreader,sub_editor'],
            'section' => ['nullable', 'string'],
        ]);

        // Check if user already has a role in this journal
        $existing = $user->journals()->where('journals.id', $validated['journal_id'])->first();

        if ($existing) {
            // Update existing role
            $user->journals()->updateExistingPivot($validated['journal_id'], [
                'role' => $validated['role'],
                'section' => $validated['section'] ?? null,
                'is_active' => true,
            ]);
        } else {
            // Attach new role
            $user->journals()->attach($validated['journal_id'], [
                'role' => $validated['role'],
                'section' => $validated['section'] ?? null,
                'is_active' => true,
            ]);
        }

        return redirect()->route('admin.users.edit', $user)->with('success', 'Journal role assigned successfully.');
    }

    public function removeJournalRole(User $user, Journal $journal, $role)
    {
        // Remove the specific role for this journal
        $user->journals()->wherePivot('role', $role)->wherePivot('journal_id', $journal->id)->detach($journal->id);

        return redirect()->route('admin.users.edit', $user)->with('success', 'Journal role removed successfully.');
    }
}

