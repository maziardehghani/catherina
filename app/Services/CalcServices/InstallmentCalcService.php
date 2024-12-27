<?php

namespace App\Services\CalcServices;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\Project;

class InstallmentCalcService
{
    static public function calcMonthlyProfitPercent($percent,$fundingPeriod): float|int
    {
        return ($percent / 12) * $fundingPeriod;
    }

    static public function calcTotalInstallmentAmount($eachMountPercent, $amount): float|int
    {
        return ($eachMountPercent / 100) * $amount;
    }

    static public function calcEachMonthProfit($TotalInstallmentAmount, $due_dates )
    {
        return $TotalInstallmentAmount / (count($due_dates)-1);
    }

    static public function calcDueDateProfit(Project $project,Invoice $invoice,array $due_dates): float|int
    {
        // محاسبه درصد سود ماهانه
        $monthlyProfitPercent = InstallmentCalcService::calcMonthlyProfitPercent($project->percent,$project->funding_period);

        // محاسبه مبلغ کلی قسط
        $TotalInstallmentAmount = InstallmentCalcService::calcTotalInstallmentAmount($monthlyProfitPercent, $invoice->amount);

        // تقسیم مبلغ کلی به تعداد اقساط
        return InstallmentCalcService::calcEachMonthProfit($TotalInstallmentAmount, $due_dates);


    }
}
