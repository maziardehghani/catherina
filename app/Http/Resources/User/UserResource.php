<?php

namespace App\Http\Resources\User;

use App\Services\CalendarServices\CalendarService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'avatar' => $this->mediasUrl,
            'user_name' => $this->userName,
            'name' => $this->name,
            'family' => $this->family,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'status' => $this->statusTitle,
            'status_id' => $this->status_id,
            'persian_type' => $this->persianType,
            'type' => $this->type,
            'bio' => $this->bio,
            'is_private_investor' => $this->privateInvestor,
            'sejam_status' => $this->sejamStatus,
            'national_id' => $this->nationalId,
            'economic_code' => $this->economicCode,
            'register_code' => $this->registerCode,
            'manager_name' => $this->managerName,
            'manager_national_id' => $this->managerNationalId,
            'postal_code' => $this->postalCode,
            'phone_number' => $this->phoneNumber,
            'fax' => $this->fax,
            'address' => $this->address,
            'father_name' => $this->fatherName,
            'serial_number' => $this->serialNumber,
            'persian_gender' => $this->genderName,
            'gender' => $this->gender,
            'place_of_birth' => $this->placeOfBirth,
            'place_of_issue' => $this->placeOfIssue,
            'birth_date' => $this->birthDate,
            'account_number' => $this->accountNumber,
            'bank_name' => $this->bankName,
            'sheba' => $this->getShebaExceptAyandehBank,
            'account_type' => $this->accountType,
            'company_name' => $this->companyName,
            'trading_code' => $this->tradingCode,
            'is_sejami' => $this->is_sejami,
            'created_at' => CalendarService::getPersianDate($this->created_at, 'Y-m-d H:i:s')
        ];

    }
}
