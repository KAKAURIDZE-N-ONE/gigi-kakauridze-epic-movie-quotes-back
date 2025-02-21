<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
	public function store(StoreCommentRequest $request): JsonResponse
	{
		$validated = $request->validated();

		Comment::create($validated);

		return response()->json([
			'status'  => 'Comment added successfully!',
		], 200);
	}
}
