<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quote extends Model
{
	use HasFactory;

	protected $fillable = [
		'movie_id',
		'quote',
		'image',
	];

	protected $casts = [
		'quote'        => 'array',
	];

	public function movie(): BelongsTo
	{
		return $this->belongsTo(Movie::class);
	}

	public function likes(): HasMany
	{
		return $this->hasMany(Like::class);
	}

	public function comments(): HasMany
	{
		return $this->hasMany(Comment::class);
	}
}
