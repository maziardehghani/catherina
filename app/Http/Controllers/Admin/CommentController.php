<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Repositories\Comment\CommentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public object $commentRepo;
    public function __construct()
    {
        $this->commentRepo = new CommentRepository();
    }

    /**
     * @return JsonResponse containing comments list
     *
     *
     * all comments for projects
     *
     */
    public function projectComments(Request $request):JsonResponse
    {
        $comments = $this->commentRepo->getAllProjectComments($request);

        return response()->success(CommentResource::collection($comments), 'اطلاعات موفقیت دریافت شد');
    }

    /**
     * @return JsonResponse containing comments list
     *
     *
     * all comments for articles
     *
     */

    public function articleComments(Request $request):JsonResponse
    {
        $comments = $this->commentRepo->getAllArticleComments($request);

        return response()->success(CommentResource::collection($comments), 'اطلاعات موفقیت دریافت شد');
    }

    public function show(Comment $comment):JsonResponse
    {
        return response()->success(new CommentResource($comment->load('user')), 'اطلاعات موفقیت دریافت شد');
    }

    /**
     * @param Comment $comment
     * @param CommentRequest $request
     * @return JsonResponse containing success or error details.
     *
     *
     * answering a comment by admin
     *
     */

    public function answerComment(Comment $comment, CommentRequest $request):JsonResponse
    {
        $this->commentRepo->answer($comment,$request);

        return response()->success(null, 'اطلاعات موفقیت ذخیره شد');
    }

    /**
     * @return JsonResponse c
     *
     * updating the comment of users or the comment of admin
     *
     * @param Comment $comment
     * @param CommentRequest $request
     *
     */

    public function update(Comment $comment, CommentRequest $request):JsonResponse
    {
        $this->commentRepo->update($comment,$request->except('_method'));

        return response()->success(null, 'اطلاعات موفقیت ذخیره شد');
    }

    /**
     * @param Comment $comment
     * @return JsonResponse
     *
     *
     */
    public function delete(Comment $comment):JsonResponse
    {
        $this->commentRepo->delete($comment);

        return response()->success(null, 'اطلاعات موفقیت حذف شد');
    }

}
