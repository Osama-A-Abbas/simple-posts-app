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

    }
}
