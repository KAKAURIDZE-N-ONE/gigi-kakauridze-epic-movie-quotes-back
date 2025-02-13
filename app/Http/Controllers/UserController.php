<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UpdateProfileImageRequest;
use App\Http\Requests\UpdateUsernameRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
	public function getUser(): JsonResponse
	{
		$user = Auth::user();

		return response()->json(new UserResource($user));
	}

	public function updateUsername(UpdateUsernameRequest $request): JsonResponse
	{
		$validated = $request->validated();
		$user = Auth::user();

		$user->name = $validated['name'];
		$user->save();

		return response()->json(['status' => 'Username updated succsessfully']);
	}

	public function updatePassword(ChangePasswordRequest $request)
	{
		$user = Auth::user();

		$user->password = Hash::make($request->password);
		$user->save();

		return response()->json(['status' => 'Password updated successfully.'], 200);
	}

	public function updateProfileImage(UpdateProfileImageRequest $request)
	{
		$user = Auth::user();

		if ($request->hasFile('avatar')) {
			$file = $request->file('avatar');
			$path = $file->store('avatars', 'public');

			if ($user->avatar) {
				Storage::disk('public')->delete($user->avatar);
			}

			$user->avatar = $path;
			$user->save();

			return response()->json([
				'status'     => 'Avatar updated successfully',
				'avatar_url' => asset('storage/' . $path),
			]);
		}

		return response()->json(['error' => 'No file uploaded'], 400);
	}
}
