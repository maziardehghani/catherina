<?php

namespace App\Factories\SmsFactory;

use App\Interfaces\Sms;
use http\Exception\InvalidArgumentException;

class SenderFactory
{
    public function getSender(string $sender): Sms
    {
        return match ($sender){
            'kavenegar' => new KavenegarSmsPanel(),
            default => throw new InvalidArgumentException('invalid sender'),
        };
    }
}
