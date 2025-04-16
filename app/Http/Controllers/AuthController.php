<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        $validatedData = $request->validated();

        User::create([
            'name' => $validatedData->name,
            'email' => $validatedData->email,
            'password' => Hash::make($validatedData->password),
        ]);
    }

    public function login()
    {

    }
}
