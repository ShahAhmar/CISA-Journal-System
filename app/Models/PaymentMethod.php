<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'journal_id',
        'name',
        'type',
        'description',
        'fixed_amount',
        'currency',
        'details',
        'is_active',
        'service_type',
        'fees',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'fixed_amount' => 'decimal:2',
        'fees' => 'array',
    ];

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }
}
