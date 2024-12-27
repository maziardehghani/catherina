<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InstallmentRequest;
use App\Http\Resources\DueDateResource;
use App\Http\Resources\InstallmentResource;
use App\Repositories\Project\ProjectRepository;
use App\Services\CalcServices\InstallmentCalcService;
use App\Models\Installment;
use App\Models\Project;
use App\Repositories\Installment\InstallmentRepository;
use App\Repositories\Invoice\InvoiceRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InstallmentController extends Controller
{
    public object $installmentRepo;
    public object $invoiceRepo;
    public object $projectRepo;

    public function __construct()
    {
        $this->installmentRepo = new InstallmentRepository();
        $this->invoiceRepo = new InvoiceRepository();
        $this->projectRepo = new ProjectRepository();
    }

    /**
     * @param Request $request the params for filtering
     *
     * @return JsonResponse contain list of installments
     *
     *
     *
     */
    public function index(Request $request):JsonResponse
    {
        $installments = Installment::query()
            ->search($request->search)
            ->whereStatus($request->status)
            ->filterByProject($request->project_id)
            ->whereRegisterAt($request->register_at)
            ->latest()
            ->paginate();


        return response()->success(InstallmentResource::collection($installments), 'اطلاعات با موفقیت دریافت شد');
    }

    public function show(Installment $installment):JsonResponse
    {
        return response()->success(new InstallmentResource($installment), 'اطلاعات با موفقیت دریافت شد');
    }

    /**
     * @param InstallmentRequest $request
     * @param Project $project
     * @return JsonResponse containing error or success details
     *
     * storing installments of profit for every users who invested at the project
     *
     */
    public function submitInstallments(InstallmentRequest $request, Project $project):JsonResponse
    {
        /**
         *
         * first remove the installments which stored before
         * for the project if are there any exist
         *
         */


        $this->installmentRepo->deleteInstallmentsOfProject($project);

        $invoices = $this->projectRepo->getInvoicesOfProject($project);


        /**
         *
         * generating installments according to the percent of the project
         * for every invoices that made by investors for the project will
         * be calculated and stored to database
         *
         */


        foreach ($invoices as $invoice) {

            $dueDateProfit = InstallmentCalcService::calcDueDateProfit($project,$invoice, $request->due_dates);


            /**
             *
             * if the actual count of due_dates for profits are n
             * the due_dates that we store in database are n+1
             *
             * the last date of due_date that we increased is the main amount of investing
             *
             */


            foreach ($request->due_dates as $due_date) {

                $this->installmentRepo->store($request->merge([
                    'invoice' => $invoice,
                    'dueDateProfit' =>  collect($request->due_dates)->last() === $due_date ? $invoice->transaction->amount : $dueDateProfit,
                    'dueDate' => $due_date,
                ]));

            }
        }

        return response()->success(null, 'اقساط با موفقیت ثبت شد');
    }

    /**
     * @param InstallmentRequest $request
     * @param Project $project
     * @return JsonResponse containing success or error details
     *
     * the installments which are for the chosen due_date will be updated
     *
     * just the status will be updated it depends on the status that coming from request
     *
     */
    public function payInstallments(InstallmentRequest $request, Project $project):JsonResponse
    {
        $installments = $this->installmentRepo->getInstallmentsOfProjectforDueDate($project,$request->due_date);

        collect($installments)->each(function ($installment) use ($request) {
            $this->installmentRepo->update($installment,$request);
        });

        return response()->success(null, 'اقساط با موفقیت به روز شد');
    }

    /**
     * @param Project $project
     * @return JsonResponse the list of due_dates for chosen project
     *
     */
    public function projectDueDates(Project $project):JsonResponse
    {
        $due_dates = $this->installmentRepo->geDueDatesOfProject($project->id);

        return response()->success(DueDateResource::collection($due_dates), 'لیست تاریخ رسید با موفقیت دریافت شد');
    }
}
