<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class StartDuty implements ShouldBroadcast
{
    public $duty;
    public $user;
    public $chat;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($duty, $user, $chat)
    {
        $this->duty = $duty;
        $this->user = $user;
        $this->chat = $chat;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('duty');
    }
}
