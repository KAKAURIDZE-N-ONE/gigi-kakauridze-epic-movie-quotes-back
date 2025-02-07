<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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

Route::middleware(['web', 'guest'])->get('/auth/google', function () {
	return Socialite::driver('google')->redirect();
})->name('google.login');

Route::middleware(['web', 'guest'])->get('/auth/google/callback', function () {
	$googleUser = Socialite::driver('google')->user();

	$user = User::updateOrCreate([
		'email' => $googleUser->email,
	], [
		'name'                 => $googleUser->name,
		'google_id'            => $googleUser->id,
		'avatar'               => $googleUser->avatar,
		'email_verified_at'    => now(),
	]);

	Auth::login($user);

	return redirect('http://127.0.0.1:3000');
});
