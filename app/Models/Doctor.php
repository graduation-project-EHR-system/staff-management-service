<?php

namespace App\Models;

use App\Models\Specialization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    use HasFactory;

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

    public function availabilitySlots() : HasMany
    {
        return $this->hasMany(AvailabilitySlot::class);
    }

    public function schedules(): BelongsToMany
    {
        return $this->belongsToMany(Clinic::class)
            ->withPivot('date', 'from', 'to');
    }
}
