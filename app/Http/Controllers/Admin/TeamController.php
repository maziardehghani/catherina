<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeamRequest;
use App\Http\Resources\TeamResources;
use App\Models\Team;
use App\Repositories\Team\TeamRepository;
use App\Services\MediaServices\MediaService;
use Illuminate\Http\JsonResponse;

class TeamController extends Controller
{

    public object $teamRepo;
    public function __construct()
    {
        $this->teamRepo = new TeamRepository();
    }

    public function index():JsonResponse
    {
        $teams = Team::latest()->paginate();

        return response()->success(TeamResources::collection($teams), 'اطلاعات با موفقیت دریافت شد');
    }

    public function show(Team $team):JsonResponse
    {
        return response()->success(new TeamResources($team), 'اطلاعات با موفقیت دریافت شد');
    }


    public function store(TeamRequest $request):JsonResponse
    {
        $team = $this->teamRepo->store($request->all());

        return response()->success($team->id, 'اطلاعات با موفقیت ذخیره شد');
    }

    public function update(Team $team, TeamRequest $request):JsonResponse
    {
        $this->teamRepo->update($team, $request->all());

        return response()->success($team->id, 'اطلاعات با موفقیت به روز شد');
    }

    public function delete(Team $team):JsonResponse
    {
        MediaService::delete($team->medias);
        $this->teamRepo->delete($team);
        return response()->success(null, 'اطلاعات با موفقیت حذف شد');
    }
}
