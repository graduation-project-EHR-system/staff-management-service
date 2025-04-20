<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 *
 * @property bool $is_active
 * @property int $current_doctors
 * @property int $max_doctors
 */
class Clinic extends Model
{
    /** @use HasFactory<\Database\Factories\ClinicFactory> */
    use HasFactory, Filterable;

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

    public function hasDoctor(int $doctorId): bool
    {
        return $this->doctors()->where('doctor_id', $doctorId)->exists();
    }
}
