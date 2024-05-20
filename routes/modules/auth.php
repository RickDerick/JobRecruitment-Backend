<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;


/*
|--------------------------------------------------------------------------
| AUTH Routes
|--------------------------------------------------------------------------

*/

Route::post('resend-otp', [AuthController::class, 'resendOtp']);