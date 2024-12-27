<?php

namespace App\Http\Resources;

use App\Http\Resources\User\UserResource;
use App\Services\CalendarServices\CalendarService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowInvoiceResource extends JsonResource
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
            'receipt' => $this->receiptImage,
            'amount' => $this->amount,
            'user' => new UserResource($this->transaction?->user) ,
            'project' => new ProjectResource($this->transaction?->project),
            'trace_number' => $this->traceNumber,
            'status_id' => $this->status_id,
            'date' => CalendarService::getPersianDate($this->created_at),
        ];
    }
}
