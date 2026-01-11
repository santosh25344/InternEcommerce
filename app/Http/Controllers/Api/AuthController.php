<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function register_user(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'nullable|string',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ]);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->save();

        $token = $user->createToken('auth_token')->plainTextToken; // Create token for user
        return response()->json([
            'status' => 'Success',
            'token' => $token,
            'message' => 'User registered successfully',
        ]);
    }

    public function login_user(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ]);
        }

        $user = User::where('email', $request->email)->first(); // Find user by email

        if(!$user || !Hash::check($request->password, $user->password)) // Check if user exists and password matches
        {
            return response()->json([
                'status' => 'Failed',
                'token' => null,
                'message' => 'Invalid login credentials',
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken; // Create token for user
        return response()->json([
            'status' => 'Success',
            'token' => $token,
            'message' => 'User logged in successfully',
        ]);
    }

    public function logout_user(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete(); // Revoke all tokens for the user

        return response()->json([
            'status' => 'Success',
            'message' => 'User logged out successfully',
        ]);
    }

    // public function logout_user() //Alternative method
    // {
    //     $user = User::find(Auth::user()->id);
    //     $user->tokens()->delete(); // Revoke all tokens for the user
    //     return response()->json([
    //         'status' => 'Success',
    //         'message' => 'User logged out successfully',
    //     ]);
    // }

    public function update_user(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique('users','email')->ignore($id)],
            'password' => 'required|string|min:8',
            'role' => 'nullable|string',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ]);
        }

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->save();

        return response()->json([
            'status' => 'Success',
            'message' => 'User updated successfully',
        ]);
    }

    public function delete_user($id)
    {
        $user = User::find($id);
        if(!$user)
        {
            return response()->json([
                'status' => 'Failed',
                'message' => 'User not found',
            ]);
        }

        $user->delete();
        return response()->json([
            'status' => 'Success',
            'message' => 'User deleted successfully',
        ]);
    }
}
