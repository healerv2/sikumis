<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class NotificationUpdated implements ShouldBroadcast
{
    use SerializesModels;

    public $userId;
    public $title;
    public $body;

    public function __construct($userId, $title, $body)
    {
        $this->userId = $userId;
        $this->title = $title;
        $this->body = $body;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('user.' . $this->userId);
    }

    public function broadcastAs()
    {
        return 'notification.updated';
    }

    public function broadcastWith()
    {
        return [
            'title' => $this->title,
            'body'  => $this->body,
        ];
    }
}
