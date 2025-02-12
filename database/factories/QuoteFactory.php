<?php

namespace Database\Factories;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quote>
 */
class QuoteFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		$imageName = Str::random(16) . '.png';
		$imageUrl = 'https://picsum.photos/200/300?random=' . Str::uuid();
		$imageContents = Http::get($imageUrl)->body();
		Storage::disk('public')->put('images/' . $imageName, $imageContents);

		return [
			'movie_id'    => Movie::factory(),
			'quote'       => json_encode([
				'en' => fake('en_US')->text(),
				'ka' => fake('ka_GE')->realText(),
			]),
			'image'       => 'images/' . $imageName,
		];
	}
}
