<?php

namespace App\Http\Middleware;

use Closure;

class ApiAuth
{
    public function handle($request, Closure $next)
    {
        if ($request->token != 'muyao') {
            return response()->json(['code'=>419,'msg'=>'不安全的访问'],419,array(),JSON_UNESCAPED_UNICODE);
        }

        return $next($request);
    }
}
