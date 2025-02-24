<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResourceWithQuote extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'comment'    => $this->comment,
			'id'         => $this->id,
			'user'       => [
				'avatar' => $this->getUserAvatar($this->user),
				'name'   => $this->user->name,
			],
			'quote'      => [
				'id'     => $this->quote->id,
			],
		];
	}

	private function getUserAvatar($user): ?string
	{
		return $user->getFirstMediaUrl('images') ?: null;
	}
}
