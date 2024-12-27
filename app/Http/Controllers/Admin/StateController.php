<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\State\StateCityResource;
use App\Http\Resources\State\StateResource;
use App\Models\State;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     *
     * @return JsonResponse containing state list
     *
     */
    public function index():JsonResponse
    {
        $states = State::all();
        return response()->success(StateResource::collection($states));
    }
}
