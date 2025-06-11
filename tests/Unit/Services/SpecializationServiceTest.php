<?php

use App\Data\Specialization\SpecializationDto;
use App\Enums\SpecializationColor;
use App\Models\Specialization;
use App\Repositories\SpecializationRepository;
use App\Services\SpecializationService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

beforeEach(function () {
    $this->specializationRepository = mock(SpecializationRepository::class);

    $this->specializationService = new SpecializationService(
        $this->specializationRepository
    );

    $this->specialization = Specialization::factory()->make([
        'id'          => 'abc123',
        'name'        => 'Cardiology',
        'description' => 'Heart related medical field',
        'color'       => SpecializationColor::GREEN,
    ]);
});

afterEach(function () {
    Mockery::close();
});

test('getPaginated calls repository with correct parameters', function () {
    $perPage   = 10;
    $with      = ['doctors'];
    $filters   = ['search' => 'Cardio'];
    $paginator = mock(LengthAwarePaginator::class);

    $this->specializationRepository
        ->shouldReceive('getPaginated')
        ->once()
        ->with($perPage, $with, $filters)
        ->andReturn($paginator);

    $result = $this->specializationService->getPaginated($perPage, $with, $filters);

    expect($result)->toBe($paginator);
});

test('getById calls repository with correct parameters', function () {
    $id   = 'abc123';
    $with = ['doctors'];

    $this->specializationRepository
        ->shouldReceive('getById')
        ->once()
        ->with($id, $with)
        ->andReturn($this->specialization);

    $result = $this->specializationService->getById($id, $with);

    expect($result)->toBe($this->specialization);
});

test('create calls repository with correct parameters', function () {
    $specializationDto = new SpecializationDto(
        name: 'Neurology',
        description: 'Brain related medical field',
        color: SpecializationColor::YELLOW
    );

    $this->specializationRepository
        ->shouldReceive('create')
        ->once()
        ->with($specializationDto)
        ->andReturn($this->specialization);

    $result = $this->specializationService->create($specializationDto);

    expect($result)->toBe($this->specialization);
});

test('update calls repository with correct parameters', function () {
    $specializationDto = new SpecializationDto(
        name: 'Updated Cardiology',
        description: 'Updated heart related medical field',
        color: SpecializationColor::PURPLE
    );

    $updatedSpecialization              = clone $this->specialization;
    $updatedSpecialization->name        = 'Updated Cardiology';
    $updatedSpecialization->description = 'Updated heart related medical field';
    $updatedSpecialization->color       = SpecializationColor::PURPLE;

    $this->specializationRepository
        ->shouldReceive('update')
        ->once()
        ->with($this->specialization, $specializationDto)
        ->andReturn($updatedSpecialization);

    $result = $this->specializationService->update($specializationDto, $this->specialization);

    expect($result)->toBe($updatedSpecialization);
});

test('delete calls repository with correct parameters', function () {
    $this->specializationRepository
        ->shouldReceive('delete')
        ->once()
        ->with($this->specialization)
        ->andReturnNull();

    $this->specializationService->delete($this->specialization);
});
