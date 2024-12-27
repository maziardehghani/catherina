<?php

namespace App\Http\Resources;

use App\Services\CalendarServices\CalendarService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use function Symfony\Component\Translation\t;

class TicketResource extends JsonResource
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
            'persian_category' => $this->persianCategory,
            'user_id' => $this->user_id,
            'user_avatar' => $this->userAvatar,
            'category' => $this->category,
            'user_name' => $this->userName,
            'subject' => $this->subject,
            'content' => $this->content,
            'answers' => TicketResource::collection($this->child()->orderBy('created_at')->get()),
            'status' => $this->statusTitle,
            'status_id' => $this->status_id,
            'created_at' => CalendarService::timeDiffInHuman($this->created_at)
        ];
    }
}
