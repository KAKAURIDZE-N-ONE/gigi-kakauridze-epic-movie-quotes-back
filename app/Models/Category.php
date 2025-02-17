<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
	use HasFactory;

	protected $fillable = [
		'name',
	];

	protected $casts = [
		'name'        => 'array',
	];

	public function movies(): BelongsToMany
	{
		return $this->belongsToMany(Movie::class);
	}
}
