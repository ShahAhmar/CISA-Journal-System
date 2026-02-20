<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CustomPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'journal_id',
        'title',
        'slug',
        'content',
        'widgets',
        'settings',
        'template',
        'is_published',
        'order',
        'show_in_menu',
        'menu_label',
        'meta_title',
        'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'widgets' => 'array',
            'settings' => 'array',
            'is_published' => 'boolean',
            'show_in_menu' => 'boolean',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });
    }

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }
}

