<?php

namespace App\Http\Resources;

use App\Http\Resources\User\UserResource;
use App\Models\Comment;
use App\Services\CalendarServices\CalendarService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'user' => new UserResource($this->whenLoaded('user')),
            'commentable' => $this->commentable,
            'parent' => new CommentResource($this->whenLoaded('parent')),
            'content' => $this->content,
            'status' => $this->statusTitle,
            'status_id' => $this->status?->id,
            'created_at' => CalendarService::humanDate($this->created_at)
        ];
    }
}
