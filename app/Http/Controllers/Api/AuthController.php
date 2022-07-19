<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        // Retrieved validated user
        $validated = $request->validated();

        // Check if the email already registered
        if ($this->userExists($validated['email'])) {
            return response()->json([
                "message" => "Email already registered.",
            ]);
        }

        // Create new user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        event(new Registered($user));

        // Create token
        $token = $user->createToken('auth_token')->plainTextToken;

        // Return token
        return response()->json([
            'token_type' => 'Bearer',
            'access_token' => $token,
        ]);
    }

    public function userExists($email)
    {
        // Check if user registered
        return User::where('email', '=', $email)->count();
    }

    public function login(LoginRequest $request)
    {
        // Retreive data
        $validated = $request->validated();

        // Try login
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details',
            ], 401);
        }

        // If login success
        // Get user details
        $user = User::where('email', $validated['email'])->firstOrFail();

        // Generate token
        $token = $user->createToken('auth_token')->plainTextToken;

        // Return token
        return response()->json([
            'token_type' => 'Bearer',
            'access_token' => $token,
        ]);
    }

    public function me(Request $request)
    {
        $user = Auth::user();

        return response()->json([
            "user" => $user,
        ]);
    }
}
