<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LogInRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\SignUpRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
	public function signUp(SignUpRequest $request)
	{
		$validated = $request->validated();

		$user = User::create([
			'name'     => $validated['name'],
			'email'    => $validated['email'],
			'password' => $validated['password'],
		]);

		Auth::login($user);
		$request->session()->regenerate();

		event(new Registered($user));

		return response()->json([
			'message' => 'Please check your email for verification link.',
			'email'   => $validated['email'],
		], 200);
	}

	public function logIn(LogInRequest $request): JsonResponse
	{
		$validated = $request->validated();

		$remember = $request->has('remember') && $request->remember;

		$isEmail = filter_var($validated['emailOrName'], FILTER_VALIDATE_EMAIL);

		$credentials = [
			$isEmail ? 'email' : 'name' => $validated['emailOrName'],
			'password'                  => $validated['password'],
		];

		if (!Auth::guard('web')->attempt($credentials, $remember)) {
			return response()->json(['message' => 'Invalid credentials'], 401);
		}

		return response()->json([
			'status' => 'Login successfully.',
		], 200);
	}

	public function logOut(Request $request): JsonResponse
	{
		Auth::guard('web')->logout();

		$request->session()->invalidate();
		$request->session()->regenerateToken();

		return response()->json([
			'message' => 'Logout successful.',
		], 200);
	}

	public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
	{
		$validated = $request->validated();
		$email = $validated['email'];
	
		$user = User::where('email', $email)->first();

		if (!$user) {
			return response()->json([
				'status'  => 'error',
				'message' => 'No account found with this email.',
			], 404);
		}
		
	    if (!$user->password) {
			return response()->json([
				'status'  => 'error',
				'message' => 'Password reset is not allowed for Google accounts.',
			], 403);
		}

		Password::sendResetLink(['email' => $email]);

		return response()->json(['email' => $email]);
	}

	public function resetPassword(ResetPasswordRequest $request)
	{
		$request->validated();

		Password::reset(
			$request->only('email', 'password', 'password_confirmation', 'token'),
			function (User $user, string $password) {
				$user->forceFill([
					'password' => Hash::make($password),
				])->setRememberToken(Str::random(60));

				$user->save();

				event(new PasswordReset($user));
			}
		);

		return response()->json([
			'status' => 'Password changed successfully.',
		], 200);
	}

	public function redirectToGoogle()
	{
		$redirectUrl = Socialite::with('google')->redirect()->getTargetUrl();
		return response()->json(['url' => $redirectUrl]);
	}

	public function handleGoogleCallback()
	{
		$googleUser = Socialite::with('google')->stateless()->user();

		$user = User::where('email', $googleUser->getEmail())->first();

		if ($user && $user->password) {
			return response()->json([
				'status'  => 'error',
				'message' => 'This email is already registered with a password. Please log in normally.',
			], 403);
		} elseif ($user && !$user->password) {
			$user->update([
				'google_id'         => $googleUser->getId(),
				'email_verified_at' => now(),
			]);

			$url = $googleUser->getAvatar();
			$user
			->addMediaFromUrl($url)
			->toMediaCollection('images', 'public');
		} elseif (!$user) {
			$sanitizedName = $this->sanitizeGoogleUserName($googleUser->getName());

			$user = User::create([
				'email'               => $googleUser->getEmail(),
				'name'                => $sanitizedName,
				'google_id'           => $googleUser->getId(),
				'email_verified_at'   => now(),
			]);

			$url = $googleUser->getAvatar();
			$user
			->addMediaFromUrl($url)
			->toMediaCollection('images', 'public');
		}

		Auth::login($user);

		return response()->json(['status'=> 'Login successfully.']);
	}

	private function sanitizeGoogleUserName($name)
	{
		$name = strtolower($name);
	
		$sanitizedName = preg_replace('/[^a-z0-9]/', '', $name);
	
		return $this->makeUniqueName($sanitizedName);
	}

    private function makeUniqueName($baseName)
    {
        $name = $baseName;
        $counter = 1;

        while (User::where('name', $name)->exists()) {
            $name = $baseName . $counter;
            $counter++;
        }
        return $name;
}
}
