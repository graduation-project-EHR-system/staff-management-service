<?php
namespace App\Repositories;

use App\Models\Nurse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentNurseRepository implements NurseRepository
{
    public function getPaginated(int $perPage = 15, array $with = []): LengthAwarePaginator
    {
        return Nurse::with($with)->latest()->paginate($perPage);
    }

    public function getById(string $id, array $with = []): Nurse
    {
        return Nurse::with($with)->findOrFail($id);
    }

    public function create(\App\Data\Nurse\NurseDto $nurseDto): Nurse
    {
        return Nurse::query()->create($nurseDto->toArray());
    }

    public function update(Nurse $nurse, \App\Data\Nurse\NurseDto $nurseDto): Nurse
    {
        $nurse->update($nurseDto->toArray());
        return $nurse->fresh();
    }

    public function delete(Nurse $nurse): void
    {
        $nurse->delete();
    }

    public function getAllCount(): int
    {
        return Nurse::count();
    }
}
