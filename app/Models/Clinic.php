<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

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

    public function doctors(): HasManyThrough
    {
        return $this->hasManyThrough(
            Doctor::class,
            DoctorAvailability::class,
            'clinic_id',
            'id',
            'id',
            'doctor_id'
        );
    }
}
