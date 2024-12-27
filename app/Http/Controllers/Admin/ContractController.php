<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ContractTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContractRequest;
use App\Http\Resources\ContractDocumentTypesResource;
use App\Http\Resources\ContractResource;
use App\Http\Resources\ContractTypesResource;
use App\Models\Contract;
use App\Repositories\Contract\ContractRepository;
use App\Repositories\Project\ProjectRepository;
use App\Repositories\User\UserRepository;
use App\Services\MediaServices\MediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public object $userRepo;
    public object $contractRepo;
    public object $projectRepo;

    public function __construct()
    {
        $this->userRepo = new UserRepository();
        $this->projectRepo = new ProjectRepository();
        $this->contractRepo = new ContractRepository();
    }

    /**
     * @param Request $request searching parameter from query string
     *
     * @return JsonResponse containing contracts lists with filtering
     *
     * all contracts list
     *
     */
    public function index(Request $request): JsonResponse
    {
        $contracts = Contract::query()
            ->with(['project', 'user'])
            ->search($request->search, ['title', 'description'])
            ->whereStatus($request->status)
            ->filterByProject($request->project_id)
            ->whereRegisterAt($request->register_at)
            ->latest()
            ->paginate();

        return response()->success(ContractResource::collection($contracts), 'اطلاعات با موفقیت دریافت شد');
    }

    public function show(Contract $contract): JsonResponse
    {
        return response()->success(new ContractResource($contract), 'اطلاعات با موفقیت دریافت شد');
    }

    /**
     * @param ContractRequest $request
     * @return JsonResponse containing success or error details.
     *
     * also update the file of contract
     *
     * the contract file is required
     *
     */
    public function store(ContractRequest $request): JsonResponse
    {
        $contract = $this->contractRepo->store($request->validated());

        return response()->success($contract->id, 'اطلاعات با موفقیت ذخیره شد');

    }

    /**
     * @param ContractRequest $request
     * @param Contract $contract
     * @return JsonResponse containing success or error details.
     *
     * update a contract and replace the file of contract
     *
     * the contract file is required
     *
     */
    public function update(ContractRequest $request, Contract $contract): JsonResponse
    {
        $this->contractRepo->update($contract, $request->except('file'));

        return response()->success(null, 'اطلاعات با موفقیت ذخیره شد');
    }

    /**
     * @param Contract $contract
     * @return JsonResponse containing success or error response
     *
     * the file of contract not remove after delete
     *
     *
     */

    public function delete(Contract $contract): JsonResponse
    {
        $this->contractRepo->delete($contract);

        return response()->success(null, 'اطلاعات با موفقیت حذف شد');
    }


    public function contractsTypes()
    {
        return response()->success(ContractTypesResource::collection(ContractTypes::contracts()));
    }

    public function contractsDocumentTypes()
    {
        return response()->success(ContractTypesResource::collection(['contract', 'progress_report']));
    }

}
