<?php

namespace App\Models;

use App\Models\Specialization;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 */
class Doctor extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = [
        'national_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'specialization_id',
        'is_active',
    ];

    public function specialization(): BelongsTo
    {
        return $this->belongsTo(Specialization::class);
    }

    public function availabilities(): HasMany
    {
        return $this->hasMany(DoctorAvailability::class);
    }

    public function upcomingAvailabilities(): HasMany
    {
        return $this->availabilities()
            ->where('date', '>', now()->format('Y-m-d'))
            ->orderBy('date');
    }
}
