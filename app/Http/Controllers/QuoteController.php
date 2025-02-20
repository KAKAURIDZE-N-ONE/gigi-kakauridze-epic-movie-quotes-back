<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuoteRequest;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;

class QuoteController extends Controller
{
	public function store(StoreQuoteRequest $request): JsonResponse
	{
		$validated = $request->validated();

		$imagePath = $request->file('image')->store('movies', 'public');

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
}
