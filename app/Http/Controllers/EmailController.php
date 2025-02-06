<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;

class EmailController extends Controller
{
	public function confirmEmail(EmailVerificationRequest $request): JsonResponse
	{
		$request->fulfill();

		return response()->json(
			['status' => 'Email successfully verified.'],
			200
		);
	}

	public function resetPasswordView(string $token): View
	{
		return view('auth.reset-password', ['token' => $token]);
	}
}
