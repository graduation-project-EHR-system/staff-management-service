<?php

use App\Models\Clinic;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    $this->withoutMiddleware();
});

test('can get paginated list of clinics', function () {
    Clinic::factory()->count(3)->create();

    $response = $this->getJson(route('clinics.index'));

    $response->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'data' => [
                'items' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'current_doctors',
                        'max_doctors',
                        'is_active',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ],
        ]);
});

test('can get a single clinic', function () {
    $clinic = Clinic::factory()->create();

    $response = $this->getJson(route('clinics.show', $clinic->id));

    $response->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'description',
                'current_doctors',
                'max_doctors',
                'is_active',
                'created_at',
                'updated_at',
            ],
        ]);
});

test('can create a clinic', function () {
    $clinicData = [
        'name'            => 'Test Clinic',
        'description'     => 'A test clinic description',
        'current_doctors' => 0,
        'max_doctors'     => 10,
        'is_active'       => true,
    ];

    $response = $this->postJson(route('clinics.store'), $clinicData);

    $response->assertStatus(Response::HTTP_CREATED)
        ->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'description',
                'current_doctors',
                'max_doctors',
                'is_active',
                'created_at',
                'updated_at',
            ],
        ]);

    $this->assertDatabaseHas('clinics', [
        'name'        => $clinicData['name'],
        'description' => $clinicData['description'],
    ]);
});

test('can update a clinic', function () {
    $clinic = Clinic::factory()->create();

    $updatedData = [
        'name'            => 'Updated Clinic',
        'description'     => 'An updated clinic description',
        'current_doctors' => 2,
        'max_doctors'     => 15,
        'is_active'       => true,
    ];

    $response = $this->putJson(route('clinics.update', $clinic->id), $updatedData);

    $response->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'description',
                'current_doctors',
                'max_doctors',
                'is_active',
                'created_at',
                'updated_at',
            ],
        ]);

    $this->assertDatabaseHas('clinics', [
        'id'          => $clinic->id,
        'name'        => $updatedData['name'],
        'description' => $updatedData['description'],
    ]);
});

test('can delete a clinic', function () {
    $clinic = Clinic::factory()->create();

    $response = $this->deleteJson(route('clinics.destroy', $clinic->id));

    $response->assertStatus(Response::HTTP_OK);
    $this->assertSoftDeleted('clinics', ['id' => $clinic->id]);
});

test('can filter clinics by search term', function () {
    Clinic::factory()->create([
        'name' => 'Cardiology Clinic',
    ]);
    Clinic::factory()->create([
        'name' => 'Dermatology Clinic',
    ]);

    $response = $this->getJson(route('clinics.index', ['search' => 'Card']));

    $response->assertStatus(Response::HTTP_OK)
        ->assertJsonPath('data.items.0.name', 'Cardiology Clinic');
});
