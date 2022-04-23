<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class NoAuth {

    public function handle($request, Closure $next) {
        $sessionKey = substr(sha1(uniqid()),0,8);
        session(['session_key' => $sessionKey]);

        Log::info('NoAuth->handle', [
            'session_key' => $sessionKey,
            'source_ip' => $request->ip(),
            'source_country' => $request->header('CF-IPCountry'),
            'http_method' => $request->method(),
            'path' => $request->path(),
            'fields' => json_encode($request->all())
        ]);

        return $next($request);
    }

}