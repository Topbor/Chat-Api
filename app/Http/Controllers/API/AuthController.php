<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Notifications\SendPushNotification;
use http\Client\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request, User $user)
    {
        if (!Auth::attempt($request->only('phone', 'password')))
        {
            return response()
                ->json(['message' => 'Unauthenticated.'], 401);
        }

        $auth = $user->where('phone', $request->phone)->firstOrFail();
        $auth->load(['duty', 'duty.chat']);
        $token = $auth->createToken('auth_token')->plainTextToken;

        return response()
            ->json([
                'name' => $auth->name,
                'phone' => $auth->phone,
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $auth,
                'csrf_token' => csrf_token(),
            ], 200);
    }

    public function confirm(Request $request, User $user) {

        return response()
            ->json([
                'error' => 'not found',
            ], 404);
    }

    public function forgotPassword() {
        return response()
            ->json([
                'error' => 'not found',
            ], 404);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()
            ->json([
                'message' => 'You have successfully logged out and the token was successfully deleted'
            ]);
    }

    public function user_with_duty(Request $request) {
        $user = $request->user();
        $user->load(['duty', 'duty.chat']);
        return $user;
    }

    public function updateToken(Request $request) {
        try{
            $request->user()->update(['fcm_token'=>$request->token]);
            return response()->json([
                'success'=>true
            ]);
        }catch(\Exception $e){
            report($e);
            return response()->json([
                'success'=>false
            ],500);
        }
    }

}
