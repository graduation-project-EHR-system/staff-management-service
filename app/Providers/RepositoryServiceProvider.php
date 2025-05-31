<?php
namespace App\Providers;

use App\Repositories\ClinicRepository;
use App\Repositories\DoctorAvailabilityRepository;
use App\Repositories\DoctorRepository;
use App\Repositories\EloquentClinicRepository;
use App\Repositories\EloquentDoctorAvailabilityRepository;
use App\Repositories\EloquentDoctorRepository;
use App\Repositories\EloquentNurseRepository;
use App\Repositories\EloquentReceptionistRepository;
use App\Repositories\EloquentSpecializationRepository;
use App\Repositories\NurseRepository;
use App\Repositories\ReceptionistRepository;
use App\Repositories\SpecializationRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(DoctorRepository::class, EloquentDoctorRepository::class);
        $this->app->bind(ClinicRepository::class, EloquentClinicRepository::class);
        $this->app->bind(NurseRepository::class, EloquentNurseRepository::class);
        $this->app->bind(SpecializationRepository::class, EloquentSpecializationRepository::class);
        $this->app->bind(ReceptionistRepository::class, EloquentReceptionistRepository::class);
        $this->app->bind(DoctorAvailabilityRepository::class, EloquentDoctorAvailabilityRepository::class);
    }
}
