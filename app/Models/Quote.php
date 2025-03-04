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

	public function scopeFilterByQuoteText($query, $value)
	{
		return $query->whereRaw('LOWER(JSON_UNQUOTE(quote)) LIKE ?', ['%' . strtolower($value) . '%']);
	}

	public function scopeFilterByMovieName($query, $value)
	{
		return $query->whereHas('movie', function ($q) use ($value) {
			$q->whereRaw('LOWER(JSON_UNQUOTE(name)) LIKE ?', ['%' . strtolower($value) . '%']);
		});
	}
}
