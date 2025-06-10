<?php

use App\Enums\SpecializationColor;
use App\Models\Specialization;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    $this->withoutMiddleware();
});

test('can get paginated list of specializations', function () {
    Specialization::factory()->count(3)->create();

    $response = $this->getJson(route('specializations.index'));

    $response->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'data' => [
                'items' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'color',
                        'createdAt',
                        'updatedAt',
                    ],
                ],
            ],
        ]);
});

test('can get a single specialization', function () {
    $specialization = Specialization::factory()->create();

    $response = $this->getJson(route('specializations.show', $specialization->id));

    $response->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'description',
                'color',
                'createdAt',
                'updatedAt',
            ],
        ]);
});

test('can create a specialization', function () {
    $specializationData = [
        'name'        => 'Cardiology',
        'description' => 'Heart specialists',
        'color'       => SpecializationColor::GREEN->value,
    ];

    $response = $this->postJson(route('specializations.store'), $specializationData);

    $response->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'description',
                'color',
                'createdAt',
                'updatedAt',
            ],
        ]);

    $this->assertDatabaseHas('specializations', [
        'name'        => $specializationData['name'],
        'description' => $specializationData['description'],
        'color'       => $specializationData['color'],
    ]);
});

test('can update a specialization', function () {
    $specialization = Specialization::factory()->create();

    $updatedData = [
        'name'        => 'Updated Specialization',
        'description' => 'Updated description',
        'color'       => SpecializationColor::PURPLE->value,
    ];

    $response = $this->putJson(route('specializations.update', $specialization->id), $updatedData);

    $response->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'description',
                'color',
                'createdAt',
                'updatedAt',
            ],
        ]);

    $this->assertDatabaseHas('specializations', [
        'id'          => $specialization->id,
        'name'        => $updatedData['name'],
        'description' => $updatedData['description'],
        'color'       => $updatedData['color'],
    ]);
});

test('can delete a specialization', function () {
    $specialization = Specialization::factory()->create();

    $response = $this->deleteJson(route('specializations.destroy', $specialization->id));

    $response->assertStatus(Response::HTTP_OK);

    $this->assertSoftDeleted('specializations', ['id' => $specialization->id]);
});
