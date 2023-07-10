<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function register(RegisterRequest $registerRequest){
        try{
            $registerRequest->validated();

            $user = User::create([
                'name' => $registerRequest->name,
                'username' => $registerRequest->username,
                'email' => $registerRequest->email,
                'password' => Hash::make($registerRequest->password)
            ]);

            $token = $user->createToken('threads')->plainTextToken;

            return response([
                'user' => $user, 
                'token' => $token
            ],201);
        }
        catch(Exception $e){
            return response([
                'message' => $e->getMessage(),
            ],500);
        }
    }
}
