<?php

namespace App\ExcelTemplateExports;

use App\Models\User;
use App\Services\CalendarServices\CalendarService;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromQuery, withMapping, WithHeadings
{
    use Exportable;

    public $search;
    public $status;
    public $type;
    public $register_at;

    public function __construct(array $filters=[])
    {
        $this->search = $filters['search'] ?? null;
        $this->status = $filters['status'] ?? null;
        $this->type = $filters['type'] ?? null;
        $this->register_at = $filters['register_at'] ?? null;
    }

    public function query()
    {
        return User::search($this->search)
            ->whereStatus($this->status)
            ->whereType($this->type)
            ->whereRegisterAt($this->register_at)
            ->latest();
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->userName,
            $row->persianType,
            $row->mobile,
            $row->nationalId,
            $row->email,
            $row->tradingCode,
            CalendarService::getPersianDate($row->created_at, 'Y-m-d H:i:s'),
            $row->sejamStatus,
            $row->persianStatus,
        ];
    }

    public function headings(): array
    {
        return [
            'ردیف',
            'نام کاربر',
            'نوع شخصیت',
            'موبایل',
            'کد ملی',
            'ایمیل',
            'کد بورسی',
            'تاریخ ثبت نام',
            'وضعیت سجام',
            'وضعیت کاربر'
        ];
    }
}
