<?php
namespace Database\Seeders;

use App\Models\Clinic;
use App\Models\Receptionist;
use Illuminate\Database\Seeder;

class ReceptionistSeeder extends Seeder
{
    public function run(): void
    {
        Receptionist::factory()->count(20)->create();
    }
}
