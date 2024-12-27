<?php

namespace App\Services\CodeService;

class VerifyCodeService
{
    private static $min = 10000 ;
    private static $max = 99999 ;
    public static function generate()
    {
        return rand(self::$min , self::$max);
    }
    public static function store($id , $code):void
    {
        cache()->set(
            'verification_code_'.$id , $code , now()->addMinutes(2)
        );
    }
    public static function get($id)
    {
        return cache()->get('verification_code_'.$id);
    }

    public static function delete($id)
    {
        return cache()->delete('verification_code_'.$id);
    }

    public static function getRule()
    {
        return  'required|numeric|between:'.self::$min . ',' . self::$max;
    }
    public static function check($code , $id):bool
    {
        if (self::get($id) != $code) return false;
        self::delete($id);
        return true;
    }
}
