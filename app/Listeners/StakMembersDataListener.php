<?php

namespace App\Listeners;

use App\Enums\ProjectMembersType;
use App\Models\ProjectMembersInfo;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class StakMembersDataListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        collect($event->stakMembers)->map(function ($stakMember) use($event){
            ProjectMembersInfo::query()->create(
                [
                    'project_id' => $event->projectId,
                    'first_name' => $stakMember['First Name'] ?? null,
                    'last_name' => $stakMember['Last Name'] ?? null,
                    'position' => $stakMember['Organization Post Description'] ?? null,
                    'percent' => null,
                    'is_owner_signiture' => $stakMember['Is Agent from a Company'] ?? null,
                    'type' => ProjectMembersType::STAKMEMBER->value,
                ]);
        });

    }
}
