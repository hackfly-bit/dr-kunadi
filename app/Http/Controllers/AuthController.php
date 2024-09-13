<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as UserAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $assignRole = $user->roles()->updateOrCreate([
            'role' => 'user'
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function login(Request $request){
        $loginUserData = $request->validate([
            'email'=>'required|string|email',
            'password'=>'required|min:8'
        ]);
        $user = User::where('email',$loginUserData['email'])->first();
        if(!$user || !Hash::check($loginUserData['password'],$user->password)){
            return response()->json([
                'message' => 'Invalid Credentials'
            ],401);
        }
        $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;
        return response()->json([
            'message' => 'Login Success',
            'nama' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'access_token' => $token,
        ],200);
    }
    public function logout()
    {
        UserAuth::user()->tokens()->delete();
        // error handling
        return response()->json([
            'message' => 'Logged out'
        ], 200);
        
    }
}
