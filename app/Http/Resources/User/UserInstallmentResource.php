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
            'amount' => number_format($this->amount),
            'status' => $this->statusTitle,
            'description' => $this->description,
            'due_date' => CalendarService::getPersianDate($this->due_date,'Y-m-d')
        ];
    }
}
