<?php

namespace App\Http\Controllers;

use App\Events\LikeAdded;
use App\Events\LikeRemoved;
use App\Http\Requests\StoreLikeRequest;
use App\Http\Requests\UpdateLikeRequest;
use App\Models\Like;
use App\Models\User;
use App\Notifications\LikeNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
	public function store(StoreLikeRequest $request): JsonResponse
	{
		$validated = $request->validated();

		$like = Like::create($validated);

		$postOwner = User::find($like->quote->movie->user_id);

		if ($postOwner && $postOwner->id !== Auth::id()) {
			$postOwner->notify(new LikeNotification($like));
		}

		event(new LikeAdded($like));

		return response()->json([
			'status'  => 'Like added successfully!',
			'like'    => $like,
		], 201);
	}

	public function update(UpdateLikeRequest $request, Like $like): JsonResponse
	{
		$validated = $request->validated();
		$like->active = $validated['active'];
		$like->save();

		if ($validated['active'] === 1) {
			event(new LikeAdded($like));
		} else {
			event(new LikeRemoved($like));
		}

		return response()->json([
			'status'  => 'Like updated successfully!',
			'like'    => $validated['active'],
		], 200);

		return response()->json([
			'status'  => 'Like updated successfully!',
		], 200);
	}
}
