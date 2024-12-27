<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectInvestorsResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'avatar' => $this->transaction?->order?->user?->mediasUrl,
            'user_name' => $this->transaction?->order?->user?->userName,
            'user_national_id' => $this->userNationalId,
            'term_conditions_accepted' => $this->term_conditions_accepted,
            'amount' => number_format($this->amount),
            'trace_code' => $this->trace_code,
        ];
    }
}
