<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReviewForm;
use App\Models\Journal;
use Illuminate\Http\Request;

class ReviewFormController extends Controller
{
    public function index()
    {
        $forms = ReviewForm::with('journal')->orderBy('created_at', 'desc')->paginate(20);
        $journals = Journal::where('is_active', true)->get();
        
        return view('admin.review-forms.index', compact('forms', 'journals'));
    }

    public function create()
    {
        $journals = Journal::where('is_active', true)->get();
        return view('admin.review-forms.create', compact('journals'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'journal_id' => 'required|exists:journals,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'questions' => 'required|array',
            'is_default' => 'boolean',
        ]);

        ReviewForm::create($validated);

        return redirect()->route('admin.review-forms.index')
            ->with('success', 'Review form created successfully!');
    }

    public function show(ReviewForm $reviewForm)
    {
        return view('admin.review-forms.show', compact('reviewForm'));
    }

    public function edit(ReviewForm $reviewForm)
    {
        $journals = Journal::where('is_active', true)->get();
        return view('admin.review-forms.edit', compact('reviewForm', 'journals'));
    }

    public function update(Request $request, ReviewForm $reviewForm)
    {
        $validated = $request->validate([
            'journal_id' => 'required|exists:journals,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'questions' => 'required|array',
            'is_default' => 'boolean',
        ]);

        $reviewForm->update($validated);

        return redirect()->route('admin.review-forms.index')
            ->with('success', 'Review form updated successfully!');
    }

    public function destroy(ReviewForm $reviewForm)
    {
        $reviewForm->delete();

        return redirect()->route('admin.review-forms.index')
            ->with('success', 'Review form deleted successfully!');
    }
}
