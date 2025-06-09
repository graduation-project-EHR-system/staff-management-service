<?php
namespace App\Repositories;

use App\Models\Receptionist;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentReceptionistRepository implements ReceptionistRepository
{
    public function getPaginated(int $perPage = 15, array $with = []): LengthAwarePaginator
    {
        return Receptionist::with($with)->paginate($perPage);
    }

    public function getById(string $id, array $with = []): Receptionist
    {
        return Receptionist::with($with)->findOrFail($id);
    }

    public function create(\App\Data\Receptionist\ReceptionistDto $receptionistDto): Receptionist
    {
        return Receptionist::query()->create($receptionistDto->toArray());
    }

    public function update(Receptionist $receptionist, \App\Data\Receptionist\ReceptionistDto $receptionistDto): Receptionist
    {
        $receptionist->update($receptionistDto->toArray());
        return $receptionist->fresh();
    }

    public function delete(Receptionist $receptionist): void
    {
        $receptionist->delete();
    }

    public function getAllCount() : int
    {
        return Receptionist::count();
    }
}
