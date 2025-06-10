<?php

use App\Models\Clinic;
use App\Models\Nurse;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    $this->clinic = Clinic::factory()->create();

    $this->withoutMiddleware();
});

test('can get paginated list of nurses', function () {
    Nurse::factory()->count(3)->create([
        'clinic_id' => $this->clinic->id,
    ]);

    $response = $this->getJson(route('nurses.index'));

    $response->assertStatus(Response::HTTP_OK)
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
                        'is_active',
                    ],
                ],
            ],
        ]);
});

test('can get a single nurse', function () {
    $nurse = Nurse::factory()->create([
        'clinic_id' => $this->clinic->id,
    ]);

    $response = $this->getJson(route('nurses.show', $nurse->id));

    $response->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'data' => [
                'id',
                'national_id',
                'first_name',
                'last_name',
                'email',
                'phone',
                'is_active',
                'clinic',
            ],
        ]);
});

test('can create a nurse', function () {
    $nurseData = [
        'national_id' => '1234567890',
        'first_name'  => 'John',
        'last_name'   => 'Doe',
        'email'       => 'john.doe@example.com',
        'phone'       => '1234567890',
        'clinic_id'   => $this->clinic->id,
        'is_active'   => true,
    ];

    $response = $this->postJson(route('nurses.store'), $nurseData);

    $response->assertStatus(Response::HTTP_CREATED)
        ->assertJsonStructure([
            'data' => [
                'id',
                'national_id',
                'first_name',
                'last_name',
                'email',
                'phone',
                'is_active',
            ],
        ]);

    $this->assertDatabaseHas('nurses', [
        'national_id' => $nurseData['national_id'],
        'email'       => $nurseData['email'],
    ]);
});

test('can update a nurse', function () {
    $nurse = Nurse::factory()->create([
        'clinic_id' => $this->clinic->id,
    ]);

    $updatedData = [
        'national_id' => '0987654321',
        'first_name'  => 'Jane',
        'last_name'   => 'Smith',
        'email'       => 'jane.smith@example.com',
        'phone'       => '0987654321',
        'clinic_id'   => $this->clinic->id,
        'is_active'   => true,
    ];

    $response = $this->putJson(route('nurses.update', $nurse->id), $updatedData);

    $response->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'data' => [
                'id',
                'national_id',
                'first_name',
                'last_name',
                'email',
                'phone',
                'is_active',
            ],
        ]);

    $this->assertDatabaseHas('nurses', [
        'id'    => $nurse->id,
        'email' => $updatedData['email'],
    ]);
});

test('can delete a nurse', function () {
    $nurse = Nurse::factory()->create([
        'clinic_id' => $this->clinic->id,
    ]);

    $response = $this->deleteJson(route('nurses.destroy', $nurse->id));

    $response->assertStatus(Response::HTTP_OK);
    $this->assertSoftDeleted('nurses', ['id' => $nurse->id]);
});

test('can filter nurses by search term', function () {
    Nurse::factory()->create([
        'first_name' => 'John',
        'last_name'  => 'Doe',
        'clinic_id'  => $this->clinic->id,
    ]);
    Nurse::factory()->create([
        'first_name' => 'Jane',
        'last_name'  => 'Smith',
        'clinic_id'  => $this->clinic->id,
    ]);

    $response = $this->getJson(route('nurses.index', ['search' => 'John']));

    $response->assertStatus(Response::HTTP_OK)
        ->assertJsonPath('data.items.0.first_name', 'John');
});
