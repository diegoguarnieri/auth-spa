<?php

namespace App\Http\Controllers;

use App\Apps\Factory\Factory;
use App\Models\PowerMeter;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller {

    private $db;
    private $logger;

    public function __construct() {
        $this->db = Factory::create('Bean\\DB');
        $this->logger = Factory::create('Bean\\Logger');
    }

    public function lead(Request $request) {
        $this->logger->info('TestController->lead',['fields' => json_encode($request->all())]);

        $response = ['status' => 'success', 'message' => ''];
        return response()->json($response, 200);
    }

    public function powerMeter(Request $request) {
        $this->logger->debug('TestController->powerMeter',[json_encode($request->all())]);

        $powerMeter = new PowerMeter();
        $powerMeter->power_a = $request->pa < 0 ? $request->pa * -1 : $request->pa;
        $powerMeter->power_b = $request->pb < 0 ? $request->pb * -1 : $request->pb;
        $powerMeter->power_c = $request->pc < 0 ? $request->pc * -1 : $request->pc;
        $powerMeter->voltage_a = $request->uarms;
        $powerMeter->voltage_b = $request->ubrms;
        $powerMeter->voltage_c = $request->ucrms;
        $powerMeter->current_a = $request->iarms;
        $powerMeter->current_b = $request->ibrms;
        $powerMeter->current_c = $request->icrms;
        $powerMeter->save();

        $this->logger->info('TestController->powerMeter - New record created',[$powerMeter->id]);

        $response = ['status' => 'success', 'message' => ''];
        return response()->json($response, 200);
    }

}
