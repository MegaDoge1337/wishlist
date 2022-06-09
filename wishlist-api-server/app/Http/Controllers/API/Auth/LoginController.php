<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request) {

        $fields = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string'
        ]);

        try {
            $user = User::where('login', $fields['login'])->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        if(!Hash::check($fields['password'], $user->password)) {
            return response()->json([
                'message' => 'Incorrect password'
            ], 400);
        }

        if($user->tokens()->count() >= 1) {
            $user->tokens()->delete();
        }

        $token = $user->createToken('user_token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response()->json($response, 201);

    }

    public function logout() {

        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out'
        ], 201);

    }
}
