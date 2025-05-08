<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('test' , function(Request $request) {
    $clientIp = $request->ip();
    \Log::info('Client IP: ' . $clientIp);

    return "Client IP logged: " . $clientIp;
 });