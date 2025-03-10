<?php

namespace App\Models;

use App\Models\Specialization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Doctor extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'specialization_id',
        'is_active',
        'profile_picture_path'
    ];

    public function specialization(): BelongsTo
    {
        return $this->belongsTo(Specialization::class);
    }
}
