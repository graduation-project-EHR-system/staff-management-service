<?php

use App\Data\Doctor\DoctorDto;
use App\Enums\KafkaTopic;
use App\Enums\UserRole;
use App\Interfaces\EventPublisher;
use App\Models\Doctor;
use App\Models\Specialization;
use App\Repositories\DoctorRepository;
use App\Services\DoctorService;

beforeEach(function () {
    $this->doctorRepository = mock(DoctorRepository::class);
    $this->eventPublisher   = mock(EventPublisher::class);

    $this->doctorService = new DoctorService(
        $this->eventPublisher,
        $this->doctorRepository
    );

    $this->specialization = Specialization::factory()->make([
        'id'   => '123',
        'name' => 'Cardiology',
    ]);

    $this->doctor = Doctor::factory()->make([
        'id'                => 'abc123',
        'national_id'       => '1234567890',
        'first_name'        => 'John',
        'last_name'         => 'Doe',
        'email'             => 'john.doe@example.com',
        'phone'             => '1234567890',
        'specialization_id' => $this->specialization->id,
        'is_active'         => true,
    ]);

    $this->doctor->specialization = $this->specialization;
});

afterEach(function () {
    Mockery::close();
});

test('getPaginated calls repository with correct parameters', function () {
    $perPage   = 10;
    $with      = ['specialization'];
    $filters   = ['search' => 'John'];
    $paginator = mock(\Illuminate\Contracts\Pagination\LengthAwarePaginator::class);

    $this->doctorRepository
        ->shouldReceive('getPaginated')
        ->once()
        ->with($perPage, $with, $filters)
        ->andReturn($paginator);

    $result = $this->doctorService->getPaginated($perPage, $with, $filters);

    expect($result)->toBe($paginator);
});

test('getById calls repository with correct parameters', function () {
    $id   = 'abc123';
    $with = ['specialization', 'availabilities'];

    $this->doctorRepository
        ->shouldReceive('getById')
        ->once()
        ->with($id, $with)
        ->andReturn($this->doctor);

    $result = $this->doctorService->getById($id, $with);

    expect($result)->toBe($this->doctor);
});

test('create calls repository and publishes event', function () {
    $doctorDto = new DoctorDto(
        nationalId: '1234567890',
        firstName: 'John',
        lastName: 'Doe',
        email: 'john.doe@example.com',
        phone: '1234567890',
        specializationId: '123',
        isActive: true
    );

    $this->doctorRepository
        ->shouldReceive('create')
        ->once()
        ->with($doctorDto)
        ->andReturn($this->doctor);

    $eventBody = [
        'id'             => $this->doctor->id,
        'nationalId'     => $this->doctor->national_id,
        'firstName'      => $this->doctor->first_name,
        'lastName'       => $this->doctor->last_name,
        'email'          => $this->doctor->email,
        'phone'          => $this->doctor->phone,
        'role'           => UserRole::DOCTOR->name,
        'specialization' => $this->doctor->specialization->name,
    ];

    $this->eventPublisher
        ->shouldReceive('onTopic')
        ->once()
        ->with(KafkaTopic::USER_CREATED)
        ->andReturnSelf();

    $this->eventPublisher
        ->shouldReceive('withBody')
        ->once()
        ->with($eventBody)
        ->andReturnSelf();

    $this->eventPublisher
        ->shouldReceive('publish')
        ->once()
        ->andReturnNull();

    $result = $this->doctorService->create($doctorDto);

    expect($result)->toBe($this->doctor);
});

test('update calls repository and publishes event', function () {
    $doctorDto = new DoctorDto(
        nationalId: '0987654321',
        firstName: 'John',
        lastName: 'Updated',
        email: 'john.updated@example.com',
        phone: '0987654321',
        specializationId: '123',
        isActive: true
    );

    $updatedDoctor              = clone $this->doctor;
    $updatedDoctor->last_name   = 'Updated';
    $updatedDoctor->email       = 'john.updated@example.com';
    $updatedDoctor->phone       = '0987654321';
    $updatedDoctor->national_id = '0987654321';

    $this->doctorRepository
        ->shouldReceive('update')
        ->once()
        ->with($this->doctor, $doctorDto)
        ->andReturn($updatedDoctor);

    $eventBody = [
        'id'             => $updatedDoctor->id,
        'nationalId'     => $updatedDoctor->national_id,
        'firstName'      => $updatedDoctor->first_name,
        'lastName'       => $updatedDoctor->last_name,
        'email'          => $updatedDoctor->email,
        'phone'          => $updatedDoctor->phone,
        'role'           => UserRole::DOCTOR->name,
        'specialization' => $updatedDoctor->specialization->name,
    ];

    $this->eventPublisher
        ->shouldReceive('onTopic')
        ->once()
        ->with(KafkaTopic::USER_UPDATED)
        ->andReturnSelf();

    $this->eventPublisher
        ->shouldReceive('withBody')
        ->once()
        ->with($eventBody)
        ->andReturnSelf();

    $this->eventPublisher
        ->shouldReceive('publish')
        ->once()
        ->andReturnNull();

    $result = $this->doctorService->update($doctorDto, $this->doctor);

    expect($result)->toBe($updatedDoctor);
});

test('delete calls repository and publishes event', function () {
    $this->doctorRepository
        ->shouldReceive('delete')
        ->once()
        ->with($this->doctor)
        ->andReturnNull();

    $eventBody = [
        'id'             => $this->doctor->id,
        'nationalId'     => $this->doctor->national_id,
        'firstName'      => $this->doctor->first_name,
        'lastName'       => $this->doctor->last_name,
        'email'          => $this->doctor->email,
        'phone'          => $this->doctor->phone,
        'role'           => UserRole::DOCTOR->name,
        'specialization' => $this->doctor->specialization->name,
    ];

    $this->eventPublisher
        ->shouldReceive('onTopic')
        ->once()
        ->with(KafkaTopic::USER_DELETED)
        ->andReturnSelf();

    $this->eventPublisher
        ->shouldReceive('withBody')
        ->once()
        ->with($eventBody)
        ->andReturnSelf();

    $this->eventPublisher
        ->shouldReceive('publish')
        ->once()
        ->andReturnNull();

    $this->doctorService->delete($this->doctor);
});

test('getLookup calls repository with correct parameters', function () {
    $doctors = new \Illuminate\Database\Eloquent\Collection([
        Doctor::factory()->make(['id' => '1', 'first_name' => 'John', 'last_name' => 'Doe']),
        Doctor::factory()->make(['id' => '2', 'first_name' => 'Jane', 'last_name' => 'Smith']),
    ]);

    $this->doctorRepository
        ->shouldReceive('getAll')
        ->once()
        ->with(['id', 'first_name', 'last_name'])
        ->andReturn($doctors);

    $result = $this->doctorService->getLookup();

    expect($result)->toBe($doctors);
});
