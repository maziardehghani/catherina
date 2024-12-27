<?php

namespace App\Http\Resources;

use App\Services\CalendarServices\CalendarService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * the created_at is gregorian formatted
     *
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'image' => $this->mediasUrl,
            'writer' => $this->writer,
            'writer_avatar' => $this->writerAvatar,
            'title' => $this->title,
            'short_title' => $this->shortTitle,
            'slug' => $this->slug,
            'intro' => $this->intro,
            'content' => $this->content,
            'comment_counts' => $this->commentCounts,
            'status' => $this->statusTitle,
            'status_id' => $this->status?->id,
            'created_at' => CalendarService::humanDate($this->created_at)
        ];
    }
}
