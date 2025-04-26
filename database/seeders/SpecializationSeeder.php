<?php

namespace Database\Seeders;

use App\Enums\SpecializationColor;
use App\Models\Specialization;
use DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('specializations')->insert([
            [
                'id' => (string) Str::orderedUuid(),
                'name' => 'Surgery',
                'description' => 'Focuses on operative procedures to treat diseases, injuries, or deformities.',
                'color' => SpecializationColor::GREEN,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::orderedUuid(),
                'name' => 'Cardiology',
                'description' => 'Specializes in diagnosing and treating heart and blood vessel disorders.',
                'color' => SpecializationColor::YELLOW,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::orderedUuid(),
                'name' => 'Neurology',
                'description' => 'Deals with disorders of the nervous system, including the brain and spinal cord.',
                'color' => SpecializationColor::SKY,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::orderedUuid(),
                'name' => 'Orthopedics',
                'description' => 'Concentrates on the musculoskeletal system, treating bones, joints, and muscles.',
                'color' => SpecializationColor::YELLOW,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::orderedUuid(),
                'name' => 'Pediatrics',
                'description' => 'Provides medical care for infants, children, and adolescents.',
                'color' => SpecializationColor::PURPLE,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::orderedUuid(),
                'name' => 'Oncology',
                'description' => 'Focuses on the diagnosis and treatment of cancer.',
                'color' => SpecializationColor::SKY,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::orderedUuid(),
                'name' => 'Gastroenterology',
                'description' => 'Specializes in the digestive system and its disorders.',
                'color' => SpecializationColor::PURPLE,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::orderedUuid(),
                'name' => 'Endocrinology',
                'description' => 'Deals with hormonal imbalances and endocrine gland disorders.',
                'color' => SpecializationColor::YELLOW,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::orderedUuid(),
                'name' => 'Pulmonology',
                'description' => 'Focuses on diseases of the respiratory system, including lungs and airways.',
                'color' => SpecializationColor::PURPLE,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::orderedUuid(),
                'name' => 'Obstetrics and Gynecology',
                'description' => 'Covers pregnancy, childbirth, and female reproductive health.',
                'color' => SpecializationColor::GREEN,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::orderedUuid(),
                'name' => 'Urology',
                'description' => 'Treats disorders of the urinary tract and male reproductive system.',
                'color' => SpecializationColor::SKY,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::orderedUuid(),
                'name' => 'Dermatology',
                'description' => 'Specializes in skin, hair, and nail conditions.',
                'color' => SpecializationColor::PURPLE,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::orderedUuid(),
                'name' => 'Psychiatry',
                'description' => 'Focuses on mental health disorders and their treatment.',
                'color' => SpecializationColor::SKY,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::orderedUuid(),
                'name' => 'Emergency Medicine',
                'description' => 'Provides immediate care for acute illnesses and injuries.',
                'color' => SpecializationColor::GREEN,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::orderedUuid(),
                'name' => 'Anesthesiology',
                'description' => 'Manages pain relief and sedation during surgical procedures.',
                'color' => SpecializationColor::SKY,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
