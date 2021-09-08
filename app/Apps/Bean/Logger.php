<?php

namespace App\Apps\Bean;

use Illuminate\Support\Facades\Log;

class Logger implements ILogger {

    public function __construct() {
        
    }

    public function info($message, $fields = []) {
        Log::info($this->getSessionKey() . ' ' . $message, $fields);
    }

    public function error($message, $fields = []) {
        Log::error($this->getSessionKey() . ' ' . $message, $fields);
    }

    public function debug($message, $fields = []) {
        Log::debug($this->getSessionKey() . ' ' . $message, $fields);
    }

    public function warning($message, $fields = []) {
        Log::warning($this->getSessionKey() . ' ' . $message, $fields);
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
