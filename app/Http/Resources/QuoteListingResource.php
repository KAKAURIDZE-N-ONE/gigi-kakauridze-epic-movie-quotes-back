<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
			'image' => Storage::url($this->image),
			'quote' => $this->quote,
			'movie' => [
				'name' => $this->movie->name,
				'year' => $this->movie->year,
				'user' => [
					'avatar' => $this->getAvatarUrl($this->movie->user->avatar),
					'name'   => $this->movie->user->name,
				],
			],
			'likes_count'  => $this->likes_count,
			'comments'     => CommentResource::collection($this->comments),
		];
	}

	private function getAvatarUrl(?string $avatar): ?string
	{
		if ($avatar && strpos($avatar, 'https://') === 0) {
			return $avatar;
		}

		return $avatar ? Storage::url($avatar) : null;
	}
}
