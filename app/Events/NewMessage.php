<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewMessage implements ShouldBroadcast
{
    public $message;
    public $author;
    public $chat;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message, $author, $chat)
    {
        $this->message = $message;
        $this->author = $author;
        $this->chat = $chat;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('chat.'.$this->chat->id);
    }
}
