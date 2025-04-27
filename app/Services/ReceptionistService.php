<?php
namespace App\Services;

use App\DTOs\ReceptionistDto;
use App\Models\Receptionist;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ReceptionistService
{
    public function getAll(array $with = []): Collection
    {
        return Receptionist::with($with)->get();
    }

    public function getPaginated(int $perPage = 15, array $with = []): LengthAwarePaginator
    {
        return Receptionist::with($with)->paginate($perPage);
    }

    public function find(string $id, array $with = [])
    {
        return Receptionist::with($with)->findOrFail($id);
    }

    public function create(ReceptionistDto $receptionistDto): Receptionist
    {
        return Receptionist::create($receptionistDto->toArray());
    }

    public function update(Receptionist $receptionist, ReceptionistDto $receptionistDto): Receptionist
    {
        $receptionist->update($receptionistDto->toArray());
        return $receptionist;
    }

    public function delete(Receptionist $receptionist)
    {
        $receptionist->delete();
    }
}
