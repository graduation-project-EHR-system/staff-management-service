<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Specialization>
 */
class SpecializationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'Cardiology',
                'Pediatrics',
                'Neurology',
                'Orthopedics',
                'Dermatology',
                'Oncology',
                'Psychiatry',
                'General Practice',
                'Surgery',
                'Endocrinology',
            ]),
            'description' => $this->faker->sentence(10),
        ];
    }
}
