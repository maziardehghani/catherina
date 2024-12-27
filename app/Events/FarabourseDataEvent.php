<?php

namespace App\Events;

use App\Models\ProjectMembersInfo;
use App\Services\FarabourseServices\FarabourseService;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FarabourseDataEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array $farabourseInfo;
    public array $shareHolders;
    public array $stakMembers;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public int    $projectId,
        public string $traceCode,
    )
    {
        $this->farabourseInfo = FarabourseService::getProjectInfo(trim($this->traceCode)) ?? [];

        ProjectMembersInfo::query()->where('project_id', $this->projectId)->delete();

        $this->shareHolders = $this->farabourseInfo['List Of Project Big Share Holders'] ?? [];

        $this->stakMembers = $this->farabourseInfo['List Of Project Board Members'] ?? [];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
