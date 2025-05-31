<?php
namespace App\Services;

use App\Data\Clinic\ClinicDto;
use App\Models\Clinic;
use App\Repositories\ClinicRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ClinicService
{
    public function __construct(
        protected ClinicRepository $clinicRepository
    ) {}

    public function getPaginated(
        int $perPage = 15,
        array $with = [],
        array $filters = []
    ): LengthAwarePaginator {
        return $this->clinicRepository->getPaginated($perPage, $with, $filters);
    }

    public function getById(
        string $id,
        array $with = []
    ): Clinic {
        return $this->clinicRepository->getById($id, $with);
    }

    public function create(ClinicDto $clinicDto): Clinic
    {
        $clinic = $this->clinicRepository->create($clinicDto);

        return $clinic;
    }

    public function update(
        ClinicDto $clinicDto,
        Clinic $clinic
    ): Clinic {
        $clinic = $this->clinicRepository->update($clinic, $clinicDto);

        return $clinic;
    }

    public function delete(Clinic $clinic): void
    {
        $this->clinicRepository->delete($clinic);
    }

    public function isActive(int $clinicId): bool
    {
        return $this->getById($clinicId)->is_active;
    }

    public function canHoldMoreDoctors(int $clinicId): bool
    {
        $clinic = $this->getById($clinicId);

        return $clinic->current_doctors < $clinic->max_doctors;
    }

    public function hasDoctor(int $clinicId, int $doctorId): bool
    {
        return $this->getById($clinicId)
            ->hasDoctor($doctorId);
    }
}
