<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct(){
        request()->headers->set("Accept","application/json");
    }
    public function register(Request $request) {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'unique:users', 'email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        
        return response()->json([
            'status'=>'success',
            'massage' => 'user registered successfully',
            'data' =>[
            'user' => $user,
            'token' => $token
        ]],201,[],JSON_PRETTY_PRINT);
    } 

    public function login(Request $request) {
        $data = $request->validate([
            'email'=>['required','email','exists:users'],
            'password'=>['required','string'],
            ]);
        $user = User::where('email','=', $data['email'])->first();

        if(!$user || !Hash::check($data['password'], $user->password) ) {
            return response()->json(['massage','Invalid entry'], 401,[],JSON_PRETTY_PRINT) ;
        }
        $token = $user ->createToken('auth_token')->plainTextToken;

        
        return response()->json([
            'status'=>'success',
            'message' => 'Logged in successfully',
            'data' =>[
            'user' => $user,
            'token' => $token
        ]],200,[],JSON_PRETTY_PRINT);
    } 
}
