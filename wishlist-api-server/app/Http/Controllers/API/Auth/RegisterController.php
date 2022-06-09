<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(Request $request) {

        $fields = $request->validate([
            'login' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|string|unique:users',
            'password' => 'required|string'
        ]);

        $user = User::create([
            'login' => $fields['login'],
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => \Hash::make($fields['password']),
        ]);

        $token = $user->createToken('apptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response()->json($response, 201);

    }
}
