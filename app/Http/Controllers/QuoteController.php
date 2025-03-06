<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuoteRequest;
use App\Http\Requests\UpdateQuoteRequest;
use App\Http\Resources\QuoteListingResource;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class QuoteController extends Controller
{
	public function index(Request $request): JsonResponse
	{
		$user = Auth::user();

		$quotes = QueryBuilder::for(Quote::class)
		->with(['movie.user', 'comments.user'])
		->withCount(['likes' => fn ($query) => $query->where('active', true)])
		->with(['likes' => fn ($query) => $query->where('user_id', $user->id)])
		->allowedFilters([
			AllowedFilter::scope('quote', 'filterByQuoteText'),
			AllowedFilter::scope('movie_name', 'filterByMovieName'),
		])
		->orderBy('created_at', 'desc')
		->orderBy('id', 'desc')
		->paginate(10);

		return response()->json([
			'status'         => 'Quotes retrieved successfully!',
			'data'           => QuoteListingResource::collection($quotes),
			'has_more_pages' => $quotes->hasMorePages(),
		]);
	}

	public function show(Quote $quote): JsonResponse
	{
		$user = Auth::user();

		$quote = QueryBuilder::for(Quote::where('id', $quote->id))
		->with(['movie.user', 'comments.user'])
		->withCount(['likes' => fn ($query) => $query->where('active', true)])
		->with(['likes' => fn ($query) => $query->where('user_id', $user->id)])
		->firstOrFail();

		return response()->json([
			'status' => 'Quote retrieved successfully!',
			'data'   => new QuoteListingResource($quote),
		]);
	}

	public function store(StoreQuoteRequest $request): JsonResponse
	{
		$validated = $request->validated();

		$newQuote = Quote::create([
			'quote'    => $validated['quote'],
			'movie_id' => $validated['movie_id'],
		]);

		$newQuote->addMedia($request->file('image'))
		->toMediaCollection('images', 'public');

		return response()->json([
			'status'  => 'Data saved succesfully',
			'quote'   => $newQuote,
		]);
	}

	public function update(UpdateQuoteRequest $request, Quote $quote): JsonResponse
	{
		$validated = $request->validated();

		if ($request->hasFile('image')) {
			$quote->clearMediaCollection('images');
			$quote->addMedia($request->file('image'))
				  ->toMediaCollection('images', 'public');
		}

		$quote->update([
			'movie_id' => $validated['movie_id'],
			'quote'    => $validated['quote'],
		]);

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
