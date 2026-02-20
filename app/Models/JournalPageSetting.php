<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalPageSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'journal_id',
        'page_key',
        'page_title',
        'menu_label',
        'is_enabled',
        'display_order',
        'content_html',
        'content_css',
        'grapesjs_data',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'grapesjs_data' => 'array',
    ];

    /**
     * Relationship: Belongs to Journal
     */
    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    /**
     * Get default page settings for a new journal
     */
    public static function getDefaults()
    {
        return [
            ['page_key' => 'home', 'page_title' => 'Home', 'menu_label' => 'Home', 'display_order' => 0],
            ['page_key' => 'about', 'page_title' => 'About CIJ', 'menu_label' => 'About CIJ', 'display_order' => 1],
            ['page_key' => 'info', 'page_title' => 'Journal Info', 'menu_label' => 'Journal', 'display_order' => 2],
            ['page_key' => 'publications', 'page_title' => 'Publications', 'menu_label' => 'Publications', 'display_order' => 3],
            ['page_key' => 'call_for_papers', 'page_title' => 'Call for Papers', 'menu_label' => 'Call for Papers', 'display_order' => 4],
            ['page_key' => 'apc', 'page_title' => 'APC & Submission', 'menu_label' => 'APC & Submission', 'display_order' => 5],
            ['page_key' => 'editorial', 'page_title' => 'Editorial & Ethics', 'menu_label' => 'Editorial & Ethics', 'display_order' => 6],
            ['page_key' => 'partnerships', 'page_title' => 'Partnerships', 'menu_label' => 'Partnerships', 'display_order' => 7],
            ['page_key' => 'contact', 'page_title' => 'Contact', 'menu_label' => 'Contact', 'display_order' => 8],
        ];
    }
}
