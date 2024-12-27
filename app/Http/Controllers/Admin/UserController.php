<?php

namespace App\Http\Controllers\Admin;

use App\Entities\User;
use App\Entities\UsersInfosValues;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Resources\BankListResource;
use App\Http\Resources\ExpertResources;
use App\Http\Resources\User\UserBankAccountResource;
use App\Http\Resources\User\UserInstallmentResource;
use App\Http\Resources\User\UserInvestmentReportResource;
use App\Http\Resources\User\UserInvoiceResource;
use App\Http\Resources\User\LegalUsersResource;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserTransactionResource;
use App\Http\Resources\UserListResource;
use App\Repositories\User\UserRepository;
use App\Services\MediaServices\MediaService;
use App\Traits\Exporter;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use function App\Helpers\export;
use function App\Helpers\getBankLogos;


class UserController extends Controller
{
    use Exporter;


    public function __construct(

        public EntityManagerInterface $entityManager,
        public UserRepository $userRepository,

    )
    {

    }

    /**
     * @param Request $request params for filtering users
     * @return JsonResponse containing list of users
     *
     */
    public function index(Request $request): JsonResponse
    {
        $pagination = $this->userRepository->paginate($request->page?? 1,5);

        return response()->success([
            'data' => UserResource::collection($pagination['data']),
            'total' => $pagination['total'],
            'current_page' => $pagination['current_page'],
            'per_page' => $pagination['per_page'],
        ], 'اطلاعات با موفقیت دریافت شد');
    }
    /**
     *
     * @return JsonResponse containing list of users legal
     *
     */
    public function legalUsers(): JsonResponse
    {
        $users = $this->userRepo->getLegalUsers();

        return response()->success(LegalUsersResource::collection($users));
    }


    /**
     * @param Request $request params for filtering users
     *
     * @return BinaryFileResponse file export for any type
     *
     *
     */
    public function export(Request $request): BinaryFileResponse
    {
        return export($request->exporter, 'users', $request->only([
            'search',
            'status',
            'type',
            'register_at',
        ]));
    }

    public function show(User $user): JsonResponse
    {
        return response()->success(new UserResource($user->load(['status', 'userInfos.UserInfoTitle', 'medias'])));
    }

    /**
     * @param UserRequest $request
     * @return JsonResponse containing error or success detail
     *
     *
     * save user data and user sejam datas if exist in request
     *
     */
    public function store(UserRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $user = $this->userRepo->store($request);

            $this->userRepo->storeSejamInfos($request->validated(), $user);

            DB::commit();

        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage() . ' ' . $exception->getLine());
            return response()->error('ذخیره کاربر با خطا مواجه شد', 500);
        }

        return response()->success($user->getKey(), 'اطلاعات با موفقیت ذخیره شد');
    }

    /**
     * @param User $user
     * @param UserRequest $request
     * @return JsonResponse
     *
     *
     * update user data and user profile if exist
     * if profile not sent it will remove previous photo
     *
     */
    public function update(User $user, UserRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->userRepo->update($user, $request);

            $this->userRepo->storeSejamInfos($request->validated(), $user);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage() . ' ' . $exception->getLine());
            return response()->error('ذخیره کاربر با خطا مواجه شد', 500);

        }

        return response()->success($user->getKey());
    }

    /**
     * @param User $user
     * @return JsonResponse contain error or success detail
     *
     * the profile photo of user will be remove before removing it from database
     *
     */
    public function delete(User $user): JsonResponse
    {
        MediaService::delete($user->medias);
        $this->userRepo->deleteSejamInfos($user);
        $this->userRepo->delete($user);
        return response()->success('اطلاعات کاربر با موفقیت حذف شد');
    }

    /**
     * @param User $user
     * @return JsonResponse all invoices that are related to user
     *
     *
     */
    public function invoices(User $user): JsonResponse
    {
        $invoices = $this->invoiceRepo->getInvoicesOfUser($user);

        return response()->success(UserInvoiceResource::collection($invoices), 'صورتحساب های کاربر دریافت شد');
    }

    /**
     * @param User $user
     * @return JsonResponse contains transactions of user
     *
     * list of transactions that belongs to a user
     *
     */
    public function transactions(User $user): JsonResponse
    {
        $transactions = $user->transactions()->latest()->paginate($this->transactionRepo->paginate);

        return response()->success(UserTransactionResource::collection($transactions));

    }

    /**
     * @param User $user
     * @return JsonResponse contain list of user installments
     *
     */
    public function installments(User $user): JsonResponse
    {
        $installments = $this->installmentRepo->getInstallmentsOfUser($user);

        return response()->success(UserInstallmentResource::collection($installments));

    }

    /**
     * @param User $user
     * @return JsonResponse contains list of user investment report
     *
     *
     */

    public function investmentReport(User $user): JsonResponse
    {
        $data = [
            'total_invoices_amount' => $this->transactionRepo->getSumInvoicesOfUser($user),
            'total_installments_amount' => $this->installmentRepo->getSumInstallmentsOfUser($user),
            'total_projects_count' => $this->projectRepo->getCountProjectOfUser($user)
        ];

        return response()->success(new UserInvestmentReportResource($data));
    }

    /**
     * @param User $user
     * @return JsonResponse contain list of user bank accounts
     *
     *
     */
    public function bankAccounts(User $user): JsonResponse
    {
        return response()->success(new UserBankAccountResource($user->load('userInfos.UserInfoTitle')));
    }

    /**
     * @return JsonResponse contain list of bank
     *
     *
     */
    public function bankLists(): JsonResponse
    {
        return response()->success(BankListResource::collection(getBankLogos()));
    }

    public function experts(): JsonResponse
    {
        $userExperts = $this->userRepo->getExpertUsers();

        return response()->success(ExpertResources::collection($userExperts), 'اطلاعات با موفقیت دریافت شد');
    }


    public function usersList(): JsonResponse
    {
        $users = User::with(['status', 'medias'])->get();

        return response()->success(UserListResource::collection($users), 'اطلاعات با موفقیت دریافت شد');
    }
}
