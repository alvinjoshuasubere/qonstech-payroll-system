<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/biometrics/capture', function () {
    return view('CaptureImage.php');
});


Route::post('/biometrics/capture', [BiometricController::class, 'captureFingerprint']);

Route::redirect('/', '/admin/login');
