<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::post('/biometric/capture', [BiometricController::class, 'captureFingerprint'])
    ->middleware('auth');

Route::redirect('/', '/admin/login');
