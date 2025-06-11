<?php

use App\Data\Receptionist\ReceptionistDto;
use App\Enums\KafkaTopic;
use App\Enums\UserRole;
use App\Interfaces\EventPublisher;
use App\Models\Receptionist;
use App\Repositories\ReceptionistRepository;
use App\Services\ReceptionistService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

beforeEach(function () {
    $this->eventPublisher         = mock(EventPublisher::class);
    $this->receptionistRepository = mock(ReceptionistRepository::class);

    $this->receptionistService = new ReceptionistService(
        $this->eventPublisher,
        $this->receptionistRepository
    );

    $this->receptionist = Receptionist::factory()->make([
        'id'          => 'abc123',
        'national_id' => '123456789',
        'first_name'  => 'John',
        'last_name'   => 'Doe',
        'email'       => 'john.doe@example.com',
        'phone'       => '1234567890',
        'is_active'   => true,
    ]);
});

afterEach(function () {
    Mockery::close();
});

test('getPaginated calls repository with correct parameters', function () {
    $perPage   = 10;
    $with      = ['relation'];
    $filters   = ['search' => 'John'];
    $paginator = mock(LengthAwarePaginator::class);

    $this->receptionistRepository
        ->shouldReceive('getPaginated')
        ->once()
        ->with($perPage, $with, $filters)
        ->andReturn($paginator);

    $result = $this->receptionistService->getPaginated($perPage, $with, $filters);

    expect($result)->toBe($paginator);
});

test('getById calls repository with correct parameters', function () {
    $id   = 'abc123';
    $with = ['relation'];

    $this->receptionistRepository
        ->shouldReceive('getById')
        ->once()
        ->with($id, $with)
        ->andReturn($this->receptionist);

    $result = $this->receptionistService->getById($id, $with);

    expect($result)->toBe($this->receptionist);
});

test('create calls repository and publishes event', function () {
    $receptionistDto = new ReceptionistDto(
        national_id: '123456789',
        first_name: 'John',
        last_name: 'Doe',
        email: 'john.doe@example.com',
        phone: '1234567890',
        is_active: true
    );

    $this->receptionistRepository
        ->shouldReceive('create')
        ->once()
        ->with($receptionistDto)
        ->andReturn($this->receptionist);

    $eventBody = [
        'id'         => 'abc123',
        'nationalId' => '123456789',
        'firstName'  => 'John',
        'lastName'   => 'Doe',
        'email'      => 'john.doe@example.com',
        'phone'      => '1234567890',
        'role'       => UserRole::RECEPTIONIST->name,
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

    $result = $this->receptionistService->create($receptionistDto);

    expect($result)->toBe($this->receptionist);
});

test('update calls repository and publishes event', function () {
    $receptionistDto = new ReceptionistDto(
        national_id: '123456789',
        first_name: 'John',
        last_name: 'Smith',
        email: 'john.smith@example.com',
        phone: '1234567890',
        is_active: true
    );

    $updatedReceptionist            = clone $this->receptionist;
    $updatedReceptionist->last_name = 'Smith';
    $updatedReceptionist->email     = 'john.smith@example.com';

    $this->receptionistRepository
        ->shouldReceive('update')
        ->once()
        ->with($this->receptionist, $receptionistDto)
        ->andReturn($updatedReceptionist);

    $eventBody = [
        'id'         => 'abc123',
        'nationalId' => '123456789',
        'firstName'  => 'John',
        'lastName'   => 'Smith',
        'email'      => 'john.smith@example.com',
        'phone'      => '1234567890',
        'role'       => UserRole::RECEPTIONIST->name,
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

    $result = $this->receptionistService->update($receptionistDto, $this->receptionist);

    expect($result)->toBe($updatedReceptionist);
});

test('delete calls repository and publishes event', function () {
    $this->receptionistRepository
        ->shouldReceive('delete')
        ->once()
        ->with($this->receptionist)
        ->andReturnNull();

    $eventBody = [
        'id'         => 'abc123',
        'nationalId' => '123456789',
        'firstName'  => 'John',
        'lastName'   => 'Doe',
        'email'      => 'john.doe@example.com',
        'phone'      => '1234567890',
        'role'       => UserRole::RECEPTIONIST->name,
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

    $this->receptionistService->delete($this->receptionist);
});
