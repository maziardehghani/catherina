<?php

namespace App\Http\Resources;

use App\Models\Media;
use App\Services\CalendarServices\CalendarService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
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
            'name' => $this->name,
            'url' => $this->url,
            'mediaable_type' => $this->mediaable_type,
            'mediaable_id' => $this->mediaable_id,
            'type' => $this->type,
            'created_at' => CalendarService::getPersianDate($this->created_at, 'Y/m/d H:i'),
        ];
    }
}
