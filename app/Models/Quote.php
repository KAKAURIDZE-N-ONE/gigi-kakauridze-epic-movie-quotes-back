<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Quote extends Model implements HasMedia
{
	use InteractsWithMedia;

	use HasFactory;

	protected $fillable = [
		'movie_id',
		'quote',
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
