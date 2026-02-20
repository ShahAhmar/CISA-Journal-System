<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use App\Models\JournalSection;
use App\Models\User;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index(Journal $journal)
    {
        $sections = $journal->sections()->orderBy('order')->get();
        return view('admin.sections.index', compact('journal', 'sections'));
    }

    public function create(Journal $journal)
    {
        $editors = $journal->editors()->get();
        return view('admin.sections.create', compact('journal', 'editors'));
    }

    public function store(Request $request, Journal $journal)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'section_editor_id' => 'nullable|exists:users,id',
            'word_limit_min' => 'nullable|integer|min:0',
            'word_limit_max' => 'nullable|integer|min:0|gt:word_limit_min',
            'review_type' => 'required|in:single_blind,double_blind,open',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['journal_id'] = $journal->id;
        $validated['is_active'] = $request->has('is_active');

        JournalSection::create($validated);

        return redirect()->route('admin.sections.index', $journal)
            ->with('success', 'Section created successfully!');
    }

    public function edit(Journal $journal, JournalSection $section)
    {
        if ($section->journal_id !== $journal->id) {
            abort(404);
        }

        $editors = $journal->editors()->get();
        return view('admin.sections.edit', compact('journal', 'section', 'editors'));
    }

    public function update(Request $request, Journal $journal, JournalSection $section)
    {
        if ($section->journal_id !== $journal->id) {
            abort(404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'section_editor_id' => 'nullable|exists:users,id',
            'word_limit_min' => 'nullable|integer|min:0',
            'word_limit_max' => 'nullable|integer|min:0|gt:word_limit_min',
            'review_type' => 'required|in:single_blind,double_blind,open',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $section->update($validated);

        return redirect()->route('admin.sections.index', $journal)
            ->with('success', 'Section updated successfully!');
    }

    public function destroy(Journal $journal, JournalSection $section)
    {
        if ($section->journal_id !== $journal->id) {
            abort(404);
        }

        $section->delete();

        return redirect()->route('admin.sections.index', $journal)
            ->with('success', 'Section deleted successfully!');
    }
}

