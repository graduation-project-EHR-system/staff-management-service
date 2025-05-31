<?php
namespace App\Repositories;

use App\Data\Nurse\NurseDto;
use App\Models\Nurse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface NurseRepository
{
    public function getPaginated(int $perPage = 15, array $with = []): LengthAwarePaginator;
    public function getById(string $id, array $with = []): Nurse;
    public function create(NurseDto $nurseDto): Nurse;
    public function update(Nurse $nurse, NurseDto $nurseDto): Nurse;
    public function delete(Nurse $nurse): void;
}
