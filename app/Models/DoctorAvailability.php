<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoctorAvailability extends Model
{
    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class);
    }
}