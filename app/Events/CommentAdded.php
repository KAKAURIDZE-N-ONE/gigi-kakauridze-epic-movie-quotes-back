<?php

namespace App\Events;

use App\Http\Resources\CommentResourceWithQuote;
use App\Models\Comment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommentAdded implements ShouldBroadcast
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	public $comment;

	/**
	 * Create a new event instance.
	 */
	public function __construct(Comment $comment)
	{
		$this->comment = $comment;
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return array<int, \Illuminate\Broadcasting\Channel>
	 */
	public function broadcastOn(): array
	{
		return [
			new Channel('comments'),
		];
	}

	public function broadcastWith()
	{
		return [
			'comment' => new CommentResourceWithQuote($this->comment->load(['user', 'quote'])),
		];
	}
}
