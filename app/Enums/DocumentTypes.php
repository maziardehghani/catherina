<?php

namespace App\Enums;

use function Laravel\Prompts\search;

enum DocumentTypes: string
{
    case CONTRACT = 'contract';
    case PROGRESS_REPORT = 'progress_report';

}
