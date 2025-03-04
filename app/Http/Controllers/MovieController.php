<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Http\Resources\MovieResource;
use App\Http\Resources\MovieShortResource;
use App\Http\Resources\MoviesListingResource;
use App\Models\Movie;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class MovieController extends Controller
{
	use AuthorizesRequests;

	public function index(): JsonResponse
	{
		$user = Auth::user();

		$movies = QueryBuilder::for(Movie::class)
		->where('user_id', $user->id)
		->with(['media'])
		->withCount('quotes')
		->allowedFilters([
			AllowedFilter::scope('name', 'filterByName'),
		])
		->orderBy('created_at', 'desc')
		->get();

		return response()->json([
			'status' => 'Movies retrieved successfully!',
			'data'   => MoviesListingResource::collection($movies),
		]);
	}

	public function show(Movie $movie): JsonResponse
	{
		$this->authorize('view', $movie);

		$movie->load([
			'media',
			'categories',
			'quotes' => fn ($query) => $query
			->with(['media'])
			->withCount(['likes' => function ($query) {
				$query->where('active', true);
			}, 'comments'])
			->orderBy('created_at', 'desc'),
		]);

		return response()->json([
			'status' => 'Movie retrieved successfully!',
			'data'   => new MovieResource($movie),
		]);
	}

	public function showShort(Movie $movie): JsonResponse
	{
		$this->authorize('view', $movie);

		return response()->json([
			'status' => 'Movie retrieved successfully!',
			'data'   => new MovieShortResource($movie),
		]);
	}

	public function store(StoreMovieRequest $request): JsonResponse
	{
		$validated = $request->validated();

		$newMovie = Movie::create([
			'name'        => $validated['name'],
			'year'        => $validated['year'],
			'director'    => $validated['director'],
			'description' => $validated['description'],
			'user_id'     => Auth::user()->id,
		]);

		$newMovie->addMedia($request->file('image'))
		->toMediaCollection('images', 'public');

		$newMovie->categories()->attach($validated['categories']);

		return response()->json([
			'status'  => 'Data saved succesfully',
			'movie'   => $newMovie,
		]);
	}

	public function update(UpdateMovieRequest $request, Movie $movie): JsonResponse
	{
		$validatedData = $request->validated();

		if ($request->hasFile('image')) {
			$movie->clearMediaCollection('images');
			$movie->addMedia($request->file('image'))
				  ->toMediaCollection('images', 'public');
		}

		$movie->categories()->sync($validatedData['categories']);

		$movie->update($validatedData);

		return response()->json([
			'status' => 'Movie updated successfully!',
			'movie'  => $movie,
		]);
	}

	public function destroy(Movie $movie): JsonResponse
	{
		$movie->delete();

		return response()->json([
			'status' => 'Movie deleted successfully',
		]);
	}
}
