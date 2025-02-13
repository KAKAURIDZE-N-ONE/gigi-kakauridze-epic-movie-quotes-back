<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		$user = parent::toArray($request);

		if ($this->avatar && strpos($this->avatar, 'https://') === 0) {
			$user['avatar'] = $this->avatar;
		} else {
			$user['avatar'] = $this->avatar ? asset('storage/' . $this->avatar) : null;
		}

		return $user;
	}
}
