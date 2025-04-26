<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ClinicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('clinics')->insert([
            [
                'id' => (string) Str::orderedUuid(),
                'name' => 'Sunrise Medical Center',
                'description' => 'A modern facility offering comprehensive healthcare services',
                'current_doctors' => 5,
                'max_doctors' => 10,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::orderedUuid(),
                'name' => 'Hope Clinic',
                'description' => 'Specialized in family medicine and pediatrics',
                'current_doctors' => 3,
                'max_doctors' => 6,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::orderedUuid(),
                'name' => 'City Health Institute',
                'description' => 'Advanced medical care with state-of-the-art equipment',
                'current_doctors' => 8,
                'max_doctors' => 15,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::orderedUuid(),
                'name' => 'Wellness Hub',
                'description' => 'Focus on preventive care and holistic treatments',
                'current_doctors' => 4,
                'max_doctors' => 8,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::orderedUuid(),
                'name' => 'Harmony Medical',
                'description' => 'Specializing in chronic disease management',
                'current_doctors' => 6,
                'max_doctors' => 12,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::orderedUuid(),
                'name' => 'Peak Health Clinic',
                'description' => 'Sports medicine and rehabilitation center',
                'current_doctors' => 3,
                'max_doctors' => 7,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::orderedUuid(),
                'name' => 'CarePoint Facility',
                'description' => '24/7 emergency and urgent care services',
                'current_doctors' => 7,
                'max_doctors' => 10,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::orderedUuid(),
                'name' => 'Vital Signs Clinic',
                'description' => 'Routine checkups and diagnostic services',
                'current_doctors' => 2,
                'max_doctors' => 5,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::orderedUuid(),
                'name' => 'Healing Hands Center',
                'description' => 'Specialized surgical and recovery care',
                'current_doctors' => 5,
                'max_doctors' => 9,
                'is_active' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::orderedUuid(),
                'name' => 'New Horizon Clinic',
                'description' => 'Innovative treatments and clinical research',
                'current_doctors' => 4,
                'max_doctors' => 8,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]
        );
    }
}
