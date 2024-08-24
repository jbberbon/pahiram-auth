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
        try {
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
        } catch (\Exception) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong while registering your account',
                'data' => $user,
                'method' => 'POST'
            ], 500);
        }

    }

    /**
     * Login method
     */
    public function login(LoginRequest $request)
    {
        try {
            $validatedData = $request->validated();

            // Get user data
            $user = User::where('email', $request['email'])->first();
            $course = $user->course;

            // Check password
            if (!Hash::check($request['password'], $user->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Wrong credentials',
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
            return response()->json($response, 200);
        } catch (\Exception) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'method' => 'POST'
            ], 500);
        }
    }

    /**
     * Logout current session.
     */
    public function logout(User $user)
    {
        try {
            $user->currentAccessToken()->delete();

            return response()->json([
                'status' => true,
                'message' => 'Successfully logged out',
                'method' => 'DELETE'
            ], 200);
        } catch (\Exception) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'method' => 'DELETE'
            ], 500);
        }
    }

    /**
     * Logout all devices
     */
    public function logoutAllDevices()
    {
        try {
            $user = Auth::user();
            $user->tokens()->delete();

            return response()->json([
                'status' => true,
                'message' => 'Logged out for all devices',
                'method' => 'DELETE'
            ], 200);
        } catch (\Exception) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'method' => 'DELETE'
            ], 500);
        }

    }
}
