<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('specializations')->insert([
            [
                'name' => 'Surgery',
                'description' => 'Focuses on operative procedures to treat diseases, injuries, or deformities.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cardiology',
                'description' => 'Specializes in diagnosing and treating heart and blood vessel disorders.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Neurology',
                'description' => 'Deals with disorders of the nervous system, including the brain and spinal cord.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Orthopedics',
                'description' => 'Concentrates on the musculoskeletal system, treating bones, joints, and muscles.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pediatrics',
                'description' => 'Provides medical care for infants, children, and adolescents.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Oncology',
                'description' => 'Focuses on the diagnosis and treatment of cancer.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gastroenterology',
                'description' => 'Specializes in the digestive system and its disorders.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Endocrinology',
                'description' => 'Deals with hormonal imbalances and endocrine gland disorders.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pulmonology',
                'description' => 'Focuses on diseases of the respiratory system, including lungs and airways.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Obstetrics and Gynecology',
                'description' => 'Covers pregnancy, childbirth, and female reproductive health.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Urology',
                'description' => 'Treats disorders of the urinary tract and male reproductive system.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dermatology',
                'description' => 'Specializes in skin, hair, and nail conditions.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Psychiatry',
                'description' => 'Focuses on mental health disorders and their treatment.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Emergency Medicine',
                'description' => 'Provides immediate care for acute illnesses and injuries.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Anesthesiology',
                'description' => 'Manages pain relief and sedation during surgical procedures.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
