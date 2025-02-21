<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Movie;
use App\Models\Quote;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{
		$users = User::factory(10)->create();

		foreach ($users as $user) {
			$this->addImageToModel($user);
		}

		$categories = Category::factory(10)->create();

		$movies = Movie::factory(5)->create(
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

		$quotes = Quote::factory(3)->create([
			'movie_id' => fn () => $movies->random()->id,
		]);

		$quotes2 = Quote::factory(3)->create([
			'movie_id' => fn () => $movies2->random()->id,
		]);

		foreach ($quotes as $quote) {
			$this->addImageToModel($quote);
		}

		foreach ($quotes2 as $quote) {
			$this->addImageToModel($quote);
		}

		foreach ($quotes2 as $quote) {
			Like::factory(rand(1, 2))->create([
				'quote_id' => $quote->id,
				'user_id'  => $users->random()->id,
			]);
		}

		foreach ($quotes2 as $quote) {
			Comment::factory(rand(1, 2))->create([
				'quote_id' => $quote->id,
				'user_id'  => $users->random()->id,
			]);
		}

		foreach ($movies as $movie) {
			$this->addImageToModel($movie);
		}

		foreach ($movies2 as $movie) {
			$this->addImageToModel($movie);
		}
	}

	protected function addImageToModel($model)
	{
		$imageName = Str::random(16) . '.png';
		$imageUrl = 'https://picsum.photos/200/300?random=' . Str::uuid();
		$imageContents = Http::get($imageUrl)->body();

		Storage::disk('public')->put('images' . '/' . $imageName, $imageContents);

		$model->addMediaFromString($imageContents)
			  ->usingFileName($imageName)
			  ->toMediaCollection('images', 'public');
	}
}
