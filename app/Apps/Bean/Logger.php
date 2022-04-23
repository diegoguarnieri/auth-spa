<?php

namespace App\Apps\Bean;

use Illuminate\Support\Facades\Log;

class Logger implements ILogger {

    public function __construct() {
        
    }

    public function info($message, $fields = []) {
        Log::info($message, $this->getParameters($fields));
    }

    public function error($message, $fields = []) {
        Log::error($message, $this->getParameters($fields));
    }

    public function debug($message, $fields = []) {
        Log::debug($message, $this->getParameters($fields));
    }

    public function warning($message, $fields = []) {
        Log::warning($message, $this->getParameters($fields));
    }

    public function getParameters($fields) {
        return [
            'session_key' => $this->getSessionKey(),
            'data' => $fields
        ];
    }

    private function getSessionKey() {
        if(session('session_key') === null || session('session_key') == '') {
            $sessionKey = substr(sha1(uniqid()),0,8);
            session(['session_key' => $sessionKey]);
        } else {
            $sessionKey = session('session_key');
        }

        return $sessionKey;
    }
}
