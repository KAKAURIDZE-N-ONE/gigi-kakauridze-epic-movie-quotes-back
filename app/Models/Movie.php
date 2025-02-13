<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Movie extends Model
{
	use HasFactory;

	protected $fillable = [
		'name',
		'year',
		'director',
		'description',
		'image',
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
}
