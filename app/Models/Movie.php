<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Movie extends Model implements HasMedia
{
	use InteractsWithMedia;

	use HasFactory;

	protected $fillable = [
		'name',
		'year',
		'director',
		'description',
		'user_id',
	];

	protected $casts = [
		'name'        => 'array',
		'director'    => 'array',
		'description' => 'array',
	];

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	public function categories(): BelongsToMany
	{
		return $this->belongsToMany(Category::class);
	}

	public function quotes(): HasMany
	{
		return $this->hasMany(Quote::class);
	}

	public function scopeFilterByName($query, $filterValue)
	{
		return $query->whereRaw('LOWER(JSON_UNQUOTE(name)) LIKE ?', ["%{$filterValue}%"]);
	}
}
