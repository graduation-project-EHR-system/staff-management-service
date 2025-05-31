<?php
namespace App\Services;

use App\Data\Specialization\SpecializationDto;
use App\Models\Specialization;
use App\Repositories\SpecializationRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SpecializationService
{
    public function __construct(
        protected SpecializationRepository $specializationRepository
    ) {}

    public function getPaginated(
        int $perPage = 15,
        array $with = []
    ): LengthAwarePaginator {
        return $this->specializationRepository->getPaginated($perPage, $with);
    }

    public function getById(
        string $id,
        array $with = []
    ): Specialization {
        return $this->specializationRepository->getById($id, $with);
    }

    public function create(SpecializationDto $specializationDto): Specialization
    {
        $specialization = $this->specializationRepository->create($specializationDto);

        return $specialization;
    }

    public function update(
        SpecializationDto $specializationDto,
        Specialization $specialization
    ): Specialization {
        $specialization = $this->specializationRepository->update($specialization, $specializationDto);

        return $specialization;
    }

    public function delete(Specialization $specialization): void
    {
        $this->specializationRepository->delete($specialization);
    }
}
