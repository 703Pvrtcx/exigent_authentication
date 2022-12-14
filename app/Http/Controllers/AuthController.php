<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $fields = $request->validate([
            'name'=> 'required|string',
            'email'=>'required|string|unique:users,email',
            'password'=> 'required|string|confirmed'
        ]);
        $user = User::create([
            'name' => $fields['name'],
            'email'=> $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);
        $token = $user->createToken('appToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response()->json($response,201);
    }
    public function login(Request $request){
        $fields = $request->validate([
            'email'=>'required|string|email',
            'password'=> 'required|string'
        ]);
        // check email
        $user = User::where('email', $fields['email'])->first();
        // Check password

        if(!$user || !Hash::check($fields['password'], $user->password)){
            return response([
                'message'=>'Invalid email/password'
            ], 401);
        }

        $token = $user->createToken('appToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];
        return response()->json($response,201);
    }
    public function user(){
        return Auth::user()->$user;
    }
    public function logout(Request $request){
        auth()->user()->tokens()->delete();
        return [
            'message'=> 'Logged out'
        ];
    }
}
