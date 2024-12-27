<?php

namespace App\Http\Resources;

use App\Services\CalendarServices\CalendarService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
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
            'trace_code' => $this->trace_code,
            'transaction' => new TransactionResource($this->transaction),
            'national_id' => $this->userNationalId,
            'user_name' => $this->userName,
            'created_at' => CalendarService::getPersianDate($this->created_at)
        ];
    }
}
