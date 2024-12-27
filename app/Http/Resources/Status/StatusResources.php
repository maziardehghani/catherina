<?php

namespace App\Http\Resources\Status;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StatusResources extends JsonResource
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
            'persian_title'=>  Status::$persianStatuses[$this->title],
            'title' => $this->title
        ];
    }
}
