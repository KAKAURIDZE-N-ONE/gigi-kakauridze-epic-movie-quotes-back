<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/sanctum/csrf-cookie', function (Request $request) {
	return response()->json(['status' => 'CSRF cookie set Successfully!']);
});

Route::post('/sign-up', [AuthController::class, 'signUp']);

Route::view('/email/verify', 'auth.verify-email')->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [EmailController::class, "confirmEmail"])->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', [EmailController::class, 'sendVerificationEmail'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');
