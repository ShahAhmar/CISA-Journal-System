<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProofreaderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $user = Auth::user();
        
        // Get journal IDs where user has proofreader role
        $journalIds = $user->journals()
            ->wherePivot('role', 'proofreader')
            ->wherePivot('is_active', true)
            ->pluck('journals.id');
        
        // Get submissions assigned to this proofreader or in proofreading stage
        $submissions = Submission::where('current_stage', 'proofreading')
            ->whereIn('journal_id', $journalIds)
            ->with(['journal', 'author'])
            ->orderBy('updated_at', 'desc')
            ->get();

        $pendingCount = $submissions->where('status', 'pending')->count();
        $inProgressCount = $submissions->where('status', 'in_progress')->count();
        $completedCount = $submissions->where('status', 'completed')->count();
        $totalCount = $submissions->count();

        return view('proofreader.dashboard', compact('submissions', 'pendingCount', 'inProgressCount', 'completedCount', 'totalCount'));
    }

    public function show(Submission $submission)
    {
        // Check if user has proofreader role for this journal
        $user = Auth::user();
        if (!$user->hasJournalRole($submission->journal_id, 'proofreader')) {
            abort(403, 'You do not have permission to view this submission.');
        }

        $submission->load(['journal', 'author', 'files', 'logs']);

        return view('proofreader.submission', compact('submission'));
    }

    public function uploadProofreadFile(Request $request, Submission $submission)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Handle file upload
        $file = $request->file('file');
        $path = $file->store('submissions/proofread', 'public');

        // Create file record
        $submission->files()->create([
            'file_type' => 'proofread_manuscript',
            'file_path' => $path,
            'file_name' => basename($path),
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
        ]);

        // Log action
        $submission->logs()->create([
            'user_id' => Auth::id(),
            'action' => 'proofread_file_uploaded',
            'message' => 'Proofread manuscript uploaded',
            'metadata' => ['file' => $file->getClientOriginalName(), 'notes' => $request->notes],
        ]);

        // Fire GalleyReadyForProduction event
        event(new \App\Events\GalleyReadyForProduction($submission));

        return redirect()->back()->with('success', 'Proofread file uploaded successfully!');
    }
}

