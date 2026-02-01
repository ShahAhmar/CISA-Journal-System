<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    use HasFactory;

    protected $fillable = [
        'journal_id',
        'type',
        'name',
        'content',
        'settings',
        'is_active',
        'order',
        'location',
    ];

    protected function casts(): array
    {
        return [
            'content' => 'array',
            'settings' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    // Available widget types
    public static function getAvailableTypes()
    {
        return [
            'hero' => 'Hero Section',
            'text' => 'Text Block',
            'image' => 'Image',
            'gallery' => 'Image Gallery',
            'testimonial' => 'Testimonials',
            'stats' => 'Statistics',
            'latest_articles' => 'Latest Articles',
            'call_to_action' => 'Call to Action',
            'video' => 'Video',
            'contact_form' => 'Contact Form',
            'team' => 'Team Members',
            'features' => 'Features Grid',
            'faq' => 'FAQ Section',
            'timeline' => 'Timeline',
            'pricing' => 'Pricing Table',
            'newsletter' => 'Newsletter Signup',
        ];
    }
}

