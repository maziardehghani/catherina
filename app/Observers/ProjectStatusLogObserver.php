<?php

namespace App\Observers;

use App\Models\Project;
use App\Models\ProjectStatusLog;

class ProjectStatusLogObserver
{
    /**
     * Handle the Project "created" event.
     */
    public function created(Project $project): void
    {
        //
    }

    /**
     * Handle the Project "updated" event.
     */
    public function updated(Project $project): void
    {
        if ($project->wasChanged('status_id'))
        {
            ProjectStatusLog::query()->create([
               'status_id' => $project->status_id,
               'project_id' => $project->id,
               'user_id' => auth()->user()->id ?? null,
            ]);
        }
    }

    /**
     * Handle the Project "deleted" event.
     */
    public function deleted(Project $project): void
    {
        //
    }

    /**
     * Handle the Project "restored" event.
     */
    public function restored(Project $project): void
    {
        //
    }

    /**
     * Handle the Project "force deleted" event.
     */
    public function forceDeleted(Project $project): void
    {
        //
    }
}
