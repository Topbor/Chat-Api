<?php

namespace App\Http\Controllers\API;

use App\Events\NewEvent;
use App\Events\UpdateEvent;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Duty;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\NewMessage;

class EventController extends Controller
{
    public function create(Request $request)
    {
        if (!$request->filled('event-description')) {
            return response()->json([
                'message' => 'No event to send'
            ], 422);
        }
        $event = new Event();
        //$event->fill($request->all());
        $event->description = $request->description;
        $event->duty_id = $request->duty_id;
        $event->user_id = null;
        $event->actual = true;
        $event->save();
        $duty = Duty::query()->with(['users', 'chat'])->findOrFail($event->duty_id);
        $responsible = null;

        // TODO: Sanitize input
        broadcast(new NewEvent($event, $responsible, $duty));

        return response()->json([ 'event' => 'Sent'], 200);
    }

    public function setResponsible($event_id, $user_id)
    {
        $event = Event::query()->with(['duty', 'duty.chat'])->findOrFail($event_id);
        $event->user_id = $user_id;
        $event->actual = true;
        $event->save();

        event(new UpdateEvent($event, $event->duty));

        return response()->json([ 'event' => 'Update'], 200);
    }


    public function createV2(Request $request)
    {
        if (!$request->filled('event-description')) {
            return response()->json([
                'message' => 'No event to send'
            ], 422);
        }
        $event = new Event();
        //$event->fill($request->all());
        $event->description = $request->description;
        $event->duty_id = $request->duty_id;
        $event->user_id = null;
        $event->save();
        $duty = Duty::query()->with(['users', 'chat'])->findOrFail($event->duty_id);
        $responsible = null;

        broadcast(new NewEvent($event, $responsible, $duty));

        return response()->json([ 'event' => 'Sent'], 200);
    }

    public function setResponsibleV2($event_id, $user_id)
    {
        $event = Event::query()->with(['duty', 'duty.chat'])->findOrFail($event_id);
        $event->user_id = $user_id;
        $event->save();

        event(new UpdateEvent($event, $event->duty));

        return response()->json([ 'event' => 'Update'], 200);
    }
}
