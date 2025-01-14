<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserBankAccountResource extends JsonResource
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
            'account_number' => $this->getAccountNumber(),
            'bank_name' => $this->getBankName(),
            'sheba' => $this->getSheba(),
            'account_type' => $this->getAccountType()
        ];
    }
}
