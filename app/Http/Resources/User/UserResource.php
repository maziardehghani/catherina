<?php

namespace App\Http\Resources\User;

use App\Services\CalendarServices\CalendarService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getId(),
            'user_name' => $this->getUserName(),
            'name' => $this->getName(),
            'family' => $this->getFamily(),
            'email' => $this->getEmail(),
            'mobile' => $this->getMobile(),
            'status_id' => $this->getStatus()->getTitle(),
            'type' => $this->getType()->value,
            'bio' => $this->getBio(),
            'is_private_investor' => $this->getIsPrivateInvestor(),
            'sejam_status' => $this->getSejamStatus(),
            'national_id' => $this->getNationalId(),
            'economic_code' => $this->getEconomicCode(),
            'register_code' => $this->getRegisterCode(),
            'manager_name' => $this->getManagerName(),
            'manager_national_id' => $this->getManagerNationalId(),
            'postal_code' => $this->getPostalCode(),
            'phone_number' => $this->getPhoneNumber(),
            'fax' => $this->getFax(),
            'address' => $this->getAddress(),
            'father_name' => $this->getFatherName(),
            'serial_number' => $this->getSerialNumber(),
            'persian_gender' => $this->getGenderName(),
            'gender' => $this->getGender(),
            'place_of_birth' => $this->getPlaceOfBirth(),
            'place_of_issue' => $this->getPlaceOfIssue(),
            'birth_date' => $this->getBirthDate(),
            'account_number' => $this->getAccountNumber(),
            'bank_name' => $this->getBankName(),
            'sheba' => $this->getShebaExceptAyandehBank(),
            'account_type' => $this->getAccountType(),
            'company_name' => $this->getCompanyName(),
            'trading_code' => $this->getTradingCode(),
            'is_sejami' => $this->getIsSejami(),
            'created_at' => CalendarService::getPersianDate($this->getCreatedAt()?->format('Y-m-d H:i:s')),
          ];

    }
}
