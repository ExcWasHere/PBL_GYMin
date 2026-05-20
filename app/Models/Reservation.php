<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'code',
        'session_date',
        'session_start',
        'session_end',
        'notes',
        'status',
        'confirmed_at',
        'confirmed_by',
    ];

    protected $casts = [
        'session_date'  => 'date',
        'confirmed_at'  => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function confirmedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeForDate($query, string $date)
    {
        return $query->where('session_date', $date);
    }

    public function getSessionLabelAttribute(): string
    {
        return $this->session_start . ' – ' . $this->session_end;
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }
}