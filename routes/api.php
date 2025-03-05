<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
	Route::middleware([SetLocale::class])->post('/sign-up', 'signUp')->name('auth.sign-up');
	Route::post('/log-in', 'logIn')->name('auth.log-in');
	Route::post('/log-out', 'logOut');

	Route::middleware('guest')->group(function () {
		Route::post('/forgot-password', 'forgotPassword');
		Route::post('/reset-password', 'resetPassword');
		Route::get('/reset-password/{token}', 'resetPasswordView')->name('password.reset');

		Route::get('/auth/google', 'redirectToGoogle')->name('auth.google');
		Route::get('/auth/google/callback', 'handleGoogleCallback')->name('auth.google.callback');
	});
});

Route::middleware(['auth:sanctum', 'verified:sanctum', SetLocale::class])
	->prefix('user')
	->controller(UserController::class)
	->group(function () {
		Route::get('/', 'getUser');
		Route::post('/profile-image', 'updateProfileImage');
		Route::patch('/username', 'updateUsername');
		Route::patch('/password', 'updatePassword');
	});

Route::middleware(['auth:sanctum', 'verified:sanctum'])
	->prefix('movies')
	->controller(MovieController::class)
	->group(function () {
		Route::get('/', 'index');
		Route::get('/{movie}', 'show');
		Route::get('/{movie}/short', 'showShort');
		Route::post('/', 'store');
		Route::delete('/{movie}', 'destroy');
		Route::patch('/{movie}', 'update');
	});

Route::middleware(['auth:sanctum', 'verified:sanctum'])
->prefix('quotes')
->controller(QuoteController::class)
->group(function () {
	Route::get('/', 'index');
	Route::get('/{quote}', 'show');
	Route::post('/', 'store');
	Route::delete('/{quote}', 'destroy');
	Route::patch('/{quote}', 'update');
});

Route::middleware(['auth:sanctum', 'verified:sanctum'])
->prefix('comments')
->controller(CommentController::class)
->group(function () {
	Route::post('/', 'store')->name('create.comment');
});

Route::middleware(['auth:sanctum', 'verified:sanctum'])
->prefix('likes')
->controller(LikeController::class)
->group(function () {
	Route::post('/', 'store')->name('like.quote');
	Route::patch('/{like}', 'update');
});

Route::middleware(['auth:sanctum', 'verified:sanctum'])
->prefix('categories')
->controller(CategoryController::class)
->group(function () {
	Route::get('/', 'index');
});

Route::middleware(['auth:sanctum', 'verified:sanctum'])
->prefix('notifications')
->controller(NotificationController::class)
->group(function () {
	Route::get('/', 'notifications')->name('notifications');
	Route::post('/mark-all-as-read', 'markAllNotificationsAsRead');
	Route::post('/mark-as-read/{id}', 'markNotificationAsRead');
});

Route::get('/email/verify/{id}/{hash}', [EmailController::class, 'confirmEmail'])->middleware(['auth', 'signed'])->name('verification.verify');
Route::view('/email/verify', 'auth.verify-email')->middleware('auth')->name('verification.notice');
