<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{
    public function getSenderIdAttribute()
    {
        return $this->data['sender_id'] ?? null;
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}