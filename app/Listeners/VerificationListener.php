<?php

namespace App\Listeners;

use App\Factories\SmsFactory\SenderFactory;
use App\Services\CodeService\VerifyCodeService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class VerificationListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        VerifyCodeService::store($event->mobile, VerifyCodeService::generate());

        (new SenderFactory())->getSender('kavenegar')->sendCode($event->mobile, VerifyCodeService::get($event->mobile));
    }
}
