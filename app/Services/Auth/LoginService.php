<?php

namespace App\Services\Auth;

use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class LoginService
{

    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function login($request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $data = $this->user->where('email', $credentials['email'])->first();
        if (!$data || !Hash::check($credentials['password'], $data->password)) {
            return response()->json([
                'title' => 'Singin error',
                'message' => 'User or password incorrect!', 
                'type' => 'error',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $token = $data->createToken('auth_token');
        Log::info('The user' . $data['name'] . 'is online');
        return response()->json([
            'data' => [
                'user_key' => $data['user_key'],
                'token' => $token->plainTextToken
            ]
        ], Response::HTTP_OK);
    }
    public function logout($request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Loggout']);
    }    
    public function logoutAll($user)
    {
        $user->token()->delete();
        return response()->json(['message' => 'Loggout']);
    }

}
