<?php

use App\Http\Controllers\Specialization\SpecializationController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware(AdminMiddleware::class)
    ->withoutMiddleware(AdminMiddleware::class)
    ->group(function () {
        Route::apiResource('specializations', SpecializationController::class);
    });
