<?php

namespace App\Http\Controllers;

use App\Http\Resources\MovieResource;
use App\Http\Resources\MoviesListingResource;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
	public function getMovies(): JsonResponse
	{
		$user = Auth::user();
		$movies = $user->movies()->withCount('quotes')->get();

		return response()->json([
			'status' => 'Movies retrieved successfully!',
			'data'   => MoviesListingResource::collection($movies),
		]);
	}

	public function getMovie(Movie $movie): JsonResponse
	{
		$user = Auth::user();

		if ($movie->user_id !== $user->id) {
			return response()->json([
				'status'  => 'Unauthorized',
				'message' => 'This movie does not belong to the authenticated user.',
			], 403);
		}

		$movie->load('categories');

		return response()->json([
			'status' => 'Movie retrieved successfully!',
			'data'   => new MovieResource($movie),
		]);
	}
}
