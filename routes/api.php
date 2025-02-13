<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\MovieController;
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

		Route::get('/auth/google', 'redirectToGoogle')->name('google.login');
		Route::get('/auth/google/callback', 'handleGoogleCallback');
	});
});

Route::middleware(['auth:sanctum', 'verified:sanctum'])
	->prefix('movies')
	->controller(MovieController::class)
	->group(function () {
		Route::get('/', 'getMovies');
		Route::get('/{movie}', 'getMovie');
	});

Route::middleware(['auth:sanctum', 'verified:sanctum'])
	->prefix('user')
	->controller(UserController::class)
	->group(function () {
		Route::get('/', 'getUser');
		Route::post('/profile-image', 'updateProfileImage');
		Route::patch('/username', 'updateUsername');
		Route::patch('/password', 'updatePassword');
	});

Route::get('/email/verify/{id}/{hash}', [EmailController::class, 'confirmEmail'])->middleware(['auth', 'signed'])->name('verification.verify');
Route::view('/email/verify', 'auth.verify-email')->middleware('auth')->name('verification.notice');
