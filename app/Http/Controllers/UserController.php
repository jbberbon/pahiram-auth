<?php

namespace App\Http\Controllers;

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
            'data' => $users,
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
                'data' => $user,
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
