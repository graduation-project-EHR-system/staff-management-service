<?php
namespace App\Repositories;

use App\Models\Doctor;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class EloquentDoctorRepository implements DoctorRepository
{
    public function getPaginated(int $perPage = 15, array $with = []): LengthAwarePaginator
    {
        return Doctor::with($with)->paginate($perPage);
    }

    public function getById(string $id, array $with = []): Doctor
    {
        return Doctor::with($with)->findOrFail($id);
    }

    public function create(\App\Data\Doctor\DoctorDto $doctorDto): Doctor
    {
        return Doctor::query()->create($doctorDto->toArray());
    }

    public function update(Doctor $doctor, \App\Data\Doctor\DoctorDto $doctorDto): Doctor
    {
        $doctor->update($doctorDto->toArray());
        return $doctor->fresh();
    }

    public function delete(Doctor $doctor): void
    {
        $doctor->delete();
    }

    public function getAll(array $columns = ['*']): Collection
    {
        return Doctor::query()
            ->when($columns[0] !== '*', function ($query) use ($columns) {
                $query->select($columns);
            })
            ->get();
    }
}
