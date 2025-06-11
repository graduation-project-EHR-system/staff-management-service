<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\DoctorAvailability;
use App\Models\Specialization;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'national_id' => $this->faker->unique()->uuid(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'specialization_id' => Specialization::factory()->create()->id,
            'is_active' => $this->faker->boolean(chanceOfGettingTrue: 90),
        ];
    }

    public function withAvailabilities(int $count = 3): self
    {
        return $this->afterCreating(function (Doctor $doctor) use ($count) {
            DoctorAvailability::factory()->count($count)->create([
                'doctor_id' => $doctor->id,
            ]);
        });
    }
}
