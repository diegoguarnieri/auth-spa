<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime;

class LoginController extends Controller {

    public function login(Request $request) {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $response = ['status' => 'success', 'message' => ''];
            return response()->json($response, 200);
        }
    }

    public function logout(Request $request) {
        $request->session()->invalidate();
        $request->session()->regenerate();

        $response = ['status' => 'success', 'message' => ''];
        return response()->json($response, 200);
    }

    public function sessionKey(Request $request) {
        Log::info('LoginController->sessionKey',[json_encode($request->all())]);

        $sessionKey = $request->session()->get('session_key');
        
        if(is_null($sessionKey)) {
            $sessionKey = md5(uniqid());
            $request->session()->put('session_key', $sessionKey);
        }

        $response = [
            'status' => 'success',
            'message' => '',
            'sessionKey' => $sessionKey,
            'uuid' => uniqid(),
            'timestamp' => (new DateTime())->format('Y-m-d H:i:s')
        ];
        return response()->json($response, 200);
    }

}
