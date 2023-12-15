<?php

namespace App\Http\Controllers;


use App\Models\Course;
use App\Models\User;
use App\Utils\CalculateTokenExpiration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

// Validators
use App\Http\Requests\RegisterAccountRequest;
use App\Http\Requests\LoginRequest;



class AuthController extends Controller
{
    /**
     * Register method
     */
    public function register(RegisterAccountRequest $request)
    {
        $validatedData = $request->validated();

        // Hash Password
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Create a new user with the validated data
        $user = User::create($validatedData);

        // Return a success response with the newly created user
        return response([
            'status' => true,
            'message' => 'User created successfully',
            'data' => $user,
            'method' => 'POST'
        ], 200);

    }

    /**
     * Login method
     */
    public function login(LoginRequest $request)
    {
        $validatedData = $request->validated();

        // Get user data
        $user = User::where('email', $request['email'])->first();
        $course = $user->course;

        // Check password
        if (!Hash::check($request['password'], $user->password)) {
            return response([
                'status' => false,
                'message' => 'Wrong password',
                'method' => 'POST',
            ], 401);
        }

        // Determine Token expiration (rememberMe)
        $expiration = CalculateTokenExpiration::calculateExpiration($validatedData['remember_me']);

        // Generate token w/ the calculated expiration time
        $token = $user->createToken('Pahiram-Token', ['*'], $expiration)->plainTextToken;

        // Build Custom Token return data
        $token_data = [
            'access_token' => $token,
            'expires_at' => $expiration->toDateTimeString(),
        ];

        // Remove Course data from $user
        unset($user['course']);
        $response = [
            'status' => true,
            'data' => [
                'user' => $user,
                'course' => $course,
                'apcis_token' => $token_data,
            ],
            'method' => 'POST',
        ];
        return response($response, 200);
    }

    /**
     * Logout current session.
     */
    public function logout(User $user)
    {
        $user->currentAccessToken()->delete();

        return response([
            'status' => true,
            'message' => 'Logged out',
            'method' => 'DELETE'
        ], 200);
    }

    /**
     * Logout all devices
     */
    public function logoutAllDevices()
    {
        $user = Auth::user();
        $user->tokens()->delete();

        return response([
            'status' => true,
            'message' => 'Logged out for all devices',
            'method' => 'DELETE'
        ], 200);

    }
}
