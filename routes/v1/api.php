<?php

use App\Http\Controllers\api\v1\Clinic\ClinicController;
use App\Http\Controllers\api\v1\Doctor\DoctorController;
use App\Http\Controllers\api\v1\Specialization\SpecializationController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware([AuthMiddleware::class, AdminMiddleware::class])
    ->group(function () {
        Route::apiResource('specializations', SpecializationController::class);
        Route::apiResource('clinics', ClinicController::class);
        Route::apiResource('doctors', DoctorController::class);
    });
