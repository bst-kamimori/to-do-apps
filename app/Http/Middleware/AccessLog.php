<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

// グローバルで誰がどのページにアクセスしたのか
class AccessLog
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $userId = auth()->check() ? auth()->id() : 'guest';
        $method = $request->method();
        $url = $request->fullUrl();
        $ip = $request->ip();
        $time = now()->format('Y-m-d H:i:s');

        Log::info("[{$time}] user_id: {$userId} | {$method} {$url} | IP: {$ip}");

        return $next($request);
    }
}
