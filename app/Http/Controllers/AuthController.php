<?php

namespace App\Http\Controllers;

use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Rejestracja użytkownika
    public function registerWithCorrectLog(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        \Illuminate\Support\Facades\Log::info('User created', [
            'user_name' => $user->name,
            'email' => $user->email]);


        return response()->json(['message' => 'User registered successfully'], 201);
    }

    public function registerWithInccorectLog(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        \Illuminate\Support\Facades\Log::info('User created', ["user" => $user]);
        return response()->json(['message' => 'User registered successfully'], 201);
    }


    // Logowanie użytkownika

    /**
     * @throws ValidationException
     */
    public function loginWithCorrectScope(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();
        $user->tokens()->delete();
        $token = $user->createToken('auth_token', ["view"], now()->addDays(3))->plainTextToken;
        return response()->json(['access_token' => $token, 'user_data' => $user]);
    }

    public function loginWithInccorectScope(Request $request) 
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();
        $user->tokens()->delete();
        $token = $user->createToken('auth_token', ["*"], now()->addDays(3))->plainTextToken;
        return response()->json(['access_token' => $token, 'user_data' => $user]);
    }

    public function loginWithoutExpiresToken(Request $request) 
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();
        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['access_token' => $token, 'user_data' => $user]);
    }

    public function loginWithExpiresToken(Request $request) 
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();
        $user->tokens()->delete();
        $token = $user->createToken('auth_token', ["*"], now()->addDays(3))->plainTextToken;
        return response()->json(['access_token' => $token, 'user_data' => $user]);
    }

    public function loginWithOneToken(Request $request) 
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();
        $user->tokens()->delete();
        $token = $user->createToken('auth_token', ["*"], now()->addDays(3))->plainTextToken;
        return response()->json(['access_token' => $token, 'user_data' => $user]);
    }

    public function loginWithManyToken(Request $request) 
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('auth_token', ["*"], now()->addDays(3))->plainTextToken;
        return response()->json(['access_token' => $token, 'user_data' => $user]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
