<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\Submission;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Role-based redirect
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'reviewer') {
            return redirect()->route('reviewer.dashboard');
        } elseif ($user->role === 'copyeditor') {
            return redirect()->route('copyeditor.dashboard');
        } elseif ($user->role === 'proofreader') {
            return redirect()->route('proofreader.dashboard');
        }

        // Check if user has editor/journal_manager/section_editor role in any journal
        $editorJournals = $user->journals()
            ->wherePivotIn('role', ['journal_manager', 'editor', 'section_editor'])
            ->wherePivot('is_active', true)
            ->get();

        if ($editorJournals->count() > 0) {
            // If only one journal, redirect directly
            if ($editorJournals->count() === 1) {
                return redirect()->route('editor.dashboard', $editorJournals->first());
            }
            // If multiple journals, show selection page
            return view('editor.journal-selection', compact('editorJournals'));
        }

        // Default: Author or other roles
        $userJournals = $user->journals()->get();
        $submissions = Submission::where('user_id', $user->id)->latest()->take(10)->get();

        return view('dashboard', compact('userJournals', 'submissions'));
    }
}

