<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller {

    public function lead(Request $request) {
        Log::info('TestController->lead',[json_encode($request->all())]);

        $response = ['status' => 'success', 'message' => ''];
        return response()->json($response, 200);
    }

}
