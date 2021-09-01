<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {

    public function login(Request $request) {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return response()->json(['user' => Auth::user()]);
        }
    }

    public function test(Request $request) {
        Log::info('LoginController->test',[json_encode($request->all())]);

        $sessionKey = $request->session()->get('session_key');
        
        if(is_null($sessionKey)) {
            $sessionKey = md5(uniqid());
            $request->session()->put('session_key', $sessionKey);
        }

        $response = ['sessionKey' => $sessionKey];
        return response()->json($response, 200);
    }

}
