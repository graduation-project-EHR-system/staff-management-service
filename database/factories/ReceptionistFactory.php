<?php
namespace Database\Factories;

use App\Models\Receptionist;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReceptionistFactory extends Factory
{
    protected $model = Receptionist::class;

    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name'  => $this->faker->lastName(),
            'national_id' => $this->faker->unique()->uuid(),
            'email'      => $this->faker->unique()->safeEmail(),
            'phone'      => $this->faker->unique()->phoneNumber(),
            'is_active'  => $this->faker->boolean(chanceOfGettingTrue: 90),
        ];
    }
}
