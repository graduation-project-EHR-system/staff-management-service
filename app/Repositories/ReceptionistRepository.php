<?php
namespace App\Repositories;

use App\Data\Receptionist\ReceptionistDto;
use App\Models\Receptionist;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ReceptionistRepository
{
    public function getPaginated(int $perPage = 15, array $with = []): LengthAwarePaginator;
    public function getById(string $id, array $with = []): Receptionist;
    public function create(ReceptionistDto $receptionistDto): Receptionist;
    public function update(Receptionist $receptionist, ReceptionistDto $receptionistDto): Receptionist;
    public function delete(Receptionist $receptionist): void;
    public function getAllCount(): int;

}
