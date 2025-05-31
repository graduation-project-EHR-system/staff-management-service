<?php
namespace App\Repositories;

use App\Models\Clinic;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentClinicRepository implements ClinicRepository
{
    public function getPaginated(int $perPage = 15, array $with = [], array $filters = []): LengthAwarePaginator
    {
        return Clinic::with($with)->filter($filters)->paginate($perPage);
    }

    public function getById(string $id, array $with = []): Clinic
    {
        return Clinic::with($with)->findOrFail($id);
    }

    public function create(\App\Data\Clinic\ClinicDto $clinicDto): Clinic
    {
        return Clinic::query()->create($clinicDto->toArray());
    }

    public function update(Clinic $clinic, \App\Data\Clinic\ClinicDto $clinicDto): Clinic
    {
        $clinic->update($clinicDto->toArray());
        return $clinic->fresh();
    }

    public function delete(Clinic $clinic): void
    {
        $clinic->delete();
    }
}
