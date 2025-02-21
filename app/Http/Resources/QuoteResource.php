<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuoteResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id'             => $this->id,
			'quote'          => $this->quote,
			'image'          => $this->getFirstMediaUrl('images'), // ✅ Fix: Load image from Spatie Media Library
			'likes_count'    => $this->likes_count,
			'comments_count' => $this->comments_count,
		];
	}
}
