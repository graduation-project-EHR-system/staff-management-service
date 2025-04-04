<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Clinic extends Model
{
    /** @use HasFactory<\Database\Factories\ClinicFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'current_doctors',
        'max_doctors',
        'is_active',
    ];

    public function doctors(): BelongsToMany
    {
        return $this->belongsToMany(
            Doctor::class,
            'doctor_schedule'
        )->distinct();
    }
}
