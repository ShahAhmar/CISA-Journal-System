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
    ];

    public static function getSettings()
    {
        return static::first() ?? new static();
    }
}
