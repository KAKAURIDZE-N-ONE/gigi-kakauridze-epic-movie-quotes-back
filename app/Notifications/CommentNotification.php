<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class CommentNotification extends Notification implements ShouldQueue
{
	use Queueable;

	public $comment;

	/**
	 * Create a new notification instance.
	 */
	public function __construct(Comment $comment)
	{
		$this->comment = $comment;
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
			'comment_id'        => $this->comment->id,
			'quote_id'          => $this->comment->quote->id,
			'movie_id'          => $this->comment->quote->movie->id,
			'commenter_name'    => $this->comment->user->name,
			'commenter_avatar'  => $this->comment->user->getFirstMediaUrl('images'),
		];
	}

	public function toBroadcast(object $notifiable): BroadcastMessage
	{
		return new BroadcastMessage([
			'id'               => $this->id,
			'comment_id'       => $this->comment->id,
			'quote_id'         => $this->comment->quote->id,
			'movie_id'         => $this->comment->quote->movie->id,
			'commenter_name'   => $this->comment->user->name,
			'commenter_avatar' => $this->comment->user->getFirstMediaUrl('images'),
		]);
	}
}
