<?php

return [

    'services' => [

        'excel' => [
            'class' => \App\Services\ExportServices\ExcelExporter::class,

            'dataTemplates' => [
                'users' => \App\ExcelTemplateExports\UsersExport::class,
            ],
        ],



        'excel2' => [
            'class' => \App\Services\ExportServices\ExcelExport2::class,

            'dataTemplates' => [
                'invoices' => \App\ExcelTemplateExports\InvoiceExport2::class,
            ],
        ],

    ],





];
