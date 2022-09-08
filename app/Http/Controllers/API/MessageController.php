<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use App\Notifications\SendPushNotification;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\NewMessage;
use Illuminate\Support\Facades\Notification;
use Kutia\Larafirebase\Facades\Larafirebase;

class MessageController extends Controller
{
    public function create(Request $request)
    {
        if (!$request->filled('message')) {
            return response()->json([
                'message' => 'No message to send'
            ], 422);
        }
        $message = new Message();
        //$message->fill($request->all());
        $message->chat_id = $request->chat_id;
        $message->user_id = $request->user_id;
        $message->message = $request->message;
        $message->save();
        $chat = Chat::query()->with('messages')->findOrFail($message->chat_id);
        $author = User::findOrFail($message->user_id);

        // TODO: Sanitize input
        broadcast(new NewMessage($message, $author, $chat));

        return response()->json([ 'message' => 'Sent'], 200);
    }

    public function create_with_notification(Request $request){
        if (!$request->filled('message')) {
            return response()->json([
                'message' => 'No message to send'
            ], 422);
        }
        $message = new Message();
        //$message->fill($request->all());
        $message->chat_id = $request->chat_id;
        $message->user_id = $request->user_id;
        $message->message = $request->message;
        $message->save();
        $chat = Chat::query()->with('messages')->findOrFail($message->chat_id);
        $author = User::findOrFail($message->user_id);

        // TODO: Sanitize input
        broadcast(new NewMessage($message, $author, $chat));

        try{
            $fcmTokens = $chat->users()->where('id', '!=', $message->user_id)->whereNotNull('fcm_token')->pluck('fcm_token')->toArray();

            Notification::send(null,new SendPushNotification($chat->title,$request->message,$fcmTokens));

            Larafirebase::withTitle($request->title)
                ->withBody($request->message)
                ->sendMessage($fcmTokens);

            return redirect()->back()->with('success','Notification Sent Successfully!!');

        }catch(\Exception $e){
            report($e);
            return redirect()->back()->with('error','Something goes wrong while sending notification.');
        }
    }
}
