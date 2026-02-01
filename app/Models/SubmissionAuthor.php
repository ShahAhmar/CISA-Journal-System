<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmissionAuthor extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_id',
        'first_name',
        'last_name',
        'email',
        'affiliation',
        'orcid',
        'bio',
        'order',
        'is_corresponding',
    ];

    protected function casts(): array
    {
        return [
            'is_corresponding' => 'boolean',
        ];
    }

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}

