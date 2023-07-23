<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Thread\ThreadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/threads',[ThreadController::class,'index']);
    Route::post('/create-thread',[ThreadController::class,'create_thread']);
    Route::post('/thread/like/{thread_id}',[ThreadController::class,'react']);
    Route::post('/thread/comment',[ThreadController::class,'comment']);
    Route::post('/thread/sub-comment',[ThreadController::class,'subComment']);
});

Route::post('/register',[AuthenticationController::class,'register']);
Route::post('/login',[AuthenticationController::class,'login']);
