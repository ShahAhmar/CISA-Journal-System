<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\EmailSetting;
use App\Models\Journal;
use App\Models\User;
use App\Notifications\AnnouncementNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with('journal')
            ->latest()
            ->paginate(15);
        
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        $journals = Journal::where('is_active', true)->get();
        return view('admin.announcements.create', compact('journals'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'type' => ['required', 'in:general,call_for_papers,new_issue,maintenance'],
            'journal_id' => ['nullable', 'exists:journals,id'],
            'is_published' => ['boolean'],
            'published_at' => ['nullable', 'date'],
            'send_email_notification' => ['boolean'],
            'scheduled_at' => ['nullable', 'date'],
        ]);

        $announcement = Announcement::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'type' => $validated['type'],
            'journal_id' => $validated['journal_id'] ?? null,
            'is_published' => $request->has('is_published') ? true : false,
            'published_at' => $validated['published_at'] ?? ($request->has('is_published') ? now() : null),
            'send_email_notification' => $request->has('send_email_notification') ? true : false,
            'scheduled_at' => $validated['scheduled_at'] ?? null,
        ]);

        // Send email notifications if enabled and published immediately
        if ($announcement->is_published && $announcement->send_email_notification && !$announcement->scheduled_at) {
            $this->sendEmailNotifications($announcement);
        }
        
        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement created successfully!');
    }

    public function edit(Announcement $announcement)
    {
        $journals = Journal::where('is_active', true)->get();
        return view('admin.announcements.edit', compact('announcement', 'journals'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'type' => ['required', 'in:general,call_for_papers,new_issue,maintenance'],
            'journal_id' => ['nullable', 'exists:journals,id'],
            'is_published' => ['boolean'],
            'published_at' => ['nullable', 'date'],
            'send_email_notification' => ['boolean'],
            'scheduled_at' => ['nullable', 'date'],
        ]);

        $wasPublished = $announcement->is_published;
        
        $announcement->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'type' => $validated['type'],
            'journal_id' => $validated['journal_id'] ?? null,
            'is_published' => $request->has('is_published') ? true : false,
            'published_at' => $validated['published_at'] ?? ($request->has('is_published') && !$announcement->published_at ? now() : $announcement->published_at),
            'send_email_notification' => $request->has('send_email_notification') ? true : false,
            'scheduled_at' => $validated['scheduled_at'] ?? null,
        ]);

        // Send email notifications if newly published and enabled
        if ($announcement->is_published && !$wasPublished && $announcement->send_email_notification && !$announcement->scheduled_at) {
            $this->sendEmailNotifications($announcement);
        }
        
        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement updated successfully!');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        
        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement deleted successfully!');
    }

    public function resendEmails(Announcement $announcement)
    {
        if (!$announcement->is_published) {
            return redirect()->route('admin.announcements.index')
                ->with('error', 'Cannot send emails for unpublished announcements.');
        }

        try {
            // Reset emails_sent flag
            $announcement->update(['emails_sent' => false]);
            
            // Send notifications
            $this->sendEmailNotifications($announcement);
            
            return redirect()->route('admin.announcements.index')
                ->with('success', 'Email notifications sent successfully! Check logs for details.');
        } catch (\Exception $e) {
            \Log::error('Failed to resend announcement emails', [
                'announcement_id' => $announcement->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('admin.announcements.index')
                ->with('error', 'Failed to send emails: ' . $e->getMessage() . '. Check logs for details.');
        }
    }

    protected function sendEmailNotifications(Announcement $announcement)
    {
        try {
            // Ensure mail configuration is loaded from database
            $this->ensureMailConfig();
            
            // Get all registered users
            $users = User::whereNotNull('email')->where('email', '!=', '')->get();
            
            if ($users->isEmpty()) {
                \Log::info('No users found to send announcement notification');
                return;
            }
            
            $sentCount = 0;
            $failedCount = 0;
            
            // Send notifications synchronously (not queued)
            foreach ($users as $user) {
                try {
                    $user->notify(new AnnouncementNotification($announcement));
                    $sentCount++;
                } catch (\Exception $e) {
                    $failedCount++;
                    \Log::error('Failed to send announcement notification to user', [
                        'user_id' => $user->id,
                        'user_email' => $user->email,
                        'announcement_id' => $announcement->id,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            }
            
            // Mark as emails sent only if at least one email was sent successfully
            if ($sentCount > 0) {
                $announcement->update(['emails_sent' => true]);
            }
            
            \Log::info('Announcement notifications sent', [
                'announcement_id' => $announcement->id,
                'total_users' => $users->count(),
                'sent_count' => $sentCount,
                'failed_count' => $failedCount
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to send announcement notifications', [
                'announcement_id' => $announcement->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e; // Re-throw to show error to admin
        }
    }

    protected function ensureMailConfig()
    {
        try {
            $emailSetting = EmailSetting::getActive();
            
            if ($emailSetting && !empty($emailSetting->mail_driver)) {
                Config::set('mail.default', 'smtp');
                Config::set('mail.mailers.smtp.transport', 'smtp');
                Config::set('mail.mailers.smtp.host', $emailSetting->mail_host ?? '');
                Config::set('mail.mailers.smtp.port', (int)($emailSetting->mail_port ?? 587));
                Config::set('mail.mailers.smtp.encryption', $emailSetting->mail_encryption ?? 'tls');
                Config::set('mail.mailers.smtp.username', $emailSetting->mail_username ?? '');
                Config::set('mail.mailers.smtp.password', $emailSetting->mail_password ?? '');
                Config::set('mail.from.address', $emailSetting->mail_from_address ?? 'noreply@example.com');
                Config::set('mail.from.name', $emailSetting->mail_from_name ?? 'EMANP');
                
                // Refresh mail manager to apply new config
                app()->forgetInstance('mail.manager');
            } else {
                \Log::warning('Email settings not configured. Using default mail config.');
                // Fallback to log driver
                Config::set('mail.default', 'log');
            }
        } catch (\Exception $e) {
            \Log::error('Failed to load email configuration', [
                'error' => $e->getMessage()
            ]);
            // Fallback to log driver
            Config::set('mail.default', 'log');
        }
    }
}

