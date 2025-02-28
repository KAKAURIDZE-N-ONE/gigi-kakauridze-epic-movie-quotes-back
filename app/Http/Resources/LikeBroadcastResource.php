<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LikeBroadcastResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'post_id' => $this->quote_id,
			'id'      => $this->id,
			'user_id' => $this->user->id,
			'active'  => $this->active,
		];
	}
}
