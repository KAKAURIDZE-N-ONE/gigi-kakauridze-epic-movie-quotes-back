<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MoviesListingResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id'           => $this->id,
			'name'         => $this->name,
			'year'         => $this->year,
			'director'     => $this->director,
			'image'        => $this->getFirstMediaUrl('images'),
			'quotes_count' => $this->quotes_count,
		];
	}
}
