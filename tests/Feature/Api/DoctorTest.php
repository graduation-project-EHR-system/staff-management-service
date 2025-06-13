<?php

use App\Interfaces\EventPublisher;
use App\Models\Doctor;
use App\Models\Specialization;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    $this->specialization = Specialization::factory()->create();
    $this->withoutMiddleware();
});

test('can get paginated list of doctors', function () {
    Doctor::factory()->count(3)->withAvailabilities(3)->create([
        'specialization_id' => $this->specialization->id,
    ]);

    $this->getJson(route('doctors.index'))
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'data' => [
                'items' => [
                    '*' => [
                        'id',
                        'national_id',
                        'first_name',
                        'last_name',
                        'email',
                        'phone',
                        'specialization',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ],
        ]);
});

test('can get a single doctor', function () {
    $doctor = Doctor::factory()->create([
        'specialization_id' => $this->specialization->id,
    ]);

    $this->getJson(route('doctors.show', $doctor->id))
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'data' => [
                'id',
                'national_id',
                'first_name',
                'last_name',
                'email',
                'phone',
                'specialization',
                'created_at',
                'updated_at',
            ],
        ]);
});

test('can create a doctor', function () {
    $doctorData = [
        'national_id'       => '1234567890',
        'first_name'        => 'John',
        'last_name'         => 'Doe',
        'email'             => 'john.doe@example.com',
        'phone'             => '1234567890',
        'specialization_id' => $this->specialization->id,
        'is_active'         => true,
    ];

    $this->mock(EventPublisher::class)
        ->shouldReceive('onTopic')
        ->once()
        ->andReturnSelf()
        ->shouldReceive('withBody')
        ->once()
        ->andReturnSelf()
        ->shouldReceive('publish')
        ->once();

    $this->postJson(route('doctors.store'), $doctorData)
        ->assertStatus(Response::HTTP_CREATED)
        ->assertJsonStructure([
            'data' => [
                'id',
                'national_id',
                'first_name',
                'last_name',
                'email',
                'phone',
                'specialization',
                'created_at',
                'updated_at',
            ],
        ]);

    $this->assertDatabaseHas('doctors', [
        'national_id' => $doctorData['national_id'],
        'email'       => $doctorData['email'],
    ]);
});

test('can update a doctor', function () {
    $doctor = Doctor::factory()->create([
        'specialization_id' => $this->specialization->id,
    ]);

    $updatedData = [
        'national_id'       => '0987654321',
        'first_name'        => 'Jane',
        'last_name'         => 'Smith',
        'email'             => 'jane.smith@example.com',
        'phone'             => '0987654321',
        'specialization_id' => $this->specialization->id,
        'is_active'         => true,
    ];

    $this->mock(EventPublisher::class)
        ->shouldReceive('onTopic')
        ->once()
        ->andReturnSelf()
        ->shouldReceive('withBody')
        ->once()
        ->andReturnSelf()
        ->shouldReceive('publish')
        ->once();

    $this->putJson(route('doctors.update', $doctor->id), $updatedData)
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'data' => [
                'id',
                'national_id',
                'first_name',
                'last_name',
                'email',
                'phone',
                'specialization',
                'created_at',
                'updated_at',
            ],
        ]);

    $this->assertDatabaseHas('doctors', [
        'id'    => $doctor->id,
        'email' => $updatedData['email'],
    ]);
});

test('can delete a doctor', function () {
    $doctor = Doctor::factory()->create([
        'specialization_id' => $this->specialization->id,
    ]);

    $this->mock(EventPublisher::class)
        ->shouldReceive('onTopic')
        ->once()
        ->andReturnSelf()
        ->shouldReceive('withBody')
        ->once()
        ->andReturnSelf()
        ->shouldReceive('publish')
        ->once();

    $this->deleteJson(route('doctors.destroy', $doctor->id))
        ->assertStatus(Response::HTTP_OK);

    $this->assertSoftDeleted('doctors', ['id' => $doctor->id]);
});

test('can filter doctors by search term', function () {
    Doctor::factory()->create([
        'first_name'        => 'John',
        'last_name'         => 'Doe',
        'specialization_id' => $this->specialization->id,
    ]);

    Doctor::factory()->create([
        'first_name'        => 'Jane',
        'last_name'         => 'Smith',
        'specialization_id' => $this->specialization->id,
    ]);

    $this->getJson(route('doctors.index', ['search' => 'John']))
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonPath('data.items.0.first_name', 'John');
});

test('can get doctor lookup', function () {
    Doctor::factory()->count(3)->create([
        'specialization_id' => $this->specialization->id,
    ]);

    $this->getJson(route('doctors.lookup'))
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'first_name',
                    'last_name',
                ],
            ],
        ]);
});
