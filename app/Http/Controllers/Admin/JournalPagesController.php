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
            
            $pages[] = [
                'type' => $type,
                'name' => $config['name'],
                'icon' => $config['icon'],
                'route' => $config['route'],
                'has_content' => $hasContent,
                'content_preview' => $content ? substr(strip_tags($content), 0, 100) . '...' : 'No content',
                'last_updated' => $journal->updated_at,
            ];
        }

        return $pages;
    }

    private function getPageTypes()
    {
        return [
            'aims_scope' => [
                'name' => 'Aims & Scope',
                'icon' => 'fas fa-bullseye',
                'field' => 'focus_scope',
                'route' => 'journals.aims-scope',
                'description' => 'Define the aims, scope, and focus areas of your journal',
            ],
            'editorial_board' => [
                'name' => 'Editorial Board',
                'icon' => 'fas fa-users',
                'field' => 'editorial_board',
                'route' => 'journals.editorial-board',
                'description' => 'Manage editorial board members and their information',
            ],
            'submission_guidelines' => [
                'name' => 'Submission Guidelines',
                'icon' => 'fas fa-file-upload',
                'field' => 'submission_guidelines',
                'route' => 'journals.submission-guidelines',
                'description' => 'Guidelines for authors on how to submit manuscripts',
            ],
            'author_guidelines' => [
                'name' => 'Author Guidelines',
                'icon' => 'fas fa-user-edit',
                'field' => 'author_guidelines',
                'route' => 'journals.author-guidelines',
                'description' => 'Detailed guidelines for authors preparing manuscripts',
            ],
            'peer_review_policy' => [
                'name' => 'Peer Review Policy',
                'icon' => 'fas fa-check-circle',
                'field' => 'peer_review_policy',
                'route' => 'journals.peer-review-policy',
                'description' => 'Our peer review process and standards',
            ],
            'open_access_policy' => [
                'name' => 'Open Access Policy',
                'icon' => 'fas fa-unlock',
                'field' => 'open_access_policy',
                'route' => 'journals.open-access-policy',
                'description' => 'Open access policy and licensing information',
            ],
            'copyright_notice' => [
                'name' => 'Copyright Notice',
                'icon' => 'fas fa-copyright',
                'field' => 'copyright_notice',
                'route' => 'journals.copyright-notice',
                'description' => 'Copyright and intellectual property information',
            ],
            'privacy_statement' => [
                'name' => 'Privacy Statement',
                'icon' => 'fas fa-shield-alt',
                'field' => 'privacy_statement',
                'route' => null,
                'description' => 'Privacy policy and data protection information',
            ],
            'contact' => [
                'name' => 'Contact Information',
                'icon' => 'fas fa-envelope',
                'field' => 'contact_address',
                'route' => 'journals.contact',
                'description' => 'Contact details and location information',
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

