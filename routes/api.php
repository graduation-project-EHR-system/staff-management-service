<?php

use App\Http\Controllers\Specialization\SpecializationController;
use Illuminate\Support\Facades\Route;

Route::apiResource('specializations', SpecializationController::class);
