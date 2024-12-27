<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Http\Resources\SliderResource;
use App\Models\Slider;
use App\Repositories\Slider\SliderRepository;
use App\Services\MediaServices\MediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SliderController extends Controller
{

    public object $sliderRepo;

    public function __construct()
    {
        $this->sliderRepo = new SliderRepository();
    }

    public function index(Request $request): JsonResponse
    {
        $sliders = Slider::search($request->search, ['title'])
            ->whereStatus($request->status)
            ->latest()
            ->paginate();

        return response()->success(SliderResource::collection($sliders), 'اطلاعات با موفقیت دریافت شد');
    }

    public function show(Slider $slider): JsonResponse
    {
        return response()->success(new SliderResource($slider), 'اطلاعات با موفقیت دریافت شد');
    }

    public function store(SliderRequest $request): JsonResponse
    {
        $this->sliderRepo->store($request->validated());

        return response()->success(null, 'اطلاعات با موفقیت دریافت شد');
    }

    public function update(SliderRequest $request, Slider $slider): JsonResponse
    {
        $this->sliderRepo->update($slider, $request->all());

        return response()->success(null, 'اطلاعات با موفقیت به روز شد');
    }

    public function delete(Slider $slider): JsonResponse
    {
        MediaService::delete($slider->medias);
        $this->sliderRepo->delete($slider);
        return response()->success(null, 'اطلاعات با موفقیت حذف شد');
    }
}
