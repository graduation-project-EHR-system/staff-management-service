<?php

use App\Data\Clinic\ClinicDto;
use App\Models\Clinic;
use App\Repositories\ClinicRepository;
use App\Services\ClinicService;

beforeEach(function () {
    $this->clinicRepository = mock(ClinicRepository::class);

    $this->clinicService = new ClinicService(
        $this->clinicRepository
    );

    $this->clinic = Clinic::factory()->make([
        'id'              => 'abc123',
        'name'            => 'General Clinic',
        'description'     => 'General medicine clinic',
        'current_doctors' => 5,
        'max_doctors'     => 10,
        'is_active'       => true,
    ]);
});

afterEach(function () {
    Mockery::close();
});

test('getPaginated calls repository with correct parameters', function () {
    $perPage   = 10;
    $with      = ['doctors'];
    $filters   = ['search' => 'General'];
    $paginator = mock(\Illuminate\Contracts\Pagination\LengthAwarePaginator::class);

    $this->clinicRepository
        ->shouldReceive('getPaginated')
        ->once()
        ->with($perPage, $with, $filters)
        ->andReturn($paginator);

    $result = $this->clinicService->getPaginated($perPage, $with, $filters);

    expect($result)->toBe($paginator);
});

test('getById calls repository with correct parameters', function () {
    $id   = 'abc123';
    $with = ['doctors'];

    $this->clinicRepository
        ->shouldReceive('getById')
        ->once()
        ->with($id, $with)
        ->andReturn($this->clinic);

    $result = $this->clinicService->getById($id, $with);

    expect($result)->toBe($this->clinic);
});

test('create calls repository with correct parameters', function () {
    $clinicDto = new ClinicDto(
        name: 'New Clinic',
        description: 'A new clinic',
        currentDoctors: 0,
        maxDoctors: 20,
        isActive: true
    );

    $this->clinicRepository
        ->shouldReceive('create')
        ->once()
        ->with($clinicDto)
        ->andReturn($this->clinic);

    $result = $this->clinicService->create($clinicDto);

    expect($result)->toBe($this->clinic);
});

test('update calls repository with correct parameters', function () {
    $clinicDto = new ClinicDto(
        name: 'Updated Clinic',
        description: 'An updated clinic',
        currentDoctors: 6,
        maxDoctors: 15,
        isActive: true
    );

    $updatedClinic                  = clone $this->clinic;
    $updatedClinic->name            = 'Updated Clinic';
    $updatedClinic->description     = 'An updated clinic';
    $updatedClinic->current_doctors = 6;
    $updatedClinic->max_doctors     = 15;

    $this->clinicRepository
        ->shouldReceive('update')
        ->once()
        ->with($this->clinic, $clinicDto)
        ->andReturn($updatedClinic);

    $result = $this->clinicService->update($clinicDto, $this->clinic);

    expect($result)->toBe($updatedClinic);
});

test('delete calls repository with correct parameters', function () {
    $this->clinicRepository
        ->shouldReceive('delete')
        ->once()
        ->with($this->clinic)
        ->andReturnNull();

    $this->clinicService->delete($this->clinic);
});

test('isActive returns clinic active status', function () {
    $id = 'abc123';

    $this->clinicRepository
        ->shouldReceive('getById')
        ->once()
        ->with($id, [])
        ->andReturn($this->clinic);

    $result = $this->clinicService->isActive($id);

    expect($result)->toBe(true);

    // Test with inactive clinic
    $inactiveClinic            = clone $this->clinic;
    $inactiveClinic->is_active = false;

    $this->clinicRepository
        ->shouldReceive('getById')
        ->once()
        ->with($id, [])
        ->andReturn($inactiveClinic);

    $result = $this->clinicService->isActive($id);

    expect($result)->toBe(false);
});

test('canHoldMoreDoctors returns true when clinic has space', function () {
    $id = 'abc123';

    $this->clinicRepository
        ->shouldReceive('getById')
        ->once()
        ->with($id, [])
        ->andReturn($this->clinic); // 5 current, 10 max

    $result = $this->clinicService->canHoldMoreDoctors($id);

    expect($result)->toBe(true);
});

test('canHoldMoreDoctors returns false when clinic is full', function () {
    $id                          = 'abc123';
    $fullClinic                  = clone $this->clinic;
    $fullClinic->current_doctors = 10;
    $fullClinic->max_doctors     = 10;

    $this->clinicRepository
        ->shouldReceive('getById')
        ->once()
        ->with($id, [])
        ->andReturn($fullClinic);

    $result = $this->clinicService->canHoldMoreDoctors($id);

    expect($result)->toBe(false);
});

test('hasDoctor returns true when clinic has the doctor', function () {
    $clinicId = 'abc123';
    $doctorId = 'doc123';

    $clinicWithDoctor = Mockery::mock(Clinic::class);
    $clinicWithDoctor->shouldReceive('hasDoctor')
        ->once()
        ->with($doctorId)
        ->andReturn(true);

    $this->clinicRepository
        ->shouldReceive('getById')
        ->once()
        ->with($clinicId, [])
        ->andReturn($clinicWithDoctor);

    $result = $this->clinicService->hasDoctor($clinicId, $doctorId);

    expect($result)->toBe(true);
});

test('hasDoctor returns false when clinic does not have the doctor', function () {
    $clinicId = 'abc123';
    $doctorId = 'doc123';

    $clinicWithoutDoctor = Mockery::mock(Clinic::class);
    $clinicWithoutDoctor->shouldReceive('hasDoctor')
        ->once()
        ->with($doctorId)
        ->andReturn(false);

    $this->clinicRepository
        ->shouldReceive('getById')
        ->once()
        ->with($clinicId, [])
        ->andReturn($clinicWithoutDoctor);

    $result = $this->clinicService->hasDoctor($clinicId, $doctorId);

    expect($result)->toBe(false);
});
