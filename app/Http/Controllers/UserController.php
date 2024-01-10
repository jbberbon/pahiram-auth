<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        return response([
            'status' => true,
            'data' => new UserCollection($users),
            'method' => "GET"
        ], 200);
    }


    /**
     * Display the specified user.
     */
    public function show($apc_id)
    {
        try {
            // Use findOrFail to explicitly throw an exception 
            // if the user is not found
            // $user = User::findOrFail($apc_id);
            $user = User::where('apc_id', $apc_id)->firstOrFail();

            return response([
                'status' => true,
                'data' => new UserResource($user),
                'method' => 'GET',
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response([
                'status' => false,
                'message' => 'User not found',
                'method' => 'GET',
            ], 404);
        }
    }

    /**
     * Search user.
     */
    public function search($name)
    {
        // try {
        //     $users = User::where('first_name', 'like', '%' . $name . '%')
        //         ->orWhere('last_name', 'like', '%' . $name . '%')
        //         ->get();

        //     return response([
        //         'status' => true,
        //         'data' => new UserCollection($users),
        //         'method' => 'GET',
        //     ], 200);
        // } catch (ModelNotFoundException $e) {
        //     return response([
        //         'status' => false,
        //         'message' => 'Failed to search for user.',
        //         'method' => 'GET',
        //     ], 404);
        // }
        try {
            // Get the ID of the current user (assuming you have access to it)
            $currentUserId = auth()->id();  // You may need to adjust this depending on your authentication setup

            $users = User::where(function ($query) use ($name) {
                $query->where('first_name', 'like', '%' . $name . '%')
                    ->orWhere('last_name', 'like', '%' . $name . '%');
            })
                ->whereNotIn('id', [$currentUserId]) // Exclude the current user
                ->get();

            return response([
                'status' => true,
                'data' => new UserCollection($users),
                'method' => 'GET',
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response([
                'status' => false,
                'message' => 'Failed to search for user.',
                'method' => 'GET',
            ], 404);
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($userId)
    {
        try {
            // Find resource first before deleting
            $user = User::findOrFail($userId);
            $user->delete();

            return response([
                'status' => true,
                'user' => $user,
                'message' => 'User successfully deleted',
                'method' => 'DELETE',
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response([
                'status' => false,
                'message' => 'User not found',
                'method' => 'DELETE',
            ], 404);
        }
    }
}
