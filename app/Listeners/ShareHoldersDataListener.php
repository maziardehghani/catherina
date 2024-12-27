<?php

namespace App\Listeners;

use App\Enums\ProjectMembersType;
use App\Models\ProjectMembersInfo;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ShareHoldersDataListener
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
        collect($event->shareHolders)->map(function ($shareHolder) use ($event) {
            ProjectMembersInfo::query()->create([
                'project_id' => $event->projectId,
                'first_name' =>  $shareHolder['First Name / Company Name'] ?? null,
                'last_name' => $shareHolder['Last Name / CEO Name'] ?? null,
                'position' => $shareHolder['Shareholder Type'] ?? null,
                'percent' => floor($shareHolder['Share Percent']) ?? null,
                'is_owner_signiture' => null,
                'type' => ProjectMembersType::SHAREHOLDER->value ?? null,
            ]);
        });
    }
}
