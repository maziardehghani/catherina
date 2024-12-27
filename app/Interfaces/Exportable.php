<?php

namespace App\Interfaces;

interface Exportable
{
    public static function export($dataTemplate, array $filters);
}
