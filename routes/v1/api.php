<?php

use App\Http\Controllers\api\v1\Clinic\ClinicController;
use App\Http\Controllers\api\v1\Doctor\Availabilities\DoctorAvailabilityController;
use App\Http\Controllers\api\v1\Doctor\DoctorController;
use App\Http\Controllers\Api\v1\GetAnalyticsController;
use App\Http\Controllers\api\v1\Nurse\NurseController;
use App\Http\Controllers\api\v1\Specialization\SpecializationController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware([AuthMiddleware::class, AdminMiddleware::class])
    ->group(function () {
        Route::apiResource('specializations', SpecializationController::class);
        Route::apiResource('clinics', ClinicController::class);

        Route::apiResource('doctors', DoctorController::class);
        Route::get('lookup/doctors', [DoctorController::class, 'lookup'])->name('doctors.lookup');
        Route::apiResource('doctors/{doctor}/availabilities', DoctorAvailabilityController::class)
            ->only(['index', 'show', 'store']);

        Route::apiResource('nurses', NurseController::class);
        Route::apiResource('receptionists', \App\Http\Controllers\api\v1\Receptionist\ReceptionistController::class);

        Route::get('analytics' , GetAnalyticsController::class)->name('analytics');
    });
