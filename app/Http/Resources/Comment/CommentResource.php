<?php

namespace App\Http\Resources\Comment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'user_name' => $this->user->name,
            'created_at' => format_datetime($this->created_at),
            'can_delete' => Auth::id() === $this->user_id,
            'parent_id' => $this->parent_id,
            'children' => CommentResource::collection($this->whenLoaded('children')),
        ];
    }
}
