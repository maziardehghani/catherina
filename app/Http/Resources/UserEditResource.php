<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserEditResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'family' => $this->family,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'password' => $this->password,
            'company_name' => $this->company_name,
            'register_code' => $this->register_code,
            'economic_code' => $this->economic_code,
            'manager_name' => $this->manager_name,
            'manager_national_id' => $this->manager_national_id,
            'phone_number' => $this->phone_number,
            'fax' => $this->fax,
            'trading_code' => $this->trading_code,
            'national_id' => $this->national_id,
            'place_of_birth' => $this->place_of_birth,
            'place_of_issue' => $this->place_of_issue,
            'type' => $this->type,
            'status_id' => $this->status_id,
            'serial_number' => $this->serial_number,
            'is_sejami' => $this->is_sejami,
            'father_name' => $this->father_name,
            'gender' => $this->gender,
            'postal_code' => $this->postal_code,
            'address' => $this->address,
            'birth_date' => $this->birth_date,
            'bank_name' => $this->bank_name,
            'sheba' => $this->sheba,
            'account_number' => $this->account_number,
            'account_type' => $this->account_type
        ];
    }
}
