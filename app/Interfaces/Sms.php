<?php

namespace App\Interfaces;

interface Sms
{
    public function sendCode(string $mobile ,string $code):void;
}
