<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogPaymentRequests
{
    public function handle(Request $request, Closure $next)
    {
        Log::info('Payment request received', [
            'url' => $request->fullUrl(),
            'params' => $request->all(),
            'ip' => $request->ip()
        ]);
        
        return $next($request);
    }
}