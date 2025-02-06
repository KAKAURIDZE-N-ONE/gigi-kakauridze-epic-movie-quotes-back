<?php

namespace App\Http\Controllers;

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
}
