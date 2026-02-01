<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\SubmissionFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileDownloadController extends Controller
{
    /**
     * Universal file download route - works for all authenticated users
     * Checks permissions based on user's role and submission access
     */
    public function download(Request $request, $submission, $file)
    {
        // Debug: Log that we reached the controller
        \Log::info('FileDownloadController::download called', [
            'submission_param' => $submission,
            'file_param' => $file,
            'url' => $request->fullUrl(),
        ]);

        // Resolve models manually (guard against collections)
        $submissionModel = Submission::find($submission);
        $fileModel = SubmissionFile::find($file);

        // If find() returned a collection (e.g., array passed), take first item
        if ($fileModel instanceof \Illuminate\Support\Collection) {
            $fileModel = $fileModel->first();
        }

        if (!$submissionModel) {
            abort(404, "Submission #{$submission} not found.");
        }

        if (!$fileModel) {
            abort(404, "File #{$file} not found.");
        }

        $submission = $submissionModel;
        $file = $fileModel;

        // Ensure file belongs to this submission
        if ($file->submission_id != $submission->id) {
            abort(404, 'File does not belong to this submission.');
        }

        $user = Auth::user();
        if (!$user) {
            abort(403, 'You must be logged in to download files.');
        }

        // Check if user has access to this submission
        $hasAccess = false;
        $accessReason = '';

        // Admin always has access
        if ($user->role === 'admin') {
            $hasAccess = true;
            $accessReason = 'admin';
        }
        // Author can access their own submissions
        elseif ($submission->user_id === $user->id) {
            $hasAccess = true;
            $accessReason = 'author';
        }
        // Associated authors (from submission_authors table) can also access
        elseif ($submission->authors()->where('email', $user->email)->exists()) {
            $hasAccess = true;
            $accessReason = 'associated_author';
        }
        // Check journal-level roles
        elseif (method_exists($user, 'hasJournalRole')) {
            // Editor, Journal Manager, Section Editor
            if ($user->hasJournalRole($submission->journal_id, ['journal_manager', 'editor', 'section_editor'])) {
                $hasAccess = true;
                $accessReason = 'editor/journal_manager/section_editor';
            }
            // Copyeditor for accepted submissions in copyediting or proofreading stage
            elseif ($user->hasJournalRole($submission->journal_id, 'copyeditor')) {
                if ($submission->status === 'accepted' && in_array($submission->current_stage, ['copyediting', 'proofreading'])) {
                    $hasAccess = true;
                    $accessReason = 'copyeditor';
                } else {
                    \Log::info('FileDownloadController: Copyeditor access denied', [
                        'user_id' => $user->id,
                        'submission_id' => $submission->id,
                        'submission_status' => $submission->status,
                        'current_stage' => $submission->current_stage,
                    ]);
                }
            }
            // Proofreader for accepted submissions in proofreading stage
            elseif ($user->hasJournalRole($submission->journal_id, 'proofreader')) {
                if ($submission->status === 'accepted' && $submission->current_stage === 'proofreading') {
                    $hasAccess = true;
                    $accessReason = 'proofreader';
                } else {
                    \Log::info('FileDownloadController: Proofreader access denied', [
                        'user_id' => $user->id,
                        'submission_id' => $submission->id,
                        'submission_status' => $submission->status,
                        'current_stage' => $submission->current_stage,
                    ]);
                }
            }
            // Reviewer can access files for their assigned reviews
            elseif ($user->hasJournalRole($submission->journal_id, 'reviewer')) {
                $hasReview = $submission->reviews()
                    ->where('reviewer_id', $user->id)
                    ->whereIn('status', ['pending', 'in_progress', 'completed'])
                    ->exists();
                if ($hasReview) {
                    $hasAccess = true;
                    $accessReason = 'reviewer';
                } else {
                    \Log::info('FileDownloadController: Reviewer access denied - no active review', [
                        'user_id' => $user->id,
                        'submission_id' => $submission->id,
                    ]);
                }
            }
        }

        // Log access attempt for debugging
        \Log::info('FileDownloadController: Access check', [
            'user_id' => $user->id,
            'user_role' => $user->role,
            'submission_id' => $submission->id,
            'submission_user_id' => $submission->user_id,
            'submission_status' => $submission->status,
            'current_stage' => $submission->current_stage,
            'journal_id' => $submission->journal_id,
            'has_access' => $hasAccess,
            'access_reason' => $accessReason,
        ]);

        if (!$hasAccess) {
            abort(403, 'You do not have permission to download this file.');
        }

        // Get file path - try multiple methods for shared hosting compatibility
        $filePath = $file->file_path;

        \Log::info('FileDownloadController: Attempting to download file', [
            'file_id' => $file->id,
            'file_path' => $filePath,
            'original_name' => $file->original_name,
        ]);

        // Try storage_path first (standard Laravel)
        $path = storage_path('app/public/' . $filePath);

        \Log::info('FileDownloadController: Checking path', ['path' => $path, 'exists' => file_exists($path)]);

        // If file doesn't exist, try alternative paths
        if (!file_exists($path)) {
            // Try with storage_path directly
            $altPath = storage_path('app/public/' . $filePath);
            \Log::info('FileDownloadController: Trying alternative path', ['alt_path' => $altPath, 'exists' => file_exists($altPath)]);

            if (file_exists($altPath)) {
                $path = $altPath;
            } else {
                // Try without 'public' in path (some shared hosting setups)
                $altPath2 = storage_path('app/' . $filePath);
                \Log::info('FileDownloadController: Trying second alternative', ['alt_path_2' => $altPath2, 'exists' => file_exists($altPath2)]);

                if (file_exists($altPath2)) {
                    $path = $altPath2;
                } else {
                    // Try public/uploads/ (common for some components in this app)
                    $altPath3 = public_path('uploads/' . $filePath);
                    \Log::info('FileDownloadController: Trying third alternative', ['alt_path_3' => $altPath3, 'exists' => file_exists($altPath3)]);

                    if (file_exists($altPath3)) {
                        $path = $altPath3;
                    } else {
                        // Log the issue for debugging
                        \Log::error('FileDownloadController: File not found on server', [
                            'file_id' => $file->id,
                            'file_path' => $filePath,
                            'tried_path_1' => $path,
                            'tried_path_2' => $altPath,
                            'tried_path_3' => $altPath2,
                            'tried_path_4' => $altPath3,
                            'storage_disk_path' => storage_path('app/public'),
                        ]);
                        abort(404, "File not found on server. File ID: {$file->id}, Path: {$filePath}");
                    }
                }
            }
        }

        // Return file download with proper headers
        $originalName = $file->original_name ?? $file->file_name;
        \Log::info('FileDownloadController: Returning file download', ['path' => $path, 'original_name' => $originalName]);

        return response()->download($path, $originalName);
    }

    public function downloadGalley(Request $request, $submission, $galley)
    {
        $submission = Submission::findOrFail($submission);
        $galley = \App\Models\Galley::findOrFail($galley);

        if ($galley->submission_id != $submission->id) {
            abort(404);
        }

        $user = Auth::user();
        if (!$user) {
            abort(403);
        }

        // Access check (similar to manuscript)
        $hasAccess = false;
        if ($user->role === 'admin' || $submission->user_id === $user->id) {
            $hasAccess = true;
        } elseif (method_exists($user, 'hasJournalRole')) {
            if ($user->hasJournalRole($submission->journal_id, ['journal_manager', 'editor', 'section_editor', 'copyeditor', 'proofreader'])) {
                $hasAccess = true;
            }
        }

        if (!$hasAccess) {
            abort(403);
        }

        $filePath = $galley->file_path;
        $path = storage_path('app/public/' . $filePath);

        if (!file_exists($path)) {
            $altPath = storage_path('app/' . $filePath);
            if (file_exists($altPath)) {
                $path = $altPath;
            } else {
                $altPath2 = public_path('uploads/' . $filePath);
                if (file_exists($altPath2)) {
                    $path = $altPath2;
                } else {
                    abort(404, "Galley file not found on server.");
                }
            }
        }

        return response()->download($path, $galley->original_name);
    }
}

