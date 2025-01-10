<?php

namespace App\Http\Resources\User;

use App\Services\CalendarServices\CalendarService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserTransactionResource extends JsonResource
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
            'amount' => $this->getAmount(),
            'status' => $this->getStatus(),
            'terminal_id' => $this->getTerminalId(),
            'trace_number' => $this->getTraceNumber(),
            'rrn' => $this->getRrn(),
            'secure_pan' => $this->getSecurePan(),
            'token' => $this->getToken(),
            'gateWay' => $this->getGateway(),
            'created_at' => CalendarService::getPersianDate($this->getCreatedAt(),"Y-m-d H:i:s")
        ];
    }
}
