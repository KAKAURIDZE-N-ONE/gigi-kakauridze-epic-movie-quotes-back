<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuoteListingResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id'    => $this->id,
			'image' => $this->getFirstMediaUrl('images'),
			'quote' => $this->quote,
			'movie' => [
				'name' => $this->movie->name,
				'year' => $this->movie->year,
				'user' => [
					'avatar' => $this->getAvatarUrl($this->movie->user),
					'name'   => $this->movie->user->name,
				],
			],
			'likes_count'       => $this->likes_count,
			'current_user_like' => new LikeResource($this->likes->first()),
			'comments'          => CommentResource::collection($this->comments),
		];
	}

	private function getAvatarUrl($user): ?string
	{
		return $user->getFirstMediaUrl('images') ?: null;
	}
}
