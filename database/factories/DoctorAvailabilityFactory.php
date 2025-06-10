<?php

namespace Database\Factories;

use App\Models\Clinic;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DoctorAvailability>
 */
class DoctorAvailabilityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'clinic_id' => Clinic::factory(),
            'doctor_id' => Doctor::factory(),
            'date' => $this->faker->date(),
            'from' => $this->faker->time('H:i'),
            'to' => $this->faker->time('H:i'),
        ];
    }
}
