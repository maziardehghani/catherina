<?php

namespace App\Http\Resources;

use App\Http\Resources\Status\StatusResources;
use App\Services\CalendarServices\CalendarService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InstallmentResource extends JsonResource
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
            'user_name' => $this->userName,
            'status' => $this->statusTitle,
            'project_title' => $this->projectTitle,
            'amount' => $this->amount,
            'description' => $this->description,
            'due_date' => CalendarService::getPersianDate($this->due_date),
            'payment_date' => CalendarService::getPersianDate($this?->payment_date),
        ];
    }
}
