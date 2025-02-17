<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
			'image'          => Storage::url($this->image),
			'likes_count'    => $this->likes_count,
			'comments_count' => $this->comments_count,
		];
	}
}
