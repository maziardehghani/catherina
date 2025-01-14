<?php

namespace App\Http\Resources;

use App\Http\Resources\User\UserResource;
use App\Models\Status;
use App\Services\CalendarServices\CalendarService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use function App\Helpers\calceCollectedPercent;

class ProjectResource extends JsonResource
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
            'user' => UserResource::make($this->getUser()),
            'title' => $this->getTitle(),
            'percent' => $this->getPercent(),
            'funding_period' => $this->getFundingPeriod(),
            'slug' => $this->getSlug(),
            'total_amount' => $this->getFarabourseTotalAmounts(),
            'minimum_amount' =>  $this->getMinimumAmount(),
            'real_person_minimum_amount' =>  $this->getRealPersonMinimAmount(),
            'legal_person_minimum_amount' =>  $this->getLegalPersonMinimAmount(),
            'real_person_maximum_amount' =>  $this->getRealPersonMaximAmount(),
            'legal_person_maximum_amount' =>  $this->getLegalPersonMaximAmount(),
//            'collected_amount' => $this->collectedAmount,
//            'state' => new StateResource($this->whenLoaded('state')),
//            'city' => new CityResource($this->whenLoaded('city')),
            'project_intro' => $this->getProjectIntro(),
            'expert_opinion' => $this->getExpertOpinion(),
            'company_intro' => $this->getCompanyIntro(),
            'project_risks' => $this->getProjectRisks(),
//            'warranty_inquiry' => $this->warrantyTitle,
//            'warranty_inquiry_id' => $this->warrantyId,
//            'warranty_inquiry_link' => $this->warrantyLink,
            'warranty_details' => $this->getWarrantyDetails(),
            'participation_generated' => $this->isParticipationGenerated(),
//            'banner' => $this->banner,
//            'logo' => $this->logo,
            'status' => $this->getStatus()?->getTitle(),
            'created_at' => CalendarService::getPersianDate($this->getCreatedAt())
        ];
    }
}
