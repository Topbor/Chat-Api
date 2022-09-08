<?php

namespace App\Events;


use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UpdateEvent implements ShouldBroadcast
{
    public $event;
    public $duty;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($event, $duty)
    {
        $this->event = $event;
        $this->duty = $duty;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('event');
    }
}
