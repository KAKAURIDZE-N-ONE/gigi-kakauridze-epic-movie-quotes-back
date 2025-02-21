<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Movie;
use App\Models\Quote;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{
		$categories = Category::factory(10)->create();

		$movies = Movie::factory(10)->create(
			[
				'user_id' => 1,
			]
		);

		$movies2 = Movie::factory(5)->create(
			[
				'user_id' => 2,
			]
		);

		foreach ($movies as $movie) {
			$movie->categories()->attach(
				$categories->random(rand(1, 3))->pluck('id')->toArray()
			);
		}

		foreach ($movies2 as $movie) {
			$movie->categories()->attach(
				$categories->random(rand(1, 3))->pluck('id')->toArray()
			);
		}

		$quotes = Quote::factory(12)->create([
			'movie_id' => fn () => $movies->random()->id,
		]);

		$quotes2 = Quote::factory(12)->create([
			'movie_id' => fn () => $movies2->random()->id,
		]);

		foreach ($quotes2 as $quote) {
			Like::factory(rand(3, 10))->create([
				'quote_id' => $quote->id,
			]);
		}

		foreach ($quotes2 as $quote) {
			Comment::factory(rand(1, 3))->create([
				'quote_id' => $quote->id,
			]);
		}
	}
}
