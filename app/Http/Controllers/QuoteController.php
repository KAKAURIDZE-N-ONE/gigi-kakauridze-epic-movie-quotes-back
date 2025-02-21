<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuoteRequest;
use App\Http\Requests\UpdateQuoteRequest;
use App\Http\Resources\QuoteListingResource;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;

class QuoteController extends Controller
{
	public function index(): JsonResponse
	{
		$quotes = Quote::with(['movie.user', 'comments.user'])
		->withCount('likes')
		->orderBy('created_at', 'desc')
		->paginate(10);

		return response()->json([
			'status' => 'Quotes retrieved successfully!',
			'data'   => QuoteListingResource::collection($quotes),
		]);
	}

	public function show(Quote $quote): JsonResponse
	{
		$quote->load(['movie.user', 'comments.user'])->loadCount('likes');

		return response()->json([
			'status' => 'Quote retrieved successfully!',
			'data'   => new QuoteListingResource($quote),
		]);
	}

	public function store(StoreQuoteRequest $request): JsonResponse
	{
		$validated = $request->validated();

		$imagePath = $request->file('image')->store('images', 'public');

		$newQuote = Quote::create([
			'quote'    => $validated['quote'],
			'movie_id' => $validated['movie_id'],
			'image'    => $imagePath,
		]);

		return response()->json([
			'status'  => 'Data saved succesfully',
			'quote'   => $newQuote,
		]);
	}

	public function update(UpdateQuoteRequest $request, Quote $quote): JsonResponse
	{
		$validated = $request->validated();

		if ($request->hasFile('image')) {
			$imagePath = $request->file('image')->store('images', 'public');
			$validated['image'] = $imagePath;
		}

		$quote->update($validated);

		return response()->json([
			'status' => 'Quote updated successfully!',
			'quote'  => $quote,
		]);
	}

	public function destroy(Quote $quote): JsonResponse
	{
		$quote->delete();

		return response()->json([
			'status' => 'Quote deleted successfully',
		]);
	}
}
