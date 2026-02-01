<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use Illuminate\Http\Request;

class JournalPagesController extends Controller
{
    public function index(Request $request)
    {
        $journals = Journal::where('is_active', true)->orderBy('name')->get();

        $journalId = $request->get('journal');
        $journal = null;
        $pages = [];

        if ($journalId) {
            $journal = Journal::find($journalId);
        } else {
            $journal = $journals->first();
        }

        if ($journal) {
            // Ensure basic settings exist for this journal
            $requiredKeys = ['home', 'about', 'info', 'publications', 'call_for_papers', 'apc', 'editorial', 'partnerships', 'contact'];
            foreach ($requiredKeys as $index => $key) {
                \App\Models\JournalPageSetting::firstOrCreate(
                    ['journal_id' => $journal->id, 'page_key' => $key],
                    [
                        'page_title' => ucwords(str_replace('_', ' ', $key)),
                        'menu_label' => ucwords(str_replace('_', ' ', $key)),
                        'display_order' => $index + 1,
                        'is_enabled' => true
                    ]
                );
            }

            $pages = $this->getJournalPages($journal);
        }

        return view('admin.journal-pages.index', compact('journals', 'journal', 'pages'));
    }

    public function edit(Journal $journal, $pageType)
    {
        $pageTypes = $this->getPageTypes();

        if (!isset($pageTypes[$pageType])) {
            abort(404, 'Page type not found');
        }

        $pageData = $this->getPageData($journal, $pageType);

        // Check if live editor is requested
        $useLiveEditor = request()->get('live', false);

        if ($useLiveEditor) {
            return view('admin.journal-pages.edit-live', compact('journal', 'pageType', 'pageData', 'pageTypes'));
        }

        return view('admin.journal-pages.edit', compact('journal', 'pageType', 'pageData', 'pageTypes'));
    }

    public function update(Request $request, Journal $journal, $pageType)
    {
        $pageTypes = $this->getPageTypes();

        if (!isset($pageTypes[$pageType])) {
            abort(404, 'Page type not found');
        }

        $validated = $request->validate([
            'content' => 'nullable|string',
        ]);

        // Special handling for editorial_board - parse and save to multiple fields
        if ($pageType === 'editorial_board') {
            $this->saveEditorialBoardContent($journal, $validated['content']);
        } else {
            // Update the specific field in journal
            $fieldName = $pageTypes[$pageType]['field'];
            $journal->update([
                $fieldName => $validated['content']
            ]);
        }

        return redirect()->route('admin.journal-pages.index', ['journal' => $journal->id])
            ->with('success', ucfirst(str_replace('_', ' ', $pageType)) . ' page updated successfully!');
    }

    private function getJournalPages(Journal $journal)
    {
        $pageTypes = $this->getPageTypes();
        $pages = [];

        foreach ($pageTypes as $type => $config) {
            // Special handling for editorial_board
            if ($type === 'editorial_board') {
                $content = $this->getEditorialBoardContent($journal);
                $hasContent = !empty($content) && strlen(strip_tags($content)) > 50;
            } else {
                $fieldName = $config['field'];
                $content = $journal->$fieldName ?? '';
                $hasContent = !empty($content);
            }

            $pageSetting = \App\Models\JournalPageSetting::where('journal_id', $journal->id)
                ->where('page_key', $type)
                ->first();

            if (!$pageSetting) {
                $map = [
                    'vision' => 'about',
                    'mission' => 'about',
                    'aims_scope' => 'about',
                    'ethics_policy' => 'editorial',
                    'editorial_board' => 'editorial',
                    'apc_policy' => 'apc',
                    'contact' => 'contact',
                    'call_for_papers' => 'call_for_papers',
                    'partnerships' => 'partnerships'
                ];
                if (isset($map[$type])) {
                    $pageSetting = \App\Models\JournalPageSetting::where('journal_id', $journal->id)
                        ->where('page_key', $map[$type])
                        ->first();
                }
            }

            $pages[] = [
                'type' => $type,
                'name' => $config['name'],
                'icon' => $config['icon'],
                'route' => $config['route'],
                'has_content' => $hasContent,
                'content_preview' => $content ? substr(strip_tags($content), 0, 100) . '...' : 'No content',
                'last_updated' => $journal->updated_at,
                'setting_id' => $pageSetting ? $pageSetting->id : null,
            ];
        }

        return $pages;
    }

