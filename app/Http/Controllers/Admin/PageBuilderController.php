<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use App\Models\CustomPage;
use App\Models\Widget;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageBuilderController extends Controller
{
    // Page Builder for Journal Homepage
    public function homepageBuilder(Journal $journal)
    {
        $widgets = Widget::where(function($q) use ($journal) {
            $q->where('journal_id', $journal->id)
              ->orWhereNull('journal_id');
        })->where('is_active', true)
          ->where('location', 'homepage')
          ->orderBy('order')
          ->get();

        $homepageWidgets = $journal->homepage_widgets ?? [];

        return view('admin.page-builder.homepage', compact('journal', 'widgets', 'homepageWidgets'));
    }

    // Save Homepage Layout
    public function saveHomepageLayout(Request $request, Journal $journal)
    {
        $validated = $request->validate([
            'widgets' => 'required|array',
            'widgets.*.id' => 'required',
            'widgets.*.order' => 'required|integer',
        ]);

        $journal->update([
            'homepage_widgets' => $validated['widgets']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Homepage layout saved successfully!'
        ]);
    }

    // Custom Pages Management
    public function pagesIndex(Journal $journal = null)
    {
        $query = CustomPage::query();
        
        if ($journal) {
            $query->where('journal_id', $journal->id);
        } else {
            $query->whereNull('journal_id');
        }

        $pages = $query->orderBy('order')->paginate(20);
        
        return view('admin.page-builder.pages.index', compact('pages', 'journal'));
    }

    public function pagesCreate(Journal $journal = null)
    {
        return view('admin.page-builder.pages.create', compact('journal'));
    }

    public function pagesStore(Request $request, Journal $journal = null)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:custom_pages,slug',
            'content' => 'nullable|string',
            'widgets' => 'nullable|array',
            'is_published' => 'boolean',
            'show_in_menu' => 'boolean',
            'menu_label' => 'nullable|string|max:255',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $validated['journal_id'] = $journal?->id;

        CustomPage::create($validated);

        return redirect()->route('admin.page-builder.pages.index', $journal)
            ->with('success', 'Page created successfully!');
    }

    public function pagesEdit(CustomPage $page)
    {
        return view('admin.page-builder.pages.edit', compact('page'));
    }

    public function pagesUpdate(Request $request, CustomPage $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:custom_pages,slug,' . $page->id,
            'content' => 'nullable|string',
            'widgets' => 'nullable|array',
            'is_published' => 'boolean',
            'show_in_menu' => 'boolean',
            'menu_label' => 'nullable|string|max:255',
        ]);

        $page->update($validated);

        return redirect()->back()->with('success', 'Page updated successfully!');
    }

    // Widgets Management
    public function widgetsIndex(Journal $journal = null)
    {
        $query = Widget::query();
        
        if ($journal) {
            $query->where('journal_id', $journal->id)->orWhereNull('journal_id');
        } else {
            $query->whereNull('journal_id');
        }

        $widgets = $query->orderBy('order')->paginate(20);
        
        return view('admin.page-builder.widgets.index', compact('widgets', 'journal'));
    }

    public function widgetsCreate(Journal $journal = null)
    {
        $types = Widget::getAvailableTypes();
        return view('admin.page-builder.widgets.create', compact('types', 'journal'));
    }

    public function widgetsStore(Request $request, Journal $journal = null)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'name' => 'required|string|max:255',
            'content' => 'required|array',
            'location' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['journal_id'] = $journal?->id;
        $validated['content'] = json_encode($validated['content']);

        $validated['journal_id'] = $journal?->id;

        Widget::create($validated);

        return redirect()->route('admin.page-builder.widgets.index', $journal)
            ->with('success', 'Widget created successfully!');
    }

    public function widgetsEdit(Widget $widget)
    {
        $types = Widget::getAvailableTypes();
        return view('admin.page-builder.widgets.edit', compact('widget', 'types'));
    }

    public function widgetsUpdate(Request $request, Widget $widget)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'name' => 'required|string|max:255',
            'content' => 'required|array',
            'location' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $widget->update($validated);

        return redirect()->back()->with('success', 'Widget updated successfully!');
    }

    public function widgetsDestroy(Widget $widget)
    {
        $widget->delete();
        return redirect()->back()->with('success', 'Widget deleted successfully!');
    }

    public function widgetsShow(Widget $widget)
    {
        return response()->json($widget);
    }

    public function pagesDestroy(CustomPage $page)
    {
        $journal = $page->journal;
        $page->delete();
        return redirect()->route('admin.page-builder.pages.index', $journal)
            ->with('success', 'Page deleted successfully!');
    }
}

