<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AvailabilitySlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'from',
        'to',
        'is_available'
    ];

    public function doctor() : BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}
