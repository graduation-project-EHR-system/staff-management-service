<?php

namespace App\Services;

use App\Data\DoctorAvailability\DoctorAvailabilityDto;
use App\Exceptions\DoctorAvailability\InvalidAvailabilityException;
use App\Models\Doctor;
use App\Models\DoctorAvailability;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DoctorAvailabilityService
{
    public function __construct(
        protected readonly DoctorService $doctorService,
        protected readonly ClinicService $clinicService
    ) {}

    public function getForDoctorPaginated(
        int $doctorId,
        string $orderBy = 'asc',
        array $with = []
    ): LengthAwarePaginator {
        $doctor = $this->doctorService->getById($doctorId);

        return $doctor->availabilities()
            ->with($with)
            ->orderBy('date', $orderBy)
            ->paginate();
    }

    public function getById(
        int $availabilityId
    ): DoctorAvailability {
        return DoctorAvailability::
            with('clinic')
            ->findOrFail($availabilityId);
    }

    /**
     * @throws InvalidAvailabilityException
     */
    public function createForDoctor(
        DoctorAvailabilityDto $doctorAvailabilityDto,
        Doctor $doctor
    ): DoctorAvailability {
        try {
            $this->checkAvailabilityOverlapForDoctor($doctorAvailabilityDto, $doctor);

            throw_if(
                ! $this->clinicService->isActive($doctorAvailabilityDto->clinicId),
                InvalidAvailabilityException::dueToInactiveClinic()
            );

            throw_if(
                ! $this->clinicService->canHoldMoreDoctors($doctorAvailabilityDto->clinicId)
                && ! $this->clinicService->hasDoctor($doctorAvailabilityDto->clinicId, $doctor->id),
                InvalidAvailabilityException::dueToClinicFull()
            );

            $availability = $doctor->availabilities()->create($doctorAvailabilityDto->toArray());

            return $availability->load('clinic');
        } catch (InvalidAvailabilityException $e) {
            throw $e;
        }
    }

    /**
     * @throws InvalidAvailabilityException
     */
    protected function checkAvailabilityOverlapForDoctor(DoctorAvailabilityDto $doctorAvailabilityDto, Doctor $doctor): void
    {
        $doesDoctorHasAvailabilityAtTheSameTime = $doctor->availabilities()
            ->where([
                'clinic_id' => $doctorAvailabilityDto->clinicId,
                'date' => $doctorAvailabilityDto->date,
                'from' => $doctorAvailabilityDto->from,
                'to' => $doctorAvailabilityDto->to,
            ])
            ->exists();

        if ($doesDoctorHasAvailabilityAtTheSameTime) {
            throw InvalidAvailabilityException::dueToOverlap();
        }
    }
}
