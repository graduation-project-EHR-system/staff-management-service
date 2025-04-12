<?php

namespace App\Services;

use App\Data\Specialization\SpecializationDto;
use App\Models\Specialization;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SpecializationService
{
    public function getPaginated(
        int $perPage = 15
    ): LengthAwarePaginator
    {
        return Specialization::query()->paginate($perPage);
    }

    public function create(
        SpecializationDto $specializationDto
    ) : Specialization
    {
        return Specialization::query()->create($specializationDto->toArray());
    }

    public function update(
        SpecializationDto $specializationDto,
        Specialization $specialization
    ): Specialization
    {
        $specialization->update(
            $specializationDto->toArray()
        );

        return $specialization->fresh();
    }

    public function delete(Specialization $specialization): void
    {
        $specialization->delete();
    }
}
