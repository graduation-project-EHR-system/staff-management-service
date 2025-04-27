<?php
namespace App\Services;

use App\DTOs\NurseDto;
use App\Models\Nurse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class NurseService
{
    public function getAll(
        array $with = []
    ): Collection {
        return Nurse::with($with)->get();
    }

    public function getPaginated(
        int $perPage = 15,
        array $with = []
    ): LengthAwarePaginator {
        return Nurse::with($with)->paginate($perPage);
    }

    public function find(string $id, array $with = []): Nurse
    {
        return Nurse::with($with)->findOrFail($id);
    }

    public function create(NurseDto $nurseDto): Nurse
    {
        return Nurse::create($nurseDto->toArray());
    }

    public function update(
        NurseDto $nurseDto,
        Nurse $nurse
    ): Nurse {
        $nurse->update($nurseDto->toArray());

        return $nurse->refresh();
    }

    public function delete(Nurse $nurse): void
    {
        $nurse->delete();
    }
}
