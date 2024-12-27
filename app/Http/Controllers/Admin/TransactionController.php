<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Http\Resources\ShowTransactionResource;
use App\Http\Resources\SliderResource;
use App\Http\Resources\TransactionResource;
use App\Models\Slider;
use App\Models\Transaction;
use App\Repositories\Slider\SliderRepository;
use App\Services\MediaServices\MediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public object $sliderRepo;

    public function __construct()
    {
        $this->sliderRepo = new SliderRepository();
    }

    public function index(Request $request): JsonResponse
    {
        $transactions = Transaction::query()
            ->with(['project','user'])
            ->search($request->search,['trace_number'])
            ->whereStatus($request->status)
            ->filterByProject($request->project_id)
            ->latest()
            ->paginate();

        return response()->success(TransactionResource::collection($transactions), 'اطلاعات با موفقیت دریافت شد');
    }

    public function show(Transaction $transaction): JsonResponse
    {
        return response()->success(new ShowTransactionResource($transaction->load(['user','project'])), 'اطلاعات با موفقیت دریافت شد');
    }
}
