<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Repositories\Article\ArticleRepository;
use App\Services\MediaServices\MediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public object $articleRepo;
    public function __construct()
    {
        $this->articleRepo = new ArticleRepository();
    }

    /**
     *
     * show list of articles paginated & ordered by latest
     *
     * @return JsonResponse contain the list of articles , the list is paginated and ordered by latest
     *
     * @param Request $request contain the search parameters for filtering feature
     *
     */
    public function index(Request $request):JsonResponse
    {
        $articles = Article::search($request->search,['title'])
            ->whereStatus($request->status)
            ->whereRegisterAt($request->register_at)
            ->latest()
            ->paginate();

        return response()->success(ArticleResource::collection($articles),'اطلاعات با موفقیت دریافت شد');
    }

    public function show(Article $article):JsonResponse
    {
        return response()->success(new ArticleResource($article), 'اطلاعات با موفقیت دریافت شد');
    }

    /**
     *
     * store article in database and store the banner if isset in request
     *
     * @return JsonResponse containing success or error details.
     *
     * @param ArticleRequest $request contain the validated params for article
     *
     */
    public function store(ArticleRequest $request):JsonResponse
    {
        $request->merge([
            'user_id' => auth()->id()
        ]);

        $article = $this->articleRepo->store($request->all());

        return response()->success($article->id, 'اطلاعات با موفقیت ذخیره شد');
    }

    /**
     *
     * update article in database and update the banner if isset in request
     * if banner not sent it would be empty for article
     *
     * @return JsonResponse containing success or error details.
     *
     * @param ArticleRequest $request contain the validated params for article
     *
     */

    public function update(ArticleRequest $request, Article $article):JsonResponse
    {
        $this->articleRepo->update($article, $request->merge([
            'user_id' => auth()->id()
        ])->toArray());

        return response()->success($article->id,'اطلاعات با موفقیت به روز شد');
    }

    /**
     *
     * delete article in database and delete the banner related
     *
     * @return JsonResponse containing success or error details.
     *
     * @param Article $article the article model which about to remove
     *
     */

    public function delete(Article $article):JsonResponse
    {
        MediaService::delete($article->medias);
        $this->articleRepo->delete($article);

        return response()->success(null, 'اطلاعات با موفقیت حذف شد');
    }


    public function articleList()
    {
        $articles = Article::all();

        return response()->success(ArticleResource::collection($articles), 'اطلاعات با موفقیت دریافت شد');
    }
}
