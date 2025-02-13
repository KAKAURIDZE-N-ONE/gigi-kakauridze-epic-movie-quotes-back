<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
			'id'           => $this->id,
			'name'         => $this->name,
			'year'         => $this->year,
			'image'        => $this->image ? Storage::url($this->image) : null,
			'categories'   => $this->categories,
		];
	}
}
