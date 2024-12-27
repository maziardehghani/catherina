<?php

namespace App\ExcelTemplateExports;

use App\Models\Invoice;
use App\Services\CalendarServices\CalendarService;
use App\Traits\Exporter;

class InvoiceExport2
{
    use Exporter;

    public $search;

    public function __construct(array $filters = [])
    {

        $this->search = $filters['search'] ?? null;
    }

    public function handle()
    {
        $invoices = Invoice::query()
            ->with(['transaction'])
            ->search($this->search, ['trace_code'])
            ->latest()
            ->get();

        $writer = $this->exportAsExcel(
            'invoice.xlsx',
            [
                'شناسه',
                'کاربر',
                'شبا',
                'مبلغ (ریال)',
                'نوع شخصیت',
                'نوع پرداخت',
                'شماره رهگیری',
                'وضعیت',
                'عنوان طرح',
                'تاریخ',
                'شماره تلفن'
            ]);

        foreach ($invoices as $index => $invoice) {
            $writer->addRow([
                $invoice->id,
                $invoice->amount,
                $invoice->amount,
                $invoice->amount,
                $invoice->amount,
                $invoice->persianGateway,
                $invoice->traceNumber,
                $invoice->persianStatus,
                $invoice->projectName,
                CalendarService::getPersianDate($invoice->created_at),
                $invoice->userMobile
            ]);
        }
        return $writer;
    }
}
