<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JournalPageSetting;
use Illuminate\Http\Request;

class VisualEditorController extends Controller
{
    public function edit($id)
    {
        $page = JournalPageSetting::findOrFail($id);
        return view('admin.visual-editor.editor', compact('page'));
    }

    public function store(Request $request, $id)
    {
        $page = JournalPageSetting::findOrFail($id);

        $page->update([
            'content_html' => $request->html,
            'content_css' => $request->css,
            'grapesjs_data' => json_decode($request->components, true),
        ]);

        return response()->json(['success' => true]);
    }
}
