<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalPartner extends Model
{
    use HasFactory;

    protected $fillable = [
        'journal_id',
        'name',
        'logo',
        'website_url',
        'display_order',
    ];

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }
}
