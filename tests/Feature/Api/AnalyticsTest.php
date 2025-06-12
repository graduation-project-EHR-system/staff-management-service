<?php

use App\Models\Doctor;
use App\Models\Nurse;
use App\Models\Receptionist;
use App\Models\Specialization;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    $this->withoutMiddleware();
});

test('can get staff analytics', function () {
    Doctor::factory()->count(3)->create();

    Nurse::factory()->count(2)->create();
    Receptionist::factory()->count(1)->create();

    $response = $this->getJson(route('analytics'));

    $response->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'data' => [
                'num_of_doctors',
                'num_of_nurses',
                'num_of_specializations',
                'num_of_receptionists',
            ],
        ]);

    $response->assertJson([
        'data' => [
            'num_of_doctors'         => 3,
            'num_of_nurses'          => 2,
            'num_of_specializations' => 3,
            'num_of_receptionists'   => 1,
        ],
    ]);
});
