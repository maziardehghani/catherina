<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Protest;

class ProtestController extends Controller
{
    public function index()
    {
        $protests = Protest::all();

        return response()->success($protests, 'اطلاعات با موفقیت دریافت شد');
    }


}
