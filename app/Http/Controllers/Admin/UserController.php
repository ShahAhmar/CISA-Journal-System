<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Journal;
use App\Models\EmailSetting;
use App\Notifications\UserStatusChangedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

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
            'role' => ['required', 'string', 'in:author,editor,reviewer,admin,copyeditor,proofreader,journal_manager,section_editor'],
            'affiliation' => ['nullable', 'string'],
            'orcid' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);
        
        // Update user information (password is managed by user themselves)
        $updateData = [
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'affiliation' => $validated['affiliation'] ?? null,
            'orcid' => $validated['orcid'] ?? null,
            'is_active' => $request->has('is_active'),
        ];
        
        $user->update($updateData);
        
        // Refresh user to ensure latest data
        $user->refresh();

        return redirect()->route('admin.users.edit', $user)->with('success', 'User updated successfully. Role changed to: ' . ucfirst($validated['role']));
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

    /**
     * Disable a user account
     */
    public function disable(User $user, Request $request)
    {
        // Don't allow disabling yourself
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot disable your own account.');
        }

        $user->update(['is_active' => false]);

        // Send notification
        try {
            $this->ensureMailConfig();
            $user->notify(new UserStatusChangedNotification('disabled', $request->reason));
        } catch (\Exception $e) {
            \Log::error('Failed to send disable notification', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
        }

        return redirect()->back()->with('success', 'User has been disabled successfully. User has been notified via email.');
    }

    /**
     * Enable a user account
     */
    public function enable(User $user)
    {
        $user->update(['is_active' => true]);

        // Send notification
        try {
            $this->ensureMailConfig();
            $user->notify(new UserStatusChangedNotification('enabled'));
        } catch (\Exception $e) {
            \Log::error('Failed to send enable notification', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
        }

        return redirect()->back()->with('success', 'User has been enabled successfully. User has been notified via email.');
    }

    /**
     * Suspend a user account
     */
    public function suspend(User $user, Request $request)
    {
        // Don't allow suspending yourself
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot suspend your own account.');
        }

        $user->update([
            'is_active' => false,
            'suspended_at' => now(),
        ]);

        // Send notification
        try {
            $this->ensureMailConfig();
            $user->notify(new UserStatusChangedNotification('suspended', $request->reason));
        } catch (\Exception $e) {
            \Log::error('Failed to send suspend notification', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
        }

        return redirect()->back()->with('success', 'User has been suspended successfully. User has been notified via email.');
    }

    /**
     * Reactivate a suspended user account
     */
    public function reactivate(User $user)
    {
        $user->update([
            'is_active' => true,
            'suspended_at' => null,
        ]);

        // Send notification
        try {
            $this->ensureMailConfig();
            $user->notify(new UserStatusChangedNotification('reactivated'));
        } catch (\Exception $e) {
            \Log::error('Failed to send reactivate notification', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
        }

        return redirect()->back()->with('success', 'User has been reactivated successfully. User has been notified via email.');
    }

    /**
     * Terminate a user account
     */
    public function terminate(User $user, Request $request)
    {
        // Don't allow terminating yourself
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot terminate your own account.');
        }

        $user->update([
            'is_active' => false,
            'terminated_at' => now(),
        ]);

        // Send notification
        try {
            $this->ensureMailConfig();
            $user->notify(new UserStatusChangedNotification('terminated', $request->reason));
        } catch (\Exception $e) {
            \Log::error('Failed to send terminate notification', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
        }

        return redirect()->back()->with('success', 'User account has been terminated successfully. User has been notified via email.');
    }

    /**
     * Restore a terminated user account
     */
    public function restoreTerminated(User $user)
    {
        // Only restore if user is terminated
        if (!$user->terminated_at) {
            return redirect()->back()->with('error', 'This user account is not terminated.');
        }

        $user->update([
            'is_active' => true,
            'terminated_at' => null,
            'suspended_at' => null, // Also clear suspension if any
        ]);

        // Send notification
        try {
            $this->ensureMailConfig();
            $user->notify(new UserStatusChangedNotification('reactivated'));
        } catch (\Exception $e) {
            \Log::error('Failed to send restore notification', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
        }

        return redirect()->back()->with('success', 'Terminated user account has been restored successfully. User has been notified via email.');
    }

    /**
     * Delete a user account
     */
    public function destroy(User $user)
    {
        // Don't allow deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        // Send notification before deletion
        try {
            $this->ensureMailConfig();
            $user->notify(new UserStatusChangedNotification('deleted'));
        } catch (\Exception $e) {
            \Log::error('Failed to send delete notification', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
        }

        // Delete user profile image if exists
        if ($user->profile_image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($user->profile_image);
        }

        // Delete the user
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User has been deleted successfully. User has been notified via email.');
    }
    
    /**
     * Ensure mail configuration is loaded from database
     */
    protected function ensureMailConfig()
    {
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('email_settings')) {
                $emailSetting = EmailSetting::getActive();
                
                if ($emailSetting && !empty($emailSetting->mail_driver)) {
                    Config::set('mail.default', 'smtp');
                    Config::set('mail.mailers.smtp.transport', 'smtp');
                    Config::set('mail.mailers.smtp.host', $emailSetting->mail_host ?? '');
                    Config::set('mail.mailers.smtp.port', (int)($emailSetting->mail_port ?? 587));
                    Config::set('mail.mailers.smtp.encryption', $emailSetting->mail_encryption ?? 'tls');
                    Config::set('mail.mailers.smtp.username', $emailSetting->mail_username ?? '');
                    Config::set('mail.mailers.smtp.password', $emailSetting->mail_password ?? '');
                    Config::set('mail.from.address', $emailSetting->mail_from_address ?? 'contact@emanp.org');
                    Config::set('mail.from.name', $emailSetting->mail_from_name ?? 'EMANP');
                    
                    app()->forgetInstance('mail.manager');
                }
            }
        } catch (\Exception $e) {
            \Log::warning('Failed to load email config in UserController: ' . $e->getMessage());
        }
    }
}

