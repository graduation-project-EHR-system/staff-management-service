<?php

namespace App\Models;

use App\Models\Specialization;
use App\Util\Storage\StorageManager;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'specialization_id',
        'is_active',
        'profile_picture_path'
    ];

    public function getProfilePictureUrlAttribute(): string|null
    {
        return $this->profile_picture_path
            ? StorageManager::getUrl($this->profile_picture_path)
            : null;
    }

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
