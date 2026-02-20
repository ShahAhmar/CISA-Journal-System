<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'journal_id',
        'name',
        'description',
        'questions',
        'is_active',
        'is_default',
        'sort_order',
    ];

    protected $casts = [
        'questions' => 'array',
        'is_active' => 'boolean',
        'is_default' => 'boolean',
    ];

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    /**
     * Get questions as structured array
     */
    public function getQuestionsAttribute($value)
    {
        return is_string($value) ? json_decode($value, true) : $value;
    }

    /**
     * Set questions as JSON
     */
    public function setQuestionsAttribute($value)
    {
        $this->attributes['questions'] = is_array($value) ? json_encode($value) : $value;
    }

    /**
     * Add a question to the form
     */
    public function addQuestion(array $question): void
    {
        $questions = $this->questions ?? [];
        $questions[] = $question;
        $this->questions = $questions;
    }

    /**
     * Get default form for journal
     */
    public static function getDefaultForJournal(int $journalId): ?self
    {
        return self::where('journal_id', $journalId)
            ->where('is_default', true)
            ->where('is_active', true)
            ->first();
    }
}
