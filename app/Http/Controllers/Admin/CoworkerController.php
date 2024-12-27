<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CoworkerRequest;
use App\Http\Resources\CoworkerResources;
use App\Models\Coworker;
use App\Repositories\Coworker\CoworkerRepository;
use App\Repositories\Coworker\TeamRepository;
use App\Services\MediaServices\MediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CoworkerController extends Controller
{
    public object $coworkerRepo;
    public function __construct()
    {
        $this->coworkerRepo = new CoworkerRepository();
    }

    /**
     * @param Request $request the params for filtering
     *
     *
     * @return JsonResponse containing list of coworkers
     *
     *
     *
     */
    public function index(Request $request):JsonResponse
    {
        $coworkers = Coworker::search($request->search, ['title'])
        ->whereStatus($request->status)
        ->latest()
        ->paginate();

        return response()->success(CoworkerResources::collection($coworkers), 'اطلاعات با موفقیت دریافت شد');
    }

    public function show(Coworker  $coworker):JsonResponse
    {
        return response()->success(new CoworkerResources($coworker), 'اطلاعات با موفقیت دریافت شد');
    }

    /**
     * @param CoworkerRequest $request
     * @return JsonResponse containing error or success details
     *
     * the logo of coworker company will save if exist in request
     *
     *
     */

    public function store(CoworkerRequest $request):JsonResponse
    {
        $coworker = $this->coworkerRepo->store($request->except('image'));

        return response()->success($coworker->id, 'اطلاعات با موفقیت ذخیره شد');
    }

    /**
     * @param Coworker $coworker
     * @param CoworkerRequest $request
     * @return JsonResponse containing success or error details
     *
     * update coworker model
     *
     * the coworker company logo will replace if exist in request
     *
     *
     */
    public function update(Coworker $coworker, CoworkerRequest $request):JsonResponse
    {
        $this->coworkerRepo->update($coworker, $request->except('image', '_method'));

        return response()->success($coworker->id, 'اطلاعات با موفقیت به روز شد');
    }

    /**
     * @param Coworker $coworker
     * @return JsonResponse
     *
     * if coworker removed the logo will remove before that
     *
     */
    public function delete(Coworker $coworker):JsonResponse
    {
        MediaService::delete($coworker->medias);
        $this->coworkerRepo->delete($coworker);
        return response()->success(null, 'اطلاعات با موفقیت حذف شد');
    }
}
