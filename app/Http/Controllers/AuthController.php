<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        $user = User::create($request->validated());

        return response()->json([
            'message' => 'User Created Successfully',
            'data' => $user,
        ]);
    }

    public function login(LoginRequest $request)
    {
        $cardinals = $request->validated();

        $user = User::where('email', $cardinals['email'])->first();

        if(!$user || !Hash::check($cardinals['password'], $user->password)){
            return response()->json([
                'message' => 'Invalid Credentials'
            ],401);
        }

        $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;

        return response()->json([
            'message' => 'Login Success',
            'access_token' => $token,
            'data' => $user,
        ]);
    }

    public function logout()
    {
        // delete all user tokens (logout from all devices)
        auth()->user()->tokens()->delete();

        return response()->json([
          "message"=>"logged out"
        ]);
    }
}
