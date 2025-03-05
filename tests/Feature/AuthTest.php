<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

uses(RefreshDatabase::class);

test('normal registration', function () {
	Event::fake();

	$this->withHeaders([
		'referer' => env('SANCTUM_STATEFUL_DOMAINS'),
	]);

	$response = postJson(route('auth.sign-up'), [
		'name'                  => 'gigi',
		'email'                 => 'test@example.com',
		'password'              => 'password',
		'password_confirmation' => 'password',
	]);

	$response->assertStatus(200)->assertJson([
		'message' => 'Please check your email for verification link.',
		'email'   => 'test@example.com',
	]);

	$this->assertDatabaseHas('users', [
		'email' => 'test@example.com',
	]);

	$this->assertTrue(Auth::check());

	Event::assertDispatched(Registered::class);
});

test('google login redirect works', function () {
	$redirectUrl = 'https://accounts.google.com/o/oauth2/auth?client_id=your-client-id&redirect_uri=your-redirect-uri';

	Socialite::shouldReceive('with->redirect->getTargetUrl')
		->andReturn($redirectUrl);

	$response = getJson(route('auth.google'));

	$response->assertStatus(200)
		->assertJson(['url' => $redirectUrl]);
});

test('google callback login works for new user', function () {
	Event::fake();

	$googleUser = new \Laravel\Socialite\Two\User();
	$googleUser->id = 'google-id';
	$googleUser->email = 'googleuser@example.com';
	$googleUser->name = 'Google User';
	$googleUser->avatar = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS9hXH2C1GywtIKxH1ltrq6Kdy03Z-GjbXFNA&s';

	Socialite::shouldReceive('with->stateless->user')
		->andReturn($googleUser);

	$response = getJson(route('auth.google.callback'));

	$response->assertStatus(200)
		->assertJson([
			'status' => 'Login successfully.',
		]);

	$this->assertDatabaseHas('users', [
		'email' => $googleUser->email,
	]);

	$this->assertTrue(Auth::check());

	$user = User::where('email', $googleUser->email)->first();
	$this->assertNotNull($user->getFirstMediaUrl('images'));
});

test('google callback login works for existing user', function () {
	Event::fake();

	$user = User::factory()->create([
		'email'    => 'googleuser@example.com',
		'password' => bcrypt('password'),
	]);

	$googleUser = new \Laravel\Socialite\Two\User();
	$googleUser->id = 'google-id';
	$googleUser->email = 'googleuser@example.com';
	$googleUser->name = 'Google User';
	$googleUser->avatar = 'http://google-avatar.com/image.jpg';

	Socialite::shouldReceive('with->stateless->user')
		->andReturn($googleUser);

	$response = getJson(route('auth.google.callback'));

	$response->assertStatus(403)
		->assertJson([
			'status'  => 'error',
			'message' => 'This email is already registered with a password. Please log in normally.',
		]);
});
