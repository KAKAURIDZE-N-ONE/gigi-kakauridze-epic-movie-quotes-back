<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class LikeNotification extends Notification implements ShouldQueue
{
	use Queueable;

	public $like;

	/**
	 * Create a new notification instance.
	 */
	public function __construct($like)
	{
		$this->like = $like;
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @return array<int, string>
	 */
	public function via(object $notifiable): array
	{
		return ['database', 'broadcast'];
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(object $notifiable): array
	{
		return [
			'quote_id'          => $this->like->quote->id,
			'movie_id'          => $this->like->quote->movie->id,
			'liker_name'        => $this->like->user->name,
			'liker_avatar'      => $this->like->user->getFirstMediaUrl('images'),
		];
	}

	public function toBroadcast(object $notifiable): BroadcastMessage
	{
		return new BroadcastMessage([
			'id'                => $this->id,
			'quote_id'          => $this->like->quote->id,
			'movie_id'          => $this->like->quote->movie->id,
			'liker_name'        => $this->like->user->name,
			'liker_avatar'      => $this->like->user->getFirstMediaUrl('images'),
		]);
	}
}
