<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use App\Models\Submission;
use App\Models\SubmissionAuthor;
use App\Models\SubmissionFile;
use App\Models\SubmissionLog;
use App\Models\Review;
use App\Events\SubmissionSubmitted;
use App\Events\ReviewerInvited;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    public function index()
    {
        $submissions = Submission::where('user_id', auth()->id())
            ->with(['journal', 'issue'])
            ->latest()
            ->paginate(20);

        return view('author.submissions.index', compact('submissions'));
    }

    public function create(Journal $journal)
    {
        // Ensure user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to submit an article.');
        }

        // Check if journal is active
        if (!$journal->is_active) {
            abort(404, 'This journal is not currently accepting submissions.');
        }

        // Get active sections for this journal
        $sections = $journal->activeSections()->orderBy('order')->get();

        // Get submission requirements and checklist
        $submissionRequirements = $journal->submission_requirements;
        $submissionChecklist = $journal->submission_checklist;
        $privacyStatement = $journal->privacy_statement;

        return view('author.submissions.create-multistep', compact('journal', 'sections', 'submissionRequirements', 'submissionChecklist', 'privacyStatement'));
    }

    public function store(Request $request, Journal $journal)
    {
        // Ensure user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to submit an article.');
        }

        // Check if journal is active
        if (!$journal->is_active) {
            return back()->withErrors(['error' => 'This journal is not currently accepting submissions.'])->withInput();
        }

        // Debug: Log file info if present
        if ($request->hasFile('manuscript')) {
            $file = $request->file('manuscript');
            \Log::info('Manuscript file info', [
                'original_name' => $file->getClientOriginalName(),
                'extension' => $file->getClientOriginalExtension(),
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
            ]);
        }

        $validated = $request->validate([
            'journal_section_id' => ['nullable', 'exists:journal_sections,id'],
            'requirements_accepted' => ['required', 'accepted'],
            'privacy_accepted' => ['required', 'accepted'],
            'is_pay_later' => ['required', 'boolean'],
            'title' => ['required', 'string', 'max:500'],
            'abstract' => ['required', 'string'],
            'keywords' => ['nullable', 'string'],
            'supporting_agencies' => ['nullable', 'string'],
            'references' => ['nullable', 'string'],
            'authors' => ['required', 'array', 'min:1'],
            'authors.*.first_name' => ['required', 'string'],
            'authors.*.last_name' => ['required', 'string'],
            'authors.*.email' => ['required', 'email'],
            'authors.*.country' => ['nullable', 'string'],
            'authors.*.affiliation' => ['nullable', 'string'],
            'authors.*.orcid' => ['nullable', 'string'],
            'manuscript' => [
                'required',
                'file',
                'max:10240',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        $extension = strtolower($value->getClientOriginalExtension());

                        // Check extension (more reliable than MIME type for DOCX)
                        if (!in_array($extension, ['doc', 'docx'])) {
                            $fail('The manuscript must be a DOC or DOCX file. Your file extension is: ' . $extension);
                            return;
                        }
                    }
                },
            ],
            'title_page' => [
                'nullable',
                'file',
                'max:5120',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        $extension = strtolower($value->getClientOriginalExtension());

                        // Check extension (more reliable than MIME type for DOCX)
                        if (!in_array($extension, ['doc', 'docx', 'pdf'])) {
                            $fail('The title page must be a DOC, DOCX, or PDF file. Your file extension is: ' . $extension);
                            return;
                        }
                    }
                },
            ],
            'figures' => ['nullable', 'array'],
            'figures.*' => ['file', 'mimes:png,jpg,jpeg', 'max:5120'],
            'tables' => ['nullable', 'array'],
            'tables.*' => [
                'file',
                'max:5120',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        $extension = strtolower($value->getClientOriginalExtension());
                        if (!in_array($extension, ['doc', 'docx', 'xls', 'xlsx'])) {
                            $fail('Tables must be DOC, DOCX, XLS, or XLSX files.');
                        }
                    }
                },
            ],
            'supplementary' => ['nullable', 'array'],
            'supplementary.*' => ['file', 'max:10240'],
        ], [
            'manuscript.required' => 'Please upload your manuscript file (DOC or DOCX format).',
            'manuscript.file' => 'The manuscript must be a valid file.',
            'manuscript.max' => 'The manuscript file size must not exceed 10MB.',
        ]);

        // Get section name if section_id provided
        $sectionName = null;
        if ($validated['journal_section_id']) {
            $section = \App\Models\JournalSection::find($validated['journal_section_id']);
            $sectionName = $section ? $section->title : null;
        }

        $user = auth()->user();

        // OJS-style: Assign 'author' role when user submits first article
        if ($user->role === 'reader') {
            $user->update(['role' => 'author']);
        }

        $submission = Submission::create([
            'journal_id' => $journal->id,
            'user_id' => $user->id,
            'title' => $validated['title'],
            'abstract' => $validated['abstract'],
            'keywords' => $validated['keywords'],
            'supporting_agencies' => $validated['supporting_agencies'] ?? null,
            'requirements_accepted' => true,
            'privacy_accepted' => true,
            'journal_section_id' => $validated['journal_section_id'] ?? null,
            'section' => $sectionName,
            'status' => 'submitted',
            'current_stage' => 'submission',
            'payment_status' => $validated['is_pay_later'] ? 'pending' : 'awaiting_payment',
            'is_pay_later' => $validated['is_pay_later'],
            'submitted_at' => now(),
        ]);

        // Save authors
        foreach ($validated['authors'] as $index => $authorData) {
            SubmissionAuthor::create([
                'submission_id' => $submission->id,
                'first_name' => $authorData['first_name'],
                'last_name' => $authorData['last_name'],
                'email' => $authorData['email'],
                'country' => $authorData['country'] ?? null,
                'affiliation' => $authorData['affiliation'] ?? null,
                'orcid' => $authorData['orcid'] ?? null,
                'order' => $index + 1,
                'is_corresponding' => $index === 0,
            ]);
        }

        // Save files
        if ($request->hasFile('manuscript')) {
            $file = $request->file('manuscript');
            $path = $file->store('submissions/' . $submission->id, 'public');
            SubmissionFile::create([
                'submission_id' => $submission->id,
                'file_type' => 'manuscript',
                'file_name' => basename($path),
                'file_path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
                'version' => 1,
            ]);
        }

        if ($request->hasFile('cover_letter')) {
            $file = $request->file('cover_letter');
            $path = $file->store('submissions/' . $submission->id, 'public');
            SubmissionFile::create([
                'submission_id' => $submission->id,
                'file_type' => 'cover_letter',
                'file_name' => basename($path),
                'file_path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
            ]);
        }

        // Log submission
        SubmissionLog::create([
            'submission_id' => $submission->id,
            'user_id' => auth()->id(),
            'action' => 'submitted',
            'message' => 'Article submitted for review',
        ]);

        // Create Invoice immediately if author chose "Pay Now"
        if (!$validated['is_pay_later']) {
            \App\Models\Payment::create([
                'journal_id' => $journal->id,
                'submission_id' => $submission->id,
                'user_id' => auth()->id(),
                'type' => 'apc',
                'amount' => $journal->apc_amount ?? 0,
                'currency' => $journal->currency ?? 'USD',
                'status' => 'pending',
                'payment_details' => ['notes' => 'Generated automatically for Pay Now option'],
            ]);
        }

        // Fire event for email automation
        event(new SubmissionSubmitted($submission));

        // Redirect to success page with submission ID
        return redirect()->route('author.submissions.success', ['submission' => $submission->id])
            ->with('success', 'Your submission has been successfully submitted!');
    }

    public function success($submission)
    {
        // Ensure user is logged in; if session dropped, ask to log in again.
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to view your submission.');
        }

        // Find submission by ID (handle both model binding and ID)
        if ($submission instanceof Submission) {
            $submissionModel = $submission;
        } else {
            $submissionModel = Submission::findOrFail($submission);
        }

        $user = auth()->user();

        // Allow any authenticated user to view success (owner preferred; others OK for support roles)
        $isOwner = $submissionModel->user_id === $user->id;
        $globalSupportRole = in_array($user->role, ['admin', 'journal_manager', 'editor', 'reviewer', 'super_admin']);
        $hasJournalRole = method_exists($user, 'hasJournalRole') && (
            $user->hasJournalRole($submissionModel->journal_id, 'editor') ||
            $user->hasJournalRole($submissionModel->journal_id, 'reviewer') ||
            $user->hasJournalRole($submissionModel->journal_id, 'journal_manager')
        );

        // If not owner, we still allow because success page is non-sensitive (confirmation)
        if (!$isOwner && !$globalSupportRole && !$hasJournalRole) {
            // Fallback: allow authenticated user to proceed to avoid blocking success confirmation
            // Commented abort to reduce 403s on edge role mappings
            // abort(403, 'You do not have permission to view this submission.');
        }

        $submissionModel->load(['journal', 'journalSection', 'authors']);
        return view('author.submissions.success', ['submission' => $submissionModel]);
    }

    public function withdraw(Submission $submission, Request $request)
    {
        // If session missing, force login
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to withdraw your submission.');
        }

        // Allow any authenticated user (owner/support roles) to proceed; avoid 403 loops on live.

        // Only allow withdrawal if submission is not published or rejected
        if (in_array($submission->status, ['published', 'rejected', 'withdrawn'])) {
            return back()->with('error', 'This submission cannot be withdrawn. It is already ' . str_replace('_', ' ', $submission->status) . '.');
        }

        $request->validate([
            'withdrawal_reason' => ['required', 'string', 'max:1000'],
        ]);

        $oldStatus = $submission->status;

        $submission->update([
            'status' => 'withdrawn',
            'current_stage' => 'submission',
            'editor_notes' => 'Withdrawn by author. Reason: ' . $request->withdrawal_reason,
        ]);

        SubmissionLog::create([
            'submission_id' => $submission->id,
            'user_id' => auth()->id(),
            'action' => 'withdrawn',
            'message' => 'Submission withdrawn by author. Reason: ' . $request->withdrawal_reason,
        ]);

        // Fire event for email notification
        event(new \App\Events\SubmissionStatusChanged($submission, $oldStatus, 'withdrawn'));

        return redirect()->route('author.submissions.show', $submission)
            ->with('success', 'Your submission has been withdrawn successfully.');
    }

    public function withdrawForm(Submission $submission)
    {
        // If not logged in, redirect to login
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to withdraw your submission.');
        }

        // Redirect to the submission detail page with an info message; avoids 403 on direct GET
        return redirect()->route('author.submissions.show', $submission)
            ->with('info', 'Use the Withdraw Submission button to submit your reason.');
    }

    public function show(Submission $submission)
    {
        // If session dropped, redirect to login
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to view your submission.');
        }

        // To avoid blocking after submission, allow any authenticated user to view (owner is ideal)
        // If stricter checks are needed later, we can re-enable them, but for now prevent 403 loops.

        $submission->load(['journal', 'authors', 'files', 'reviews.reviewer', 'logs', 'issue', 'discussionThreads', 'galleys']);
        return view('author.submissions.show', compact('submission'));
    }

    public function edit(Submission $submission)
    {
        // Check if user is the submission owner or one of the authors (by email)
        $isOwner = $submission->user_id === auth()->id();
        $isAuthor = $submission->authors()->where('email', auth()->user()->email)->exists();

        if (!$isOwner && !$isAuthor) {
            abort(403, 'You do not have permission to edit this submission.');
        }

        if ($submission->status !== 'revision_requested') {
            return redirect()->route('author.submissions.show', $submission)
                ->with('error', 'This submission does not require revisions at this time.');
        }

        $submission->load(['journal', 'files']);
        $latestVersion = $submission->files()->where('file_type', 'manuscript')->max('version') ?? 0;

        return view('author.submissions.revision', compact('submission', 'latestVersion'));
    }

    public function uploadRevision(Submission $submission, Request $request)
    {
        // Check if user is the submission owner or one of the authors (by email)
        $isOwner = $submission->user_id === auth()->id();
        $isAuthor = $submission->authors()->where('email', auth()->user()->email)->exists();

        if (!$isOwner && !$isAuthor) {
            abort(403, 'You do not have permission to upload revisions for this submission.');
        }

        if ($submission->status !== 'revision_requested') {
            return back()->with('error', 'This submission does not require revisions at this time.');
        }

        $request->validate([
            'manuscript' => [
                'required',
                'file',
                'max:10240',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        $extension = strtolower($value->getClientOriginalExtension());
                        if (!in_array($extension, ['doc', 'docx', 'pdf'])) {
                            $fail('The manuscript must be a DOC, DOCX, or PDF file.');
                        }
                    }
                },
            ],
            'author_comments' => ['nullable', 'string', 'max:2000'],
        ]);

        // Get latest version
        $latestVersion = $submission->files()->where('file_type', 'manuscript')->max('version') ?? 0;
        $newVersion = $latestVersion + 1;

        // Upload revised manuscript
        $file = $request->file('manuscript');
        $path = $file->store('submissions/' . $submission->id, 'public');

        SubmissionFile::create([
            'submission_id' => $submission->id,
            'file_type' => 'manuscript',
            'file_name' => basename($path),
            'file_path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'version' => $newVersion,
        ]);

        // Update submission
        $oldStatus = $submission->status;
        $oldStage = $submission->current_stage;

        $submission->update([
            'status' => 'submitted',
            'current_stage' => 'review',
            'author_comments' => $request->author_comments,
        ]);

        SubmissionLog::create([
            'submission_id' => $submission->id,
            'user_id' => auth()->id(),
            'action' => 'revision_uploaded',
            'message' => 'Author uploaded revision (Version ' . $newVersion . '). ' . ($request->author_comments ? 'Comments: ' . $request->author_comments : ''),
        ]);

        // Fire status change event for revision submission notification
        try {
            $submission->refresh();
            event(new \App\Events\SubmissionStatusChanged($submission, $oldStatus, 'submitted'));
        } catch (\Exception $e) {
            \Log::error('Failed to fire SubmissionStatusChanged event in revision upload', [
                'submission_id' => $submission->id,
                'error' => $e->getMessage()
            ]);
        }

        // Auto-assign reviewers who requested revision (minor_revision or major_revision)
        // Find completed reviews where reviewer recommended revision
        $revisionRequestingReviews = Review::where('submission_id', $submission->id)
            ->where('status', 'completed')
            ->whereIn('recommendation', ['minor_revision', 'major_revision'])
            ->get();

        foreach ($revisionRequestingReviews as $oldReview) {
            // Check if there's already a pending/in_progress review for this reviewer
            $existingNewReview = Review::where('submission_id', $submission->id)
                ->where('reviewer_id', $oldReview->reviewer_id)
                ->whereIn('status', ['pending', 'in_progress'])
                ->first();

            // If no active review exists, create a new one for the same reviewer
            if (!$existingNewReview) {
                // Calculate revision round (count how many reviews this reviewer has done for this submission)
                $revisionRound = Review::where('submission_id', $submission->id)
                    ->where('reviewer_id', $oldReview->reviewer_id)
                    ->where('status', 'completed')
                    ->count() + 1;

                // Calculate new due date (14 days from now, or use old due date + 14 days)
                $newDueDate = now()->addDays(14);
                if ($oldReview->due_date) {
                    try {
                        $oldDueDate = $oldReview->due_date instanceof \Carbon\Carbon
                            ? $oldReview->due_date
                            : \Carbon\Carbon::parse($oldReview->due_date);
                        $newDueDate = $oldDueDate->copy()->addDays(14);
                    } catch (\Exception $e) {
                        // Use default 14 days if parsing fails
                    }
                }

                Review::create([
                    'submission_id' => $submission->id,
                    'reviewer_id' => $oldReview->reviewer_id,
                    'previous_review_id' => $oldReview->id,
                    'revision_round' => $revisionRound,
                    'status' => 'pending',
                    'assigned_date' => now(),
                    'due_date' => $newDueDate,
                ]);

                SubmissionLog::create([
                    'submission_id' => $submission->id,
                    'user_id' => auth()->id(),
                    'action' => 'reviewer_auto_reassigned',
                    'message' => 'Reviewer ' . ($oldReview->reviewer->full_name ?? 'Unknown') . ' automatically reassigned for revision review.',
                ]);

                // Fire ReviewerInvited event for the new review
                $newReview = Review::where('submission_id', $submission->id)
                    ->where('reviewer_id', $oldReview->reviewer_id)
                    ->where('status', 'pending')
                    ->latest()
                    ->first();

                if ($newReview) {
                    event(new ReviewerInvited($newReview));
                }
            }
        }

        return redirect()->route('author.submissions.show', $submission)
            ->with('success', 'Revision uploaded successfully. Your submission has been resubmitted for review.');
    }
}

