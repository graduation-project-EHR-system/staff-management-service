<?php

use App\Data\Nurse\NurseDto;
use App\Enums\KafkaTopic;
use App\Enums\UserRole;
use App\Interfaces\EventPublisher;
use App\Models\Clinic;
use App\Models\Nurse;
use App\Repositories\NurseRepository;
use App\Services\NurseService;

beforeEach(function () {
    $this->nurseRepository = mock(NurseRepository::class);
    $this->eventPublisher  = mock(EventPublisher::class);

    $this->nurseService = new NurseService(
        $this->eventPublisher,
        $this->nurseRepository
    );

    $this->clinic = Clinic::factory()->make([
        'id'   => '123',
        'name' => 'General Clinic',
    ]);

    $this->nurse = Nurse::factory()->make([
        'id'          => 'abc123',
        'national_id' => '1234567890',
        'first_name'  => 'Jane',
        'last_name'   => 'Smith',
        'email'       => 'jane.smith@example.com',
        'phone'       => '1234567890',
        'clinic_id'   => $this->clinic->id,
        'is_active'   => true,
    ]);

    $this->nurse->clinic = $this->clinic;
});

afterEach(function () {
    Mockery::close();
});

test('getPaginated calls repository with correct parameters', function () {
    $perPage   = 10;
    $with      = ['clinic'];
    $filters   = ['search' => 'Jane'];
    $paginator = mock(\Illuminate\Contracts\Pagination\LengthAwarePaginator::class);

    $this->nurseRepository
        ->shouldReceive('getPaginated')
        ->once()
        ->with($perPage, $with, $filters)
        ->andReturn($paginator);

    $result = $this->nurseService->getPaginated($perPage, $with, $filters);

    expect($result)->toBe($paginator);
});

test('getById calls repository with correct parameters', function () {
    $id   = 'abc123';
    $with = ['clinic'];

    $this->nurseRepository
        ->shouldReceive('getById')
        ->once()
        ->with($id, $with)
        ->andReturn($this->nurse);

    $result = $this->nurseService->getById($id, $with);

    expect($result)->toBe($this->nurse);
});

test('create calls repository and publishes event', function () {
    $nurseDto = new NurseDto(
        national_id: '1234567890',
        first_name: 'Jane',
        last_name: 'Smith',
        email: 'jane.smith@example.com',
        phone: '1234567890',
        clinic_id: '123',
        is_active: true
    );

    $this->nurseRepository
        ->shouldReceive('create')
        ->once()
        ->with($nurseDto)
        ->andReturn($this->nurse);

    $eventBody = [
        'id'         => $this->nurse->id,
        'nationalId' => $this->nurse->national_id,
        'firstName'  => $this->nurse->first_name,
        'lastName'   => $this->nurse->last_name,
        'email'      => $this->nurse->email,
        'phone'      => $this->nurse->phone,
        'role'       => UserRole::NURSE->name,
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

    $result = $this->nurseService->create($nurseDto);

    expect($result)->toBe($this->nurse);
});

test('update calls repository and publishes event', function () {
    $nurseDto = new NurseDto(
        national_id: '0987654321',
        first_name: 'Jane',
        last_name: 'Updated',
        email: 'jane.updated@example.com',
        phone: '0987654321',
        clinic_id: '123',
        is_active: true
    );

    $updatedNurse              = clone $this->nurse;
    $updatedNurse->last_name   = 'Updated';
    $updatedNurse->email       = 'jane.updated@example.com';
    $updatedNurse->phone       = '0987654321';
    $updatedNurse->national_id = '0987654321';

    $this->nurseRepository
        ->shouldReceive('update')
        ->once()
        ->with($this->nurse, $nurseDto)
        ->andReturn($updatedNurse);

    $eventBody = [
        'id'         => $updatedNurse->id,
        'nationalId' => $updatedNurse->national_id,
        'firstName'  => $updatedNurse->first_name,
        'lastName'   => $updatedNurse->last_name,
        'email'      => $updatedNurse->email,
        'phone'      => $updatedNurse->phone,
        'role'       => UserRole::NURSE->name,
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

    $result = $this->nurseService->update($nurseDto, $this->nurse);

    expect($result)->toBe($updatedNurse);
});

test('delete calls repository and publishes event', function () {
    $this->nurseRepository
        ->shouldReceive('delete')
        ->once()
        ->with($this->nurse)
        ->andReturnNull();

    $eventBody = [
        'id'         => $this->nurse->id,
        'nationalId' => $this->nurse->national_id,
        'firstName'  => $this->nurse->first_name,
        'lastName'   => $this->nurse->last_name,
        'email'      => $this->nurse->email,
        'phone'      => $this->nurse->phone,
        'role'       => UserRole::NURSE->name,
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

    $this->nurseService->delete($this->nurse);
});
