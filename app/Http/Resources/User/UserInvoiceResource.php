<?php

namespace App\Http\Resources\User;

use App\Services\CalendarServices\CalendarService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserInvoiceResource extends JsonResource
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
            'term_condition_accepted' => (bool)$this->getTermConditionAccepted(),
//            'project_name' => $this->projectName,
            'terminal_id' => $this->getTerminalId(),
            'trace_number' => $this->getTraceNumber(),
            'rrn' => $this->getRrn(),
            'secure_pan' => $this->getSecurePan(),
            'token' => $this->getToken(),
            'gateway' => $this->getGateWay(),
            'created_at' => CalendarService::getPersianDate($this->getCreatedAt(),'Y-m-d')
        ];
    }
}
