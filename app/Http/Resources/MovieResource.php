<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
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
			'name'           => $this->name,
			'year'           => $this->year,
			'image'          => $this->getFirstMediaUrl('images'), // ✅ Fix: Load image from Spatie Media Library
			'categories'     => $this->categories,
			'director'       => $this->director,
			'description'    => $this->description,
			'quotes'         => QuoteResource::collection($this->quotes),
		];
	}
}
