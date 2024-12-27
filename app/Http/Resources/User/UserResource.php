<?php

namespace App\Http\Resources\User;

use App\Services\CalendarServices\CalendarService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */


    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'family' => $this->getFamily(),
            'email' => $this->geteMail(),
            'mobile' => $this->getMobile(),
            'created_at' => CalendarService::getPersianDate($this->getCreatedAt(), 'Y-m-d H:i:s')
        ];

    }
}
