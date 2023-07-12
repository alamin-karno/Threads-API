<?php

namespace App\Http\Controllers\Thread;

use App\Http\Controllers\Controller;
use App\Http\Requests\ThreadRequest;
use Exception;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function create_thread(ThreadRequest $threadRequest){

        try{
            $threadRequest->validated();

            $data = [
                'body' => $threadRequest->body,
            ];

            if($threadRequest->hasFile(('image'))){
                $threadRequest->validate([
                    'image' => 'image'
                ]);

                $image_path = 'public/images/threads';

                $image = $threadRequest->file('image');
                $image_name = $image->getClientOriginalName();
                $final_path = $threadRequest->file('image')->storeAs($image_path,rand(0,0).$image_name);

                $data['image'] = $final_path;
            }

            $save = auth()->user()->threads()->create($data);

            if($save){
                return response([
                    'message' => 'Successfully created thread',
                ],201);
            }
            else{
                return response([
                    'message' => 'Error creating thread',
                ],500);
            }
        }
        catch(Exception $e){
            return response([
                    'message' => $e->getMessage(),
                ],500);
        }
    }
}
