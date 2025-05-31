<?php
namespace App\Repositories;

use App\Data\Specialization\SpecializationDto;
use App\Models\Specialization;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface SpecializationRepository
{
    public function getPaginated(int $perPage = 15, array $with = []): LengthAwarePaginator;
    public function getById(string $id, array $with = []): Specialization;
    public function create(SpecializationDto $specializationDto): Specialization;
    public function update(Specialization $specialization, SpecializationDto $specializationDto): Specialization;
    public function delete(Specialization $specialization): void;
}
