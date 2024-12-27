<?php

namespace App\Helpers;

function export($exporter, $dataTemplate = null , array $filters = [])
{
    return config('exporter.services')[$exporter]['class']::export($dataTemplate, $filters);
}

function getBankLogos()
{
    $banks = config('bank.bankLists');

    return collect($banks)->map(function ($bank) {
        $folderPath = public_path("media/Bank/{$bank['folder']}/*");
        $file = collect(glob($folderPath))->first();

        return [
            'name' => $bank['name'],
            'pathLogo' => $file ? '/media/Bank/' . $bank['folder'] . '/' . basename($file) : null,
        ];
    })->toArray();
}


function calceCollectedPercent ($total, $part)
{
    if ($total <= 0)
    {
        return 0;
    }

    if ($part > $total) {
        return 0;
    }

    return ($part / $total) * 100;
}


function getEntityName(string $namespace):string
{
    return lcfirst(basename(str_replace('\\', '/', $namespace)));
}


