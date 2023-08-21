<?php

namespace App\Http\Controllers\Thread;

use App\Http\Controllers\Controller;
use App\Models\Friend;
use Exception;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    public function followAndUnFollow($followingID){

        try{

            $checkIfFollow = Friend::whereFollowingId($followingID)->exists();

            if($checkIfFollow){
                Friend::whereFollowingId($followingID)->delete();

                return response([
                    'message' => 'UnFollowing successfully',
    
                ], 200);

            }else{
                Friend::create([
                    'following_id' => (int) $followingID,
                    'follower_id' => auth()->id()
                ]);

                return response([
                    'message' => 'Following successfully',
    
                ], 200);
            }

        } catch(Exception $e){
            return response([
                'message' => $e->getMessage(),
            ],500);
        }
    }
}
