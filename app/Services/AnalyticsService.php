<?php

namespace App\Services;

use App\Data\Analytics\StaffAnalyticsDto;
use App\Repositories\DoctorRepository;
use App\Repositories\NurseRepository;
use App\Repositories\ReceptionistRepository;
use App\Repositories\SpecializationRepository;
use Illuminate\Database\Eloquent\Collection;

class AnalyticsService {

    public function __construct(
        protected DoctorRepository $doctorRepository,
        protected NurseRepository $nurseRepository,
        protected SpecializationRepository $specializationRepository,
        protected ReceptionistRepository $receptionistRepository
    )
    {
    }
    public function getStaffAnalytics() : StaffAnalyticsDto
    {
        return new StaffAnalyticsDto(
            numberOfDoctors: $this->doctorRepository->getAllCount(),
            numberOfNurses: $this->nurseRepository->getAllCount(),
            numberOfSpecializations: $this->specializationRepository->getAllCount(),
            numberOfReceptionists: $this->receptionistRepository->getAllCount()
        );
    }
}
