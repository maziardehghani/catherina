<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserInvestmentReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'total_invoices_amount' =>  number_format($this['total_invoices_amount']),
            'total_installments_amount'=> number_format($this['total_installments_amount']),
            'total_projects_count' =>  $this['total_projects_count']
        ];
    }
}
