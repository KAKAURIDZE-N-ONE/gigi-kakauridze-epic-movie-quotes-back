<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
	Route::post('/sign-up', 'signUp');
	Route::post('/log-in', 'logIn');
	Route::post('/log-out', 'logOut');

	Route::middleware('guest')->group(function () {
		Route::post('/forgot-password', 'forgotPassword');
		Route::post('/reset-password', 'resetPassword');
		Route::get('/reset-password/{token}', 'resetPasswordView')->name('password.reset');

		Route::middleware(['web'])->group(function () {
			Route::get('/auth/google', 'redirectToGoogle')->name('google.login');
			Route::get('/auth/google/callback', 'handleGoogleCallback');
		});
	});
});

Route::get('/user', [UserController::class, 'getUser'])->middleware('auth:sanctum', 'verified:sanctum');
Route::post('/user/profile-image', [UserController::class, 'updateProfileImage'])->middleware('auth:sanctum', 'verified:sanctum');
Route::patch('/user/username', [UserController::class, 'updateUsername'])->middleware('auth:sanctum', 'verified:sanctum');
Route::patch('/user/password', [UserController::class, 'updatePassword'])->middleware('auth:sanctum', 'verified:sanctum');

Route::get('/email/verify/{id}/{hash}', [EmailController::class, 'confirmEmail'])->middleware(['auth', 'signed'])->name('verification.verify');
Route::view('/email/verify', 'auth.verify-email')->middleware('auth')->name('verification.notice');
