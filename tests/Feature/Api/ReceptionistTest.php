<?php

use App\Models\Receptionist;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    $this->withoutMiddleware();
});

test('can get paginated list of receptionists', function () {
    Receptionist::factory()->count(3)->create();

    $response = $this->getJson(route('receptionists.index'));

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

test('can get a single receptionist', function () {
    $receptionist = Receptionist::factory()->create();

    $response = $this->getJson(route('receptionists.show', $receptionist->id));

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
});

test('can create a receptionist', function () {
    $receptionistData = [
        'national_id' => '1234567890',
        'first_name'  => 'John',
        'last_name'   => 'Doe',
        'email'       => 'john.doe@example.com',
        'phone'       => '1234567890',
        'is_active'   => true,
    ];

    $response = $this->postJson(route('receptionists.store'), $receptionistData);

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

    $this->assertDatabaseHas('receptionists', [
        'national_id' => $receptionistData['national_id'],
        'email'       => $receptionistData['email'],
    ]);
});

test('can update a receptionist', function () {
    $receptionist = Receptionist::factory()->create();

    $updatedData = [
        'national_id' => '0987654321',
        'first_name'  => 'Jane',
        'last_name'   => 'Smith',
        'email'       => 'jane.smith@example.com',
        'phone'       => '0987654321',
        'is_active'   => true,
    ];

    $response = $this->putJson(route('receptionists.update', $receptionist->id), $updatedData);

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

    $this->assertDatabaseHas('receptionists', [
        'id'    => $receptionist->id,
        'email' => $updatedData['email'],
    ]);
});

test('can delete a receptionist', function () {
    $receptionist = Receptionist::factory()->create();

    $response = $this->deleteJson(route('receptionists.destroy', $receptionist->id));

    $response->assertStatus(Response::HTTP_OK);
    $this->assertSoftDeleted('receptionists', ['id' => $receptionist->id]);
});

test('can filter receptionists by search term', function () {
    Receptionist::factory()->create([
        'first_name' => 'John',
        'last_name'  => 'Doe',
    ]);
    Receptionist::factory()->create([
        'first_name' => 'Jane',
        'last_name'  => 'Smith',
    ]);

    $response = $this->getJson(route('receptionists.index', ['search' => 'John']));

    $response->assertStatus(Response::HTTP_OK)
        ->assertJsonPath('data.items.0.first_name', 'John');
});
