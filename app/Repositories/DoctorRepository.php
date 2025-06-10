<?php
namespace App\Repositories;

use App\Data\Doctor\DoctorDto;
use App\Models\Doctor;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface DoctorRepository
{
    public function getPaginated(int $perPage = 15, array $with = [], array $filters = []): LengthAwarePaginator;
    public function getById(string $id, array $with = []): Doctor;
    public function create(DoctorDto $doctorDto): Doctor;
    public function update(Doctor $doctor, DoctorDto $doctorDto): Doctor;
    public function delete(Doctor $doctor): void;
    public function getAll(array $columns = ['*']): Collection;
    public function getAllCount(): int;
}
