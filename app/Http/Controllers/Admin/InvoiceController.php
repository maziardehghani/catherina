<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceRequest;
use App\Http\Resources\InvoiceResource;
use App\Http\Resources\ShowInvoiceResource;
use App\Models\Invoice;
use App\Models\Project;
use App\Repositories\Invoice\InvoiceRepository;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Transaction\TransactionRepository;
use App\Services\CalendarServices\CalendarService;
use App\Services\FarabourseServices\FarabourseService;
use App\Services\MediaServices\MediaService;
use App\Traits\Exporter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use function App\Helpers\export;

class InvoiceController extends Controller
{
    use Exporter;

    public object $invoiceRepo;
    public object $orderRepo;
    public object $transactionRepo;

    public function __construct()
    {
        $this->invoiceRepo = new InvoiceRepository();
        $this->orderRepo = new OrderRepository();
        $this->transactionRepo = new TransactionRepository();
    }

    /**
     * @param Request $request containing params for filtering invoices
     * come from request
     *
     *
     * @return JsonResponse containing list of invoices
     *
     */
    public function index(Request $request): JsonResponse
    {
        $invoices = Invoice::query()
            ->with(['transaction.user','transaction.project'])
            ->search($request->search)
            ->filterByProject($request->project_id)
            ->latest()
            ->paginate();

        return response()->success(InvoiceResource::collection($invoices), 'اطلاعات با موفقیت دریافت شد');
    }

    public function show(Invoice $invoice): JsonResponse
    {
        return response()->success(new ShowInvoiceResource($invoice), 'اطلاعات با موفقیت دریافت شد');
    }

    /**
     * @param InvoiceRequest $request data of new bank-receipt
     *
     *
     * @return JsonResponse containing success or error response
     *
     *
     * storing the bank-receipt for project
     *
     */
    public function store(InvoiceRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {

            /**
             *
             * store order for investment and add order id to request
             * then pass it to transaction repo
             *
             */
            $order = $this->orderRepo->store($request->all());
            $request->merge(['order_id' => $order->id]);

            /**
             *
             * store transaction for investment and add transaction id to request
             * then pass it to invoice repo
             *
             */
            $transaction = $this->transactionRepo->store($request->all());
            $request->merge(['transaction_id' => $transaction->id]);

            /**
             *
             * store invoice for investment and store the image of receipt
             *
             */
            $invoice = $this->invoiceRepo->store($request->all());

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage() . ' ' . $exception->getLine());
            return response()->error('خطا در ذخیره اطلاعات');
        }

        return response()->success($invoice->id, 'اطلاعات با موفقیت ذخیره شد');
    }

    public function update(InvoiceRequest $request, Invoice $invoice): JsonResponse
    {
        DB::beginTransaction();
        try {

            /**
             *
             * update order for investment and add order id to request
             * then pass it to transaction repo
             *
             */

            $this->orderRepo->update($invoice->transaction->order, $request->all());
            $request->merge(['order_id' => $invoice->transaction->order->id]);

            /**
             *
             * update transaction for investment and add transaction id to request
             * then pass it to invoice repo
             *
             */
            $this->transactionRepo->update($invoice->transaction, $request->all());
            $request->merge(['transaction_id' => $invoice->transaction->id]);

            /**
             *
             *
             * update invoice for investment and update the image of receipt
             *
             */
            $this->invoiceRepo->update($invoice, $request->all());

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage() . ' ' . $exception->getLine());
            return response()->error('خطا در ذخیره اطلاعات');
        }

        return response()->success(null, 'اطلاعات با موفقیت ذخیره شد');

    }

    public function delete(Invoice $invoice): JsonResponse
    {
        $this->invoiceRepo->delete($invoice);

        return response()->success(null, 'اطلاعات با موفقیت حذف شد');
    }

    /**
     * @param Request $request params for filtering
     *
     * @return mixed Excel file of invoices list
     *
     *
     *
     */
    public function exportInvoice(Request $request)
    {
        export('excel2', 'invoices', $request->only('search'));
    }

    /**
     * @param Invoice $invoice
     * @return mixed PDF file of participation of investing that coming from Farabourse
     *
     * we use farabourse api to get participation
     *
     */

    public function getParticipationReport(Invoice $invoice)
    {
        $meta = FarabourseService::getParticipationReport($invoice);

        if (is_null($meta) || $meta->ErrorNo == 1027) {
            return response()->error('خطا در دریافت گواهی مشارکت');
        }

        return response()->pdfResponse($meta);
    }


    /**
     * @param Project $project
     * @return mixed containing list of investors and the total amount that invested
     *
     *
     */

    public function getProjectInvestors(Project $project)
    {
        return response()->success([
            'investors' => $this->invoiceRepo->getInvestorsOfProjectByTraceCode($project?->farabourseProject?->trace_code),
            'total_provided_finance' => number_format($this->invoiceRepo->getProvidedFinanceOfProject($project?->farabourseProject?->trace_code))
        ], 'لیست تاریخ رسید با موفقیت دریافت شد');
    }
}
