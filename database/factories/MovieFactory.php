<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'name' => [
				'en' => fake('en_US')->name(),
				'ka' => fake('ka_GE')->name(),
			],
			'year'     => fake()->year(),
			'director' => [
				'en' => fake('en_US')->name(),
				'ka' => fake('ka_GE')->name(),
			],
			'description' => [
				'en' => fake('en_US')->text(),
				'ka' => fake('ka_GE')->realText(),
			],
			'user_id'     => User::factory(),
		];
	}
}
