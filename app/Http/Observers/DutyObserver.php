<?php

namespace App\Http\Observers;

use App\Models\Duty;
use App\Models\Chat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DutyObserver
{
    public function created(Duty $duty)
    {
        $chat = new Chat();
        $chat->title = $duty->place->name . ' - ' .$duty->beginning_at->toString();
        $chat->duty_id = $duty->getKey();
        $chat->is_active = false;
        $chat->save();
    }

    public function saved(Duty $duty)
    {
        if($duty->started){
            $chat = Chat::findOrFail($duty->getKey());
            $chat->is_active = true;
            $chat->save();
        }
    }

    public function deleted(Duty $duty)
    {
        $chat = Chat::where('duty_id', $duty->getKey())->first();
        if($chat){
            $messages = $chat->messages;
            foreach ($messages as $message){
                $message->delete();
            }
            $chatRelationUser = DB::table('chat_user')->where('chat_id', $chat->getKey())->get();
            foreach ($chatRelationUser as $item){
                $item->delete();
            }
            $chat->delete();
        }

        DB::table('user_duties')->where('duty_id', $duty->id)->delete();
    }
}
