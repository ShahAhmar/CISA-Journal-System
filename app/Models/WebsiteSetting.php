<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo',
        'favicon',
        'homepage_title',
        'homepage_description',
        'footer_text',
        'contact_email',
        'contact_phone',
        'contact_address',
        'facebook_url',
        'twitter_url',
        'linkedin_url',
        'instagram_url',
        'footer_description',
        'support_button_text',
        'support_button_url',
        'footer_section_1_title',
        'footer_section_2_title',
        'footer_section_3_title',
        'footer_links',
    ];

    protected $casts = [
        'footer_links' => 'array',
    ];

    public static function getSettings()
    {
        return static::first() ?? new static();
    }
}
