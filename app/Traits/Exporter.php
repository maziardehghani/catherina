<?php

namespace App\Traits;

use Spatie\SimpleExcel\SimpleExcelWriter;

trait Exporter
{
    public function exportAsExcel(string $fileName, array $headers):SimpleExcelWriter
    {
        $writer = SimpleExcelWriter::streamDownload($fileName)
            ->addHeader($headers);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename=' . $fileName);

        return $writer;
    }
}
