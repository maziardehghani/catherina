<?php

namespace App\Services\FarabourseServices;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class FarabourseService
{
    public static function getProjectInfo($traceCode)
    {
        $response = self::postRequest('getProjectInfo', [
            "projectID" => $traceCode,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }


    public static function getParticipationReport($invoice)
    {
        $response = self::postRequest('getParticipationReport',[
                "projectID" => $invoice->transaction?->order?->projectTraceCode,
                "NationalID" => $invoice->user?->nationalId,
            ]
        );

        return json_decode($response->getBody()->getContents());
    }

    private static function postRequest($url, $params)
    {
        $params["ApiKey"] = env('FARABOURSE_API_KEY');

        $response = (new Client(['http_errors' => false, 'verify' => false]))
            ->post(env('FARABOURSE_BASE_URL') . $url, [
                "json" => $params,
            ]);

        if ($response->getStatusCode() != 200) {
            Log::error("farabourse connection failed: code = " . $response->getStatusCode() . ' ' . $response->getBody()->getContents());
        }

        return $response;
    }
}
