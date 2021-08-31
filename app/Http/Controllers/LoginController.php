<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller {
    
    public function login(Request $request) {
        $sessionKey = md5(uniqid());
        $request->session()->put('session_key', $sessionKey);

        $response = array('login - sessionKey' => $sessionKey);
        return response()->json($response, 200);
    }

    public function test(Request $request) {
        $sessionKey = $request->session()->get('session_key');

        $response = array('test - sessionKey' => $sessionKey);
        return response()->json($response, 200);
    }

}
