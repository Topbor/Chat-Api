<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Duty;
use App\Models\UserDuty;
use Illuminate\Http\Request;
use App\Events\StartDuty;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DutyController extends Controller
{
    public function show_duties(Request $request)
    {
        $user_id = Auth::user()->id;

        $duty_id = UserDuty::query()
            ->where('user_id', $user_id)
            ->whereNotNull('duty_id')
            ->pluck('duty_id')
            ->first();

        $duty = Duty::with(['place', 'users', 'chat'])->find($duty_id);

        if($duty){
            return response($duty, 200);
        }
        return response('Error, duty not found', 400);
    }

    public function begin_duty(Request $request, $duty_id = 1)
    {
        $user = Auth::user();

        if ($duty_id == false) {
            return response('Error', 400)
                ->header('Content-Type', 'application/json');
        }

        $duty = Duty::query()
            ->with(['users', 'chat'])
            ->findOrFail($duty_id);

        if($duty){
            $duty->started = true;
            $duty->save();
            $chat = $duty->chat;
            broadcast(new StartDuty($duty, $user, $chat));
            return response('Success', 200)
                ->header('Content-Type', 'application/json');
        }

        return response('Error, duty not found', 400)
            ->header('Content-Type', 'application/json');
    }

    public function get_chat(Request $request, $id)
    {
        $chat  = Chat::where('duty_id', $id)->firstOrFail();
        $chat->load(['users', 'messages','messages.author', 'duty', 'duty.events']);
        return $chat;
    }
}
