<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmissionFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_id',
        'file_type',
        'file_name',
        'file_path',
        'original_name',
        'mime_type',
        'file_size',
        'version',
        'version_label',
        'parent_file_id',
        'version_notes',
        'is_current',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'is_current' => 'boolean',
        ];
    }

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    public function parentFile()
    {
        return $this->belongsTo(SubmissionFile::class, 'parent_file_id');
    }

    public function versions()
    {
        return $this->hasMany(SubmissionFile::class, 'parent_file_id')->orderBy('version', 'desc');
    }

    public function getCurrentVersionAttribute()
    {
        return $this->submission->files()
            ->where('file_type', $this->file_type)
            ->where('is_current', true)
            ->first();
    }
}

