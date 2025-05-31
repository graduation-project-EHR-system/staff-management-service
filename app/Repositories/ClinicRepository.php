<?php
namespace App\Repositories;

use App\Data\Clinic\ClinicDto;
use App\Models\Clinic;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ClinicRepository
{
    public function getPaginated(int $perPage = 15, array $with = [], array $filters = []): LengthAwarePaginator;
    public function getById(string $id, array $with = []): Clinic;
    public function create(ClinicDto $clinicDto): Clinic;
    public function update(Clinic $clinic, ClinicDto $clinicDto): Clinic;
    public function delete(Clinic $clinic): void;
}
