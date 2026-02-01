<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class JournalDiscipline extends Model
{
    use HasFactory;

    protected $fillable = [
        'journal_id',
        'name',
        'slug',
        'description',
        'display_order',
    ];

    /**
     * Boot method to auto-generate slug
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($discipline) {
            if (empty($discipline->slug)) {
                $discipline->slug = Str::slug($discipline->name);
            }
        });
    }

    /**
     * Relationship: Belongs to Journal
     */
    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }
}
