<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class NoAuth {

    public function handle($request, Closure $next) {
        $sessionKey = substr(sha1(uniqid()),0,8);
        session(['session_key' => $sessionKey]);

        Log::info($sessionKey . ' NoAuth->handle', [$request->ip(), $request->header('CF-IPCountry'), $request->method(), $request->path(), json_encode($request->all())]);

        return $next($request);
    }

}