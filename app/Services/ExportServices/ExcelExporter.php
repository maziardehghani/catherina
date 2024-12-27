<?php

namespace App\Services\ExportServices;

use App\Interfaces\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;


class ExcelExporter implements Exportable
{
    public static function export($dataTemplate, array $filters)
    {
        $exportModule = config('exporter.services')['excel']['dataTemplates'][$dataTemplate];


        if (! (new $exportModule($filters)) instanceof FromQuery) {

            throw new \InvalidArgumentException();
        }

        return (new $exportModule($filters))->download("$dataTemplate.xlsx");

    }
}












































//        if (!$list instanceof FromQuery &
//            !$list instanceof WithMapping &
//            !$list instanceof WithHeadings) {
//
//            throw new InvalidParameterException();
//        }
