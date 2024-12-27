<?php

namespace App\Factories\SmsFactory;

use App\Interfaces\Sms;
use Illuminate\Support\Facades\Log;
use Kavenegar\KavenegarApi;

class KavenegarSmsPanel implements Sms
{
    protected object $smsPanel;
    public function __construct()
    {
        $this->smsPanel = new KavenegarApi(env('KAVENEGAR_APIKEY'));
    }
    public function sendCode(string $mobile, string $code): void
    {
        try{
            $result = $this->smsPanel->VerifyLookup($mobile, $code, null, null, 'verify', null);
            if($result){
                foreach($result as $r){
                    Log::info("messageid = $r->messageid");
                    Log::info("message = $r->message");
                    Log::info("status = $r->status");
                    Log::info("statustext = $r->statustext");
                    Log::info("sender = $r->sender");
                    Log::info("receptor = $r->receptor");
                    Log::info("date = $r->date");
                    Log::info("cost = $r->cost");
                }
            }
        }
        catch(\Kavenegar\Exceptions\ApiException $e){
            // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
            Log::info($e->errorMessage());
        }
        catch(\Kavenegar\Exceptions\HttpException $e){
            // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
            Log::info($e->errorMessage());
        }
    }
}
