<?php
namespace App\Services;

use App\Data\Clinic\ClinicDto;
use App\Models\Clinic;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ClinicService
{
    public function getPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Clinic::query()->paginate($perPage);
    }

    public function update(ClinicDto $clinicDto, Clinic $clinic): Clinic
    {
        $clinic->update($clinicDto->toArray());

        return $clinic->fresh();
    }

    public function create(ClinicDto $clinicDto): Clinic
    {
        return Clinic::query()->create($clinicDto->toArray());
    }

    public function getById(int $clinicId): Clinic
    {
        return Clinic::query()->findOrFail($clinicId);
    }

    public function isActive(int $clinicId): bool
    {
        return $this->getById($clinicId)->is_active;
    }

    public function canHoldMoreDoctors(int $clinicId): bool
    {
        $clinic = $this->getById($clinicId);

        return $clinic->current_doctors < $clinic->max_doctors;
    }

    public function hasDoctor(int $clinicId, int $doctorId): bool
    {
        return $this->getById($clinicId)
            ->hasDoctor($doctorId);
    }
}
