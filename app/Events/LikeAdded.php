<?php

namespace App\Events;

use App\Http\Resources\LikeBroadcastResource;
use App\Models\Like;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LikeAdded implements ShouldBroadcast
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	public $like;

	/**
	 * Create a new event instance.
	 */
	public function __construct(Like $like)
	{
		$this->like = $like;
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return array<int, \Illuminate\Broadcasting\Channel>
	 */
	public function broadcastOn(): array
	{
		return [
			new Channel('likes'),
		];
	}

	public function broadcastWith()
	{
		return [
			'like' => new LikeBroadcastResource($this->like),
		];
	}
}
