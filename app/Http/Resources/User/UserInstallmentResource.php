<?php

namespace App\Http\Resources\User;

use App\Services\CalendarServices\CalendarService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserInstallmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'amount' => number_format($this->getAmount()),
            'status' => $this->getStatus()?->getTitle(),
            'description' => $this->getDescription(),
            'due_date' => CalendarService::getPersianDate($this->getDueDate(),'Y-m-d')
        ];
    }
}
