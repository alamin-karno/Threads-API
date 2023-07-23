<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'user_id' => $this->user_id,
            'thread_id' => $this->thread_id,
            'body' => $this->body,
            'created_at' => $this->created_at->diffForHumans(),
            'subComments' => SubCommentResource::collection($this->subComments),
        ];
    }
}
