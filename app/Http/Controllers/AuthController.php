<?php

namespace App\Http\Controllers;

use App\Events\VerificationEvent;
use App\Http\Requests\AuthRequest;
use App\Repositories\User\UserRepository;
use App\Services\CodeService\VerifyCodeService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public object $userRepo;
    public function __construct()
    {
        $this->userRepo = new UserRepository();
    }
    public function sendCode(AuthRequest $request): JsonResponse
    {
        if(VerifyCodeService::get($request->mobile))
        {
            return response()->error( 'ما قبلا یک کد تایید برای شما فرستاده ایم', Response::HTTP_METHOD_NOT_ALLOWED);
        }

        event(new VerificationEvent($request->mobile));

        return response()->success(VerifyCodeService::get($request->mobile), " پیام حاوی کد یکبار مصرف به شماره تلفن " . $request->mobile . " فرستاده شد ");
    }

    public function verifyCode(AuthRequest $request)
    {
        $user = $this->userRepo->getByMobile($request->mobile);

        if ($user)
        {
            $token = $user->createToken($user->name)->plainTextToken;
            return response()->success(['token' => $token], 'کاربر با موفقیت وارد شد');
        }

        if (!$user){
            //register
            //// wait for frontend developer to discuss about it
        }


    }
}
