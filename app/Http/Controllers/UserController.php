<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | GET ALL USERS
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $users = User::with(['masRole', 'student', 'faculty'])->get();

        return response()->json([
            'success' => true,
            'message' => 'Users fetched successfully',
            'data' => $users
        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE NEW USER
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $user = User::create([
            'roleId' => $request->roleId,
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'phone_no' => $request->phone_no,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => $user
        ], 201);
    }

    /*
    |--------------------------------------------------------------------------
    | GET SINGLE USER
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $user = User::with(['masRole', 'student', 'faculty'])->find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'User fetched successfully',
            'data' => $user
        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE USER
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        $user->update([
            'roleId' => $request->roleId,
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'phone_no' => $request->phone_no,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
            'data' => $user
        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE USER
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully'
        ], 200);
    }
}
