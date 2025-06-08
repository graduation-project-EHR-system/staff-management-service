<?php
namespace Database\Factories;

use App\Models\Clinic;
use Illuminate\Database\Eloquent\Factories\Factory;

class NurseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name'  => $this->faker->lastName(),
            'national_id' => $this->faker->unique()->uuid(),
            'email'      => $this->faker->unique()->safeEmail(),
            'phone'      => $this->faker->unique()->phoneNumber(),
            'is_active'  => $this->faker->boolean(90),
            'clinic_id'  => Clinic::factory(),
        ];
    }
}
