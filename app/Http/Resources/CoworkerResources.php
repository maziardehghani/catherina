<?php

namespace App\Http\Resources;

use App\Services\CalendarServices\CalendarService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CoworkerResources extends JsonResource
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
            'title' => $this->title,
            'link' => $this->link,
            'status' => $this->statusTitle,
            'status_id' => $this->status_id,
            'image' => $this->mediaFile,
            'created_at' => CalendarService::getPersianDate($this->created_at)
        ];
    }
}
