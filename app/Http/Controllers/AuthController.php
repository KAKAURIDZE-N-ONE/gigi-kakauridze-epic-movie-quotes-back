<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignUpRequest;
use App\Models\User;
use App\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Auth;

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

		Auth::user();
		Auth::login($user);
		$request->session()->regenerate();

		$user->notify(new VerifyEmail($user));

		return response()->json([
			'message' => 'Please check your email for verification link.',
		], 200);
	}
}
