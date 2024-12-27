<?php

namespace App\Http\Resources;

use App\Http\Resources\User\UserResource;
use App\Services\CalendarServices\CalendarService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowTransactionResource extends JsonResource
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
            'amount' => $this->amount,
            'user' => new UserResource($this->whenLoaded('user')->load(['medias','status'])),
            'status' => $this->status->title,
            'terminal_id' => $this->terminal_id,
            'trace_number' => $this->trace_number,
            'rrn' => $this->rrn,
            'secure_pan' => $this->secure_pan,
            'token' => $this->token,
            'gateWay' => $this->gateWay,
            'project' => new ProjectResource($this->whenLoaded('project')),
            'created_at' => CalendarService::getPersianDate($this->created_at, 'Y/m/d : H:i:s'),
        ];
    }
}
