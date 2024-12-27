<?php

namespace App\Http\Resources;

use App\Http\Resources\User\UserResource;
use App\Services\CalendarServices\CalendarService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContractResource extends JsonResource
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
            'description' => $this->description,
            'project_title' => $this->projectTitle,
            'user_name' => $this->userName,
            'type' => $this->type,
            'persian_type' => $this->persianType,
            'document_type' => $this->document_type,
            'status' => $this->statusTitle,
            'status_id' => $this->status_id,
            'project' => new ProjectResource($this->project),
            'user' => new UserResource($this->user),
            'file' => $this->medias,
            'created_at' => CalendarService::getPersianDate($this->created_at)
        ];
    }
}
