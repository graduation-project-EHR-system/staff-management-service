<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Clinic>
 */
class ClinicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'            => $this->faker->company(),
            'description'     => $this->faker->sentence(),
            'current_doctors' => $this->faker->numberBetween(0, 10),
            'max_doctors'     => $this->faker->numberBetween(10, 20),
            'is_active'       => $this->faker->boolean(),
        ];
    }
}
