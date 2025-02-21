<?php

namespace Database\Factories;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;

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
		return [
			'movie_id'    => Movie::factory(),
			'quote'       => [
				'en' => fake('en_US')->text(),
				'ka' => fake('ka_GE')->realText(),
			],
		];
	}
}
