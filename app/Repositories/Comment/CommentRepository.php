<?php

namespace App\Repositories\Comment;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Project;
use App\Repositories\Repository;

class CommentRepository extends Repository
{
    public function __construct()
    {
        $this->model = Comment::query();
        $this->paginate = 20;
    }

    public function getAllProjectComments($request)
    {
        return $this->model
            ->where('commentable_type', Project::class)
            ->with(['parent', 'user'])
            ->search($request->search)
            ->filterByProject($request->project_id)
            ->whereStatus($request->status)
            ->latest()
            ->paginate();
    }

    public function getAllArticleComments($request)
    {
        return $this->model
            ->where('commentable_type', Article::class)
            ->with(['parent', 'user'])
            ->search($request->search)
            ->filterByArticle($request->article_id)
            ->whereStatus($request->status)
            ->latest()
            ->paginate();
    }

    public function answer($comment, $data)
    {
        return $this->store([
            'user_id' => auth()->id(),
            'commentable_id' => $comment->commentable_id,
            'commentable_type' => $comment->commentable_type,
            'content' => $data->content,
            'parent_id' => $comment->id,
            'status_id' => $data->status_id
        ]);
    }
}
