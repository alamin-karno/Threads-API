<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Exception;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    public function register(RegisterRequest $registerRequest){
        try{
            $registerRequest->validated();
        }
        catch(Exception $e){
            return response([
                'message' => $e->getMessage(),
            ],500);
        }
    }
}
