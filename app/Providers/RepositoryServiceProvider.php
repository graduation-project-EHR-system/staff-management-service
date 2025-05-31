<?php
namespace App\Providers;

use App\Repositories\DoctorRepository;
use App\Repositories\EloquentDoctorRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(DoctorRepository::class, EloquentDoctorRepository::class);
    }
}
