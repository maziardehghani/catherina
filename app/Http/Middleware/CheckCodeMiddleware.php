<?php

namespace App\Http\Middleware;

use App\Services\CodeService\VerifyCodeService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCodeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!VerifyCodeService::check($request->code , $request->mobile))
        {
            return response()->error('کد تایید نا معتبر');
        }
        return $next($request);
    }
}
