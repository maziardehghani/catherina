<?php

namespace App\Http\Resources;

use App\Http\Resources\User\UserResource;
use App\Services\CalendarServices\CalendarService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResources extends JsonResource
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
            'user' => new UserResource($this->user),
            'user_name' => $this->userName,
            'user_avatar' => $this->userAvatar,
            'position' => $this->position,
            'order' => $this->order,
            'instagram' => $this->instagram,
            'linkedin' => $this->linkedin,
            'status_id' => $this->status_id,
            'status' => $this->statusTitle,
            'created_at' => CalendarService::getPersianDate($this->created_at),
        ];
    }
}
