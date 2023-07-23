<?php

namespace App\Http\Controllers\Thread;

use App\Http\Controllers\Controller;
use App\Http\Requests\ThreadRequest;
use App\Http\Resources\ThreadResource;
use App\Models\Comment;
use App\Models\Like;
use App\Models\SubComment;
use App\Models\Thread;
use Exception;
use Illuminate\Http\Request;

class ThreadController extends Controller
{


    public function index(){
        try{
            $threads = Thread::with('user')->with('likes')->with('comments')->latest()->get();
            $threads = ThreadResource::collection($threads);
            return response([
                'threads' => $threads,
            ]);
        }
        catch(Exception $e){
            return response([
                    'message' => $e->getMessage(),
                ],500);
        }
    }


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

    public function react($thread_id){
        try{
            $thread = Like::whereThreadId($thread_id)->whereUserId(auth()->id())->first();

            if($thread){
                Like::whereThreadId($thread_id)->whereUserId(auth()->id())->delete();

                return response([
                    'message' => 'UnLiked Thread',
                ],200);

            }else{
                Like::create([
                    'user_id' => auth()->id(),
                    'thread_id' => $thread_id,
                ]);

                return response([
                    'message' => 'Liked Thread',
                ],201);
            }
        }
        catch(Exception $e){
            return response([
                'message' => $e->getMessage(),
            ],500);
        }
    }


    public function comment(Request $request){
        trY{

            $request -> validate([
                'thread_id' => 'required',
                'body' => 'required|string',
            ]);

            $comment = Comment::create([
                'user_id' => auth()->id(),
                'thread_id' => $request->thread_id,
                'body' => $request->body,
            ]);


            if($comment){
                return response([
                    'message' => 'Successfully Comment',
                ],201);
            }else{
                return response([
                    'message' => 'Error Comment',
                ],500);
            }
        }
        catch(Exception $e){
            return response([
                'message' => $e->getMessage(),
            ],500);
        }
    }

    public function subComment(Request $request){
        trY{

            $request -> validate([
                'comment_id' => 'required',
                'body' => 'required|string',
            ]);

            $comment = SubComment::create([
                'user_id' => auth()->id(),
                'comment_id' => $request->comment_id,
                'body' => $request->body,
            ]);


            if($comment){
                return response([
                    'message' => 'Successfully Comment',
                ],201);
            }else{
                return response([
                    'message' => 'Error Comment',
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
