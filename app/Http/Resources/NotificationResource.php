<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'created_at' => $this->created_at,
            'read_at'    => $this->read_at,
            'type'       => class_basename($this->type), 
            'data'       => $this->formatNotificationData(),
        ];
    }
    private function formatNotificationData(): array
    {
        if ($this->type === 'App\Notifications\CommentNotification') {
            return [
                'quote_id'        => $this->data['quote_id'] ?? null,
                'movie_id'        => $this->data['movie_id'] ?? null,
                'comment_id'      => $this->data['comment_id'] ?? null,
                'commenter_name'  => $this->sender->name ?? null,
                'commenter_avatar'=> $this->sender->getFirstMediaUrl('images') ?? null,
            ];
        } elseif ($this->type === 'App\Notifications\LikeNotification') {
            return [
                'quote_id'     => $this->data['quote_id'] ?? null,
                'movie_id'     => $this->data['movie_id'] ?? null,
                'liker_name'   => $this->sender->name ?? null,
                'liker_avatar' => $this->sender->getFirstMediaUrl('images') ?? null,
            ];
        }

        return []; 
    }
}
