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
            'id' => $this->id,
            'user' => new UserResource($this->whenLoaded('user')),
            'experts' => ExpertResources::collection($this->whenLoaded('experts')),
            'title' => $this->title,
            'shortTitle' => $this->shortTitle,
            'percent' => $this->percent,
            'funding_period' => $this->funding_period,
            'slug' => $this->slug,
            'total_amount' => $this->farabourseTotalAmounts,
            'minimum_amount' =>  $this->minimumAmount,
            'real_person_minimum_amount' =>  $this->realPersonMinimAmount,
            'legal_person_minimum_amount' =>  $this->legalPersonMinimAmount,
            'real_person_maximum_amount' =>  $this->realPersonMaximAmount,
            'legal_person_maximum_amount' =>  $this->legalPersonMaximAmount,
            'collected_amount' => $this->collectedAmount,
            'state' => new StateResource($this->whenLoaded('state')),
            'city' => new CityResource($this->whenLoaded('city')),
            'project_intro' => $this->project_intro,
            'expert_opinion' => $this->expert_opinion,
            'company_intro' => $this->company_intro,
            'project_risks' => $this->project_risks,
            'warranty_inquiry' => $this->warrantyTitle,
            'warranty_inquiry_id' => $this->warrantyId,
            'warranty_inquiry_link' => $this->warrantyLink,
            'warranty_details' => $this->warranty_details,
            'participation_generated' => $this->participation_generated,
            'banner' => $this->banner,
            'logo' => $this->logo,
            'status' => $this->statusTitle,
            'status_id' => $this->status_id,
            'persian_status' => $this->persianStatus,
            'stopped_at' => CalendarService::getDate($this->stopped_at),
            'created_at' => CalendarService::humanDate($this->created_at)
        ];
    }
}