    private function getPageTypes()
    {
        return [
            'home' => [
                'name' => 'Journal Homepage',
                'icon' => 'fas fa-home',
                'field' => 'homepage_content', // Field in Journal model for standard editor
                'route' => 'journals.show',
                'description' => 'Current landing page of your journal',
            ],
            'about' => [
                'name' => 'About CIJ',
                'icon' => 'fas fa-info-circle',
                'field' => 'description',
                'route' => 'journals.about',
                'description' => 'Main about page including vision, mission, and scope',
            ],
            'editorial' => [
                'name' => 'Editorial & Ethics',
                'icon' => 'fas fa-users',
                'field' => 'editorial_board',
                'route' => 'journals.editorial-ethics',
                'description' => 'Editorial board members and publication ethics',
            ],
            'apc' => [
                'name' => 'APC & Submission',
                'icon' => 'fas fa-money-bill-wave',
                'field' => 'apc_policy',
                'route' => 'journals.apc-submission',
                'description' => 'Author fee information and submission process',
            ],
            'publications' => [
                'name' => 'Publications Master List',
                'icon' => 'fas fa-book-open',
                'field' => null,
                'route' => 'journals.publications',
                'description' => 'Searchable list of all published research',
            ],
            'call_for_papers' => [
                'name' => 'Call for Papers',
                'icon' => 'fas fa-bullhorn',
                'field' => 'call_for_papers',
                'route' => 'journals.call-for-papers',
                'description' => 'Submission invitations and focus areas',
            ],
            'partnerships' => [
                'name' => 'Partnerships',
                'icon' => 'fas fa-handshake',
                'field' => 'partnerships_content',
                'route' => 'journals.partnerships',
                'description' => 'Collaboration and network partners',
            ],
            'contact' => [
                'name' => 'Contact Page',
                'icon' => 'fas fa-envelope',
                'field' => 'contact_address',
                'route' => 'journals.contact',
                'description' => 'Contact forms and address information',
            ],
            // Keeping some granular ones if wanted, but user wants "Home" pages
            'author_guidelines' => [
                'name' => 'Author Guidelines',
                'icon' => 'fas fa-user-edit',
                'field' => 'author_guidelines',
                'route' => 'journals.author-guidelines',
                'description' => 'Detailed preparation steps for authors',
            ],
        ];
    }

    private function getPageData(Journal $journal, $pageType)
    {
        $pageTypes = $this->getPageTypes();
        $fieldName = $pageTypes[$pageType]['field'];

        // Special handling for editorial_board - combine multiple fields
        if ($pageType === 'editorial_board') {
            $content = $this->getEditorialBoardContent($journal);
        } else {
            $content = $journal->$fieldName ?? '';
        }

        return [
            'content' => $content,
            'name' => $pageTypes[$pageType]['name'],
            'description' => $pageTypes[$pageType]['description'] ?? '',
        ];
    }

    private function getEditorialBoardContent(Journal $journal)
    {
        $sections = [];

        // Reload journal to ensure we have latest data
        $journal->refresh();

        // Debug: Log what we're getting
        \Log::info('Editorial Board Content Debug', [
            'editor_in_chief' => !empty($journal->editor_in_chief) ? 'has content' : 'empty',
            'managing_editor' => !empty($journal->managing_editor) ? 'has content' : 'empty',
            'section_editors' => !empty($journal->section_editors) ? 'has content' : 'empty',
            'editorial_board_members' => !empty($journal->editorial_board_members) ? 'has content' : 'empty',
        ]);

        if (!empty($journal->editor_in_chief)) {
            $content = trim($journal->editor_in_chief);
            $sections[] = '<h2>Editor-in-Chief</h2>' . $content;
        }

        if (!empty($journal->managing_editor)) {
            $content = trim($journal->managing_editor);
            $sections[] = '<h2>Managing Editor</h2>' . $content;
        }

        if (!empty($journal->section_editors)) {
            $content = trim($journal->section_editors);
            $sections[] = '<h2>Section Editors</h2>' . $content;
        }

        if (!empty($journal->editorial_board_members)) {
            $content = trim($journal->editorial_board_members);
            $sections[] = '<h2>Editorial Board Members</h2>' . $content;
        }

        $combined = implode('<div style="margin: 30px 0;"></div>', $sections);

        // If no content, return empty with placeholders
        if (empty($combined) || strlen(strip_tags($combined)) < 50) {
            return '<h2>Editor-in-Chief</h2><p>Add editor-in-chief information here...</p><div style="margin: 30px 0;"></div><h2>Managing Editor</h2><p>Add managing editor information here...</p><div style="margin: 30px 0;"></div><h2>Section Editors</h2><p>Add section editors information here...</p><div style="margin: 30px 0;"></div><h2>Editorial Board Members</h2><p>Add editorial board members information here...</p>';
        }

        return $combined;
    }

    private function saveEditorialBoardContent(Journal $journal, $content)
    {
        // Simple approach: Split by H2 headings and save to respective fields
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        @$dom->loadHTML('<?xml encoding="UTF-8">' . $content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $xpath = new \DOMXPath($dom);

        $fields = [
            'editor_in_chief' => 'Editor-in-Chief',
            'managing_editor' => 'Managing Editor',
            'section_editors' => 'Section Editors',
            'editorial_board_members' => 'Editorial Board Members',
        ];

        $updates = [];

        foreach ($fields as $field => $heading) {
            // Find the section by heading
            $headings = $xpath->query("//h2[contains(text(), '{$heading}')]");
            if ($headings->length > 0) {
                $headingNode = $headings->item(0);
                $sectionContent = '';
                $nextSibling = $headingNode->nextSibling;

                // Collect content until next h2 or end
                while ($nextSibling) {
                    if ($nextSibling->nodeName === 'h2') {
                        break;
                    }
                    if ($nextSibling->nodeType === XML_ELEMENT_NODE || $nextSibling->nodeType === XML_TEXT_NODE) {
                        $sectionContent .= $dom->saveHTML($nextSibling);
                    }
                    $nextSibling = $nextSibling->nextSibling;
                }

                if (!empty(trim($sectionContent))) {
                    $updates[$field] = trim($sectionContent);
                }
            }
        }

        // Update journal with parsed content
        if (!empty($updates)) {
            $journal->update($updates);
        } else {
            // If parsing fails, try to save to a single field as fallback
            // This shouldn't happen, but just in case
            $journal->update(['editorial_board' => $content]);
        }
    }
}

