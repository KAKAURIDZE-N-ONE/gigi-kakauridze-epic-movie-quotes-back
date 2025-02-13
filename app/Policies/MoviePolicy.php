<?php

namespace App\Policies;

use App\Models\Movie;
use App\Models\User;

class MoviePolicy
{
	public function view(User $user, Movie $movie): bool
	{
		return $user->id === $movie->user_id;
	}
}
