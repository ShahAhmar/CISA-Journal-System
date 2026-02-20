<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JournalController extends Controller
{
    public function index()
    {
        $journals = Journal::latest()->paginate(20);
        return view('admin.journals.index', compact('journals'));
    }

    public function create()
    {
        return view('admin.journals.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateJournal($request);
        
        // Handle file uploads
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('journals/logos', 'public');
        }
        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('journals/covers', 'public');
        }
        if ($request->hasFile('favicon')) {
            $validated['favicon'] = $request->file('favicon')->store('journals/favicons', 'public');
        }

        // Auto-generate slug
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Handle JSON fields
        $validated = $this->processJsonFields($validated, $request);
        
        // Handle boolean field
        $validated['requires_review'] = $request->has('requires_review') ? true : false;

        Journal::create($validated);

        return redirect()->route('admin.journals.index')
            ->with('success', 'Journal created successfully.');
    }

    public function show(Journal $journal)
    {
        return view('admin.journals.show', compact('journal'));
    }

    public function edit(Journal $journal)
    {
        return view('admin.journals.edit', compact('journal'));
    }

    public function update(Request $request, Journal $journal)
    {
        $validated = $this->validateJournal($request, $journal);
        
        // Handle file uploads
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('journals/logos', 'public');
        }
        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('journals/covers', 'public');
        }
        if ($request->hasFile('favicon')) {
            $validated['favicon'] = $request->file('favicon')->store('journals/favicons', 'public');
        }

        // Ensure slug is not null
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Handle JSON fields
        $validated = $this->processJsonFields($validated, $request);
        
        // Handle boolean field
        $validated['requires_review'] = $request->has('requires_review') ? true : false;

        $journal->update($validated);

        return redirect()->route('admin.journals.index')
            ->with('success', 'Journal updated successfully.');
    }

    public function destroy(Journal $journal)
    {
        $journal->delete();
        return redirect()->route('admin.journals.index')
            ->with('success', 'Journal deleted successfully.');
    }

    private function validateJournal(Request $request, $journal = null)
    {
        $rules = [
            // Basic Information
            'name' => ['required', 'string', 'max:255'],
            'journal_initials' => ['nullable', 'string', 'max:50'],
            'slug' => ['nullable', 'string', 'max:255', $journal ? 'unique:journals,slug,' . $journal->id : 'unique:journals,slug'],
            'journal_url' => ['nullable', 'string', 'max:255'],
            'journal_abbreviation' => ['nullable', 'string', 'max:100'],
            'authors' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            
            // ISSN Information
            'issn' => ['nullable', 'string', 'max:255'],
            'print_issn' => ['nullable', 'string', 'max:255'],
            'online_issn' => ['nullable', 'string', 'max:255'],
            
            // Contact Information
            'primary_contact_name' => ['nullable', 'string', 'max:255'],
            'primary_contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'contact_address' => ['nullable', 'string'],
            'support_contact_name' => ['nullable', 'string', 'max:255'],
            'support_email' => ['nullable', 'email', 'max:255'],
            
            // Content Sections
            'aims_scope' => ['nullable', 'string'],
            'focus_scope' => ['nullable', 'string'],
            'publication_frequency' => ['nullable', 'string'],
            'peer_review_process' => ['nullable', 'string'],
            'peer_review_policy' => ['nullable', 'string'],
            'open_access_policy' => ['nullable', 'string'],
            'copyright_notice' => ['nullable', 'string'],
            'privacy_statement' => ['nullable', 'string'],
            
            // Editorial Team
            'editor_in_chief' => ['nullable', 'string'],
            'managing_editor' => ['nullable', 'string'],
            'section_editors' => ['nullable', 'string'],
            'editorial_board' => ['nullable', 'string'],
            'editorial_team' => ['nullable', 'string'],
            'editorial_board_members' => ['nullable', 'string'],
            
            // Author Guidelines
            'submission_guidelines' => ['nullable', 'string'],
            'author_guidelines' => ['nullable', 'string'],
            'submission_requirements' => ['nullable', 'string'],
            'submission_checklist' => ['nullable', 'string'],
            'competing_interest_statement' => ['nullable', 'string'],
            'copyright_agreement' => ['nullable', 'string'],
            
            // Review Settings
            'review_rounds' => ['nullable', 'integer', 'min:1', 'max:5'],
            'review_method' => ['nullable', 'string', 'in:double_blind,single_blind,open'],
            'requires_review' => ['nullable', 'boolean'],
            'review_forms' => ['nullable', 'string'],
            
            // Issue & Article Settings
            'doi_prefix' => ['nullable', 'string', 'max:255'],
            'doi_enabled' => ['nullable', 'boolean'],
            
            // Website Settings
            'logo' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif,webp', 'max:5120'],
            'cover_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif,webp', 'max:5120'],
            'favicon' => ['nullable', 'image', 'mimes:ico,png', 'max:1024'],
            'theme' => ['nullable', 'string', 'max:100'],
            'homepage_content' => ['nullable', 'string'],
            'footer_content' => ['nullable', 'string'],
            
            // Payment & License
            'license_type' => ['nullable', 'string', 'max:100'],
            
            // Language & Regional
            'primary_language' => ['nullable', 'string', 'max:10'],
            'timezone' => ['nullable', 'string', 'max:100'],
            'date_format' => ['nullable', 'string', 'max:50'],
            
            // File Upload Settings
            'max_file_size' => ['nullable', 'integer', 'min:1', 'max:100'],
            'plagiarism_check_required' => ['nullable', 'boolean'],
            
            // System
            'is_active' => ['nullable', 'boolean'],
        ];

        return $request->validate($rules);
    }

    private function processJsonFields($validated, Request $request)
    {
        $jsonFields = [
            'theme_settings',
            'navigation_menu_items',
            'slider_blocks',
            'indexing_metadata',
            'archive_settings',
            'payment_settings',
            'additional_languages',
            'regional_settings',
            'allowed_formats',
        ];

        foreach ($jsonFields as $field) {
            if (isset($validated[$field]) && is_array($validated[$field])) {
                // Convert array to JSON string for database storage
                $validated[$field] = json_encode($validated[$field]);
            } elseif ($request->has($field)) {
                $value = $request->input($field);
                if (is_array($value)) {
                    $validated[$field] = json_encode($value);
                } elseif (!empty($value)) {
                    // If it's already a JSON string, keep it as is
                    $validated[$field] = $value;
                } else {
                    // If empty, set to null or empty JSON array
                    $validated[$field] = null;
                }
            } else {
                // If field not present in request, set to null for JSON fields
                $validated[$field] = null;
            }
        }

        // Handle allowed_formats specifically (from checkbox array)
        if ($request->has('allowed_formats')) {
            $formats = $request->input('allowed_formats', []);
            $validated['allowed_formats'] = !empty($formats) ? json_encode($formats) : null;
        } else {
            // If checkbox array not present, set to null
            $validated['allowed_formats'] = null;
        }

        return $validated;
    }
}
