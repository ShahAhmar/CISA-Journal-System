<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'journal_id',
        'type',
        'status',
        'start_date',
        'end_date',
        'renewal_date',
        'amount',
        'payment_method',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'renewal_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active' && 
               $this->end_date >= now()->toDateString();
    }

    public function isExpired(): bool
    {
        return $this->end_date < now()->toDateString();
    }

    public function needsRenewal(): bool
    {
        return $this->isActive() && 
               $this->renewal_date && 
               $this->renewal_date <= now()->addDays(30)->toDateString();
    }
}
