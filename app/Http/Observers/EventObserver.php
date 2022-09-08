<?php

namespace App\Http\Observers;

use App\Events\NewEvent;
use App\Models\Duty;
use App\Models\Event;

class EventObserver
{
    public function created(Event $event)
    {
        $duty = Duty::query()->with(['users', 'chat'])->findOrFail($event->duty_id);
        $responsible = null;

        broadcast(new NewEvent($event, $responsible, $duty));
    }
}
