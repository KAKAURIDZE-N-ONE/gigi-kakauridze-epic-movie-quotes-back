<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/sign-up', [AuthController::class, 'signUp']);
Route::post('/log-in', [AuthController::class, 'logIn']);
Route::post('/log-out', [AuthController::class, 'logOut']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->middleware('guest');

Route::post('/reset-password', [AuthController::class, 'resetPassword'])->middleware('guest');

Route::get('/user', [UserController::class, 'getUser'])->middleware('auth:sanctum', 'verified:sanctum');

Route::view('/email/verify', 'auth.verify-email')->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [EmailController::class, 'confirmEmail'])->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/reset-password/{token}', [AuthController::class, 'resetPasswordView'])
	->middleware('guest')
	->name('password.reset');
