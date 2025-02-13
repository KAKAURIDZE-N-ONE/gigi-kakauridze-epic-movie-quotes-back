<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
			'image'        => Storage::url($this->image),
			'quotes_count' => $this->quotes_count,
		];
	}
}
