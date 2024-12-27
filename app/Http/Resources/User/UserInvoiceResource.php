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
            'amount' => number_format($this->amount),
            'term_condition_accepted' => (bool)$this->term_conditions_accepted,
            'project_name' => $this->projectName,
            'terminal_id' => $this->terminal_id,
            'trace_number' => $this->traceNumber,
            'rrn' => $this->rrn,
            'secure_pan' => $this->securePan,
            'token' => $this->token,
            'gateway' => $this->gateWay,
            'created_at' => CalendarService::getPersianDate($this->created_at,'Y-m-d')
        ];
    }
}
