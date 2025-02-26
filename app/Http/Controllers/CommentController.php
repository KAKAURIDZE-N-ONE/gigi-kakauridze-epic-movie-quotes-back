<?php

namespace App\Http\Controllers;

use App\Events\CommentAdded;
use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\User;
use App\Notifications\CommentNotification;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
	public function store(StoreCommentRequest $request): JsonResponse
	{
		$validated = $request->validated();

		$comment = Comment::create($validated);

		$postOwner = User::find($comment->quote->movie->user_id);

		if ($postOwner && $postOwner->id !== auth()->id()) {
			$postOwner->notify(new CommentNotification($comment));
		}

		event(new CommentAdded($comment));

		return response()->json([
			'status'  => 'Comment added successfully!',
		], 200);
	}
}
