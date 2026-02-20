<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CopyeditorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $user = Auth::user();
        
        // Get journal IDs where user has copyeditor role
        $journalIds = $user->journals()
            ->wherePivot('role', 'copyeditor')
            ->wherePivot('is_active', true)
            ->pluck('journals.id');
        
        // Copyeditor can ONLY see ACCEPTED articles (not rejected, not under review)
        // Rule: Copyeditor sirf ACCEPTED articles handle karta hai
        $submissions = Submission::where('current_stage', 'copyediting')
            ->where('status', 'accepted') // IMPORTANT: Only accepted articles
            ->whereIn('journal_id', $journalIds)
            ->with(['journal', 'author'])
            ->orderBy('updated_at', 'desc')
            ->get();

        $pendingCount = $submissions->where('status', 'pending')->count();
        $inProgressCount = $submissions->where('status', 'in_progress')->count();
        $completedCount = $submissions->where('status', 'completed')->count();
        $totalCount = $submissions->count();

        return view('copyeditor.dashboard', compact('submissions', 'pendingCount', 'inProgressCount', 'completedCount', 'totalCount'));
    }

    public function show(Submission $submission)
    {
        // Check if user has copyeditor role for this journal
        $user = Auth::user();
        if (!$user->hasJournalRole($submission->journal_id, 'copyeditor')) {
            abort(403, 'You do not have permission to view this submission.');
        }

        // IMPORTANT: Copyeditor can ONLY work on ACCEPTED articles
        if ($submission->status !== 'accepted') {
            abort(403, 'Copyediting is only available for accepted articles. This submission status is: ' . ucfirst(str_replace('_', ' ', $submission->status)));
        }

        $submission->load(['journal', 'author', 'files', 'logs']);

        return view('copyeditor.submission', compact('submission'));
    }

    public function uploadCopyeditedFile(Request $request, Submission $submission)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Handle file upload
        $file = $request->file('file');
        $path = $file->store('submissions/copyedited', 'public');

        // Create file record
        $submission->files()->create([
            'file_type' => 'copyedited_manuscript',
            'file_path' => $path,
            'file_name' => basename($path),
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
        ]);

        // Log action
        $submission->logs()->create([
            'user_id' => Auth::id(),
            'action' => 'copyedited_file_uploaded',
            'message' => 'Copyedited manuscript uploaded',
            'metadata' => ['file' => $file->getClientOriginalName(), 'notes' => $request->notes],
        ]);

        // Fire CopyeditFilesReady event
        event(new \App\Events\CopyeditFilesReady($submission));

        return redirect()->back()->with('success', 'Copyedited file uploaded successfully!');
    }
}

