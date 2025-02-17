<?php

namespace App\Http\Controllers;

use App\Http\Resources\MovieResource;
use App\Http\Resources\MoviesListingResource;
use App\Models\Movie;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
	use AuthorizesRequests;

	public function index(): JsonResponse
	{
		$user = Auth::user();
		$movies = $user->movies()->withCount('quotes')->get();

		return response()->json([
			'status' => 'Movies retrieved successfully!',
			'data'   => MoviesListingResource::collection($movies),
		]);
	}

	public function show(Movie $movie): JsonResponse
	{
		$this->authorize('view', $movie);

		$movie->load([
			'categories',
			'quotes' => fn ($query) => $query->withCount(['likes', 'comments']),
		]);

		return response()->json([
			'status' => 'Movie retrieved successfully!',
			'data'   => new MovieResource($movie),
		]);
	}
}
