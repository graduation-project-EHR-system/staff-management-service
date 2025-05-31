<?php
namespace App\Repositories;

use App\Models\Specialization;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentSpecializationRepository implements SpecializationRepository
{
    public function getPaginated(int $perPage = 15, array $with = []): LengthAwarePaginator
    {
        return Specialization::with($with)->paginate($perPage);
    }

    public function getById(string $id, array $with = []): Specialization
    {
        return Specialization::with($with)->findOrFail($id);
    }

    public function create(\App\Data\Specialization\SpecializationDto $specializationDto): Specialization
    {
        return Specialization::query()->create($specializationDto->toArray());
    }

    public function update(Specialization $specialization, \App\Data\Specialization\SpecializationDto $specializationDto): Specialization
    {
        $specialization->update($specializationDto->toArray());
        return $specialization->fresh();
    }

    public function delete(Specialization $specialization): void
    {
        $specialization->delete();
    }
}
