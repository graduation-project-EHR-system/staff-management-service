<?php

use App\Data\Analytics\StaffAnalyticsDto;
use App\Repositories\DoctorRepository;
use App\Repositories\NurseRepository;
use App\Repositories\ReceptionistRepository;
use App\Repositories\SpecializationRepository;
use App\Services\AnalyticsService;

beforeEach(function () {
    $this->doctorRepository         = mock(DoctorRepository::class);
    $this->nurseRepository          = mock(NurseRepository::class);
    $this->specializationRepository = mock(SpecializationRepository::class);
    $this->receptionistRepository   = mock(ReceptionistRepository::class);

    $this->analyticsService = new AnalyticsService(
        $this->doctorRepository,
        $this->nurseRepository,
        $this->specializationRepository,
        $this->receptionistRepository
    );
});

afterEach(function () {
    Mockery::close();
});

test('getStaffAnalytics calls repositories with correct methods and returns StaffAnalyticsDto', function () {
    $this->doctorRepository
        ->shouldReceive('getAllCount')
        ->once()
        ->andReturn(10);

    $this->nurseRepository
        ->shouldReceive('getAllCount')
        ->once()
        ->andReturn(15);

    $this->specializationRepository
        ->shouldReceive('getAllCount')
        ->once()
        ->andReturn(5);

    $this->receptionistRepository
        ->shouldReceive('getAllCount')
        ->once()
        ->andReturn(8);

    $result = $this->analyticsService->getStaffAnalytics();

    expect($result)->toBeInstanceOf(StaffAnalyticsDto::class);
    expect($result->numberOfDoctors)->toBe(10);
    expect($result->numberOfNurses)->toBe(15);
    expect($result->numberOfSpecializations)->toBe(5);
    expect($result->numberOfReceptionists)->toBe(8);
});
