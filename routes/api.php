<?php

use App\Http\Controllers\Specialization\SpecializationController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware([AuthMiddleware::class, AdminMiddleware::class])
    ->group(function () {
        Route::apiResource('v1/specializations', SpecializationController::class);
    });
