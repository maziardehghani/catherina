<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Warranty\WarrantyResource;
use App\Models\Warranty;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WarrantyController extends Controller
{
    /**
     * @return JsonResponse warranties list
     *
     */
    public function index():JsonResponse
    {
        return response()->success(WarrantyResource::collection(Warranty::all()));
    }
}
