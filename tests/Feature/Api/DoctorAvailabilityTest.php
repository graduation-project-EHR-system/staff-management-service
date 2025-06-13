<?php

use App\Interfaces\EventPublisher;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\DoctorAvailability;
use App\Models\Specialization;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    $this->specialization = Specialization::factory()->create();

    $this->doctor = Doctor::factory()->create([
        'specialization_id' => $this->specialization->id,
    ]);

    $this->clinic = Clinic::factory()->create([
        'is_active' => true,
    ]);

    $this->withoutMiddleware();
});

test('can get doctor availabilities', function () {
    DoctorAvailability::factory()->count(3)->create([
        'doctor_id'  => $this->doctor->id,
        'clinic_id'  => $this->clinic->id,
        'date'       => now()->addDays(1)->format('Y-m-d'),
        'from' => '09:00',
        'to'   => '17:00',
    ]);

    $response = $this->getJson("/api/v1/doctors/{$this->doctor->id}/availabilities");

    $response->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'data' => [
                'items' => [
                    '*' => [
                        'id',
                        'date',
                        'from',
                        'to',
                        'clinic',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ],
        ]);
});

test('can create a doctor availability', function () {
    $availabilityData = [
        'clinic_id'  => $this->clinic->id,
        'date'       => now()->addDays(2)->format('Y-m-d'),
        'from' => '09:00',
        'to'   => '17:00',
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


    $response = $this->postJson("/api/v1/doctors/{$this->doctor->id}/availabilities", $availabilityData);

    $response->assertStatus(Response::HTTP_CREATED)
        ->assertJsonStructure([
            'data' => [
                'id',
                'date',
                'from',
                'to',
                'clinic',
                'created_at',
                'updated_at',
            ],
        ]);

    $this->assertDatabaseHas('doctor_availabilities', [
        'doctor_id' => $this->doctor->id,
        'clinic_id' => $availabilityData['clinic_id'],
        'date'      => $availabilityData['date'],
    ]);
});
