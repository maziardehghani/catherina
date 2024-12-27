<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\City\CityByStateResource;
use App\Http\Resources\CityResource;
use App\Http\Resources\State\StateResource;
use App\Models\State;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * @param State $state
     * @return JsonResponse containing list of cities by state
     *
     */
    public function getCitiesByState(State $state):JsonResponse
    {
        $cities = $state->cities;
        return response()->success(CityByStateResource::collection($cities));
    }
}
