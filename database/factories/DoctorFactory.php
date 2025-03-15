<?php

namespace Database\Factories;

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
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'password' => Hash::make('password123'),
            'specialization_id' => Specialization::factory()->create(),
            'is_active' => $this->faker->boolean(chanceOfGettingTrue: 90),
            'profile_picture_path' => $this->faker->optional()->imageUrl(200, 200, 'people'),
        ];
    }
}
