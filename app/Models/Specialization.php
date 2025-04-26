<?php

namespace App\Models;

use App\Enums\SpecializationColor;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Specialization extends Model
{
    /** @use HasFactory<\Database\Factories\SpecializationFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'description',
        'color'
    ];

    protected $casts = [
        'color' => SpecializationColor::class,
    ];

    public function doctors(): HasMany
    {
        return $this->hasMany(Doctor::class);
    }
}
