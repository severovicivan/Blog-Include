<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Facade\FlareClient\Http\Response;

class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'first' => 'required|string|max:255',
            'last' => 'required|string|max:255',
            'email' => 'unique:users|required|string|email',
            'password' => 'required|string|confirmed'
        ]);

        $user = new User();
        $user->first = $request->first;
        $user->last = $request->last;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        if($user->save()){
            return response()->json([
                'message' => "User created successfully!",
                'status_code' => 201
            ], 201);
        } else {
            return response()->json([
                'message' => "Some error ocurred!",
                'status_code' => 500
            ], 500);
        }
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return response()->json([
                'message' => 'Unauthorized',
                'status_code' => 401
            ], 401);
        }

        $user = $request->user();

        if($user->role == 'blogger'){
            $tokenData = $user->createToken('Personal Access Token', ['do_anything']);
        } else {
            $tokenData = $user->createToken('Personal Access Token', ['can_comment']);
        }

        $token = $tokenData->token;

        if ($request->remember_me){
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        if ($token->save()){
            return response()->json([
                'user' => $user,
                'access_token' => $tokenData->accessToken,
                'token_type' => 'Bearer',
                'token_scope' => $tokenData->token->scopes[0],
                'expires_at' => Carbon::parse($tokenData->token->expires_at)->toDateTimeString(),
                'status_code' => 200
            ], 200);
        } else {
            return response()->json([
                'message' => 'Some error occured, please try again',
                'status_code' => 500
            ], 500);
        }
    }

    public function logout(Request $request){
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Logout successful!',
            'status_code' => 200
        ], 200);
    }
}
