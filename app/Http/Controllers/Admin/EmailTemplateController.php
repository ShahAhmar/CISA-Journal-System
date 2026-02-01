<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    public function index()
    {
        $journals = Journal::where('is_active', true)->get();
        $templates = [
            'submission_received' => [
                'name' => 'Submission Received',
                'description' => 'Sent to authors when their manuscript is successfully submitted.',
                'icon' => 'fa-envelope',
                'color' => 'blue',
            ],
            'reviewer_invitation' => [
                'name' => 'Reviewer Invitation',
                'description' => 'Sent to reviewers when they are invited to review a manuscript.',
                'icon' => 'fa-user-check',
                'color' => 'green',
            ],
            'acceptance_letter' => [
                'name' => 'Acceptance Letter',
                'description' => 'Sent to authors when their manuscript is accepted for publication.',
                'icon' => 'fa-check-circle',
                'color' => 'green',
            ],
            'rejection_letter' => [
                'name' => 'Rejection Letter',
                'description' => 'Sent to authors when their manuscript is rejected.',
                'icon' => 'fa-times-circle',
                'color' => 'red',
            ],
            'publication_confirmation' => [
                'name' => 'Publication Confirmation',
                'description' => 'Sent to authors when their article is published.',
                'icon' => 'fa-book',
                'color' => 'purple',
            ],
        ];

        return view('admin.email-templates.index', compact('journals', 'templates'));
    }

    public function edit(Request $request, $templateKey)
    {
        $journalId = $request->get('journal_id');
        $journal = $journalId ? Journal::findOrFail($journalId) : null;
        
        $templates = [
            'submission_received' => [
                'name' => 'Submission Received',
                'description' => 'Sent to authors when their manuscript is successfully submitted.',
            ],
            'reviewer_invitation' => [
                'name' => 'Reviewer Invitation',
                'description' => 'Sent to reviewers when they are invited to review a manuscript.',
            ],
            'acceptance_letter' => [
                'name' => 'Acceptance Letter',
                'description' => 'Sent to authors when their manuscript is accepted for publication.',
            ],
            'rejection_letter' => [
                'name' => 'Rejection Letter',
                'description' => 'Sent to authors when their manuscript is rejected.',
            ],
            'publication_confirmation' => [
                'name' => 'Publication Confirmation',
                'description' => 'Sent to authors when their article is published.',
            ],
        ];

        if (!isset($templates[$templateKey])) {
            abort(404, 'Template not found');
        }

        $template = $templates[$templateKey];
        $journals = Journal::where('is_active', true)->get();
        
        // Get existing template if journal is selected
        $existingTemplate = null;
        if ($journal) {
            $emailTemplates = $this->ensureEmailTemplatesArray($journal->email_templates);
            $existingTemplate = $emailTemplates[$templateKey] ?? null;
        }

        $placeholders = $this->getPlaceholders($templateKey);

        return view('admin.email-templates.edit', compact('template', 'templateKey', 'journals', 'journal', 'existingTemplate', 'placeholders'));
    }

    public function update(Request $request, $templateKey)
    {
        $validated = $request->validate([
            'journal_id' => ['required', 'exists:journals,id'],
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ]);

        $journal = Journal::findOrFail($validated['journal_id']);
        $emailTemplates = $this->ensureEmailTemplatesArray($journal->email_templates);
        
        $emailTemplates[$templateKey] = [
            'subject' => $validated['subject'],
            'body' => $validated['body'],
        ];

        // Ensure proper JSON encoding
        $journal->email_templates = $emailTemplates;
        $journal->save();
        
        // Refresh to ensure it's saved
        $journal->refresh();

        return redirect()->route('admin.email-templates.index')
            ->with('success', 'Email template updated successfully!');
    }

    /**
     * Ensure email_templates is always an array
     * Handles cases where it might be stored as JSON string
     */
    private function ensureEmailTemplatesArray($emailTemplates)
    {
        if (is_null($emailTemplates)) {
            return [];
        }
        
        if (is_string($emailTemplates)) {
            $decoded = json_decode($emailTemplates, true);
            return is_array($decoded) ? $decoded : [];
        }
        
        if (is_array($emailTemplates)) {
            return $emailTemplates;
        }
        
        return [];
    }

    private function getPlaceholders($templateKey)
    {
        $placeholders = [
            'submission_received' => [
                '{{author_name}}' => 'Author full name',
                '{{submission_title}}' => 'Submission title',
                '{{journal_name}}' => 'Journal name',
                '{{submission_id}}' => 'Submission ID',
                '{{submission_date}}' => 'Submission date',
            ],
            'reviewer_invitation' => [
                '{{reviewer_name}}' => 'Reviewer full name',
                '{{submission_title}}' => 'Submission title',
                '{{journal_name}}' => 'Journal name',
                '{{due_date}}' => 'Review due date',
                '{{submission_id}}' => 'Submission ID',
            ],
            'acceptance_letter' => [
                '{{author_name}}' => 'Author full name',
                '{{submission_title}}' => 'Submission title',
                '{{journal_name}}' => 'Journal name',
                '{{submission_id}}' => 'Submission ID',
            ],
            'rejection_letter' => [
                '{{author_name}}' => 'Author full name',
                '{{submission_title}}' => 'Submission title',
                '{{journal_name}}' => 'Journal name',
                '{{submission_id}}' => 'Submission ID',
            ],
            'publication_confirmation' => [
                '{{author_name}}' => 'Author full name',
                '{{submission_title}}' => 'Submission title',
                '{{journal_name}}' => 'Journal name',
                '{{publication_date}}' => 'Publication date',
                '{{article_url}}' => 'Article URL',
            ],
        ];

        return $placeholders[$templateKey] ?? [];
    }
}
