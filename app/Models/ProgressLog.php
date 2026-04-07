<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgressLog extends Model
{
    protected $fillable = [
        'user_id', 
        'log_date', 
        'weight_kg', 
        'muscle_mass_kg', 
        'body_fat_pct', 
        'workout_notes'
    ];

    protected $casts = [
        'log_date' => 'date',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
