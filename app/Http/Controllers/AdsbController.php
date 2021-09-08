<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Apps\Factory\Factory;

class AdsbController extends Controller {

    private $db;
    private $logger;

    public function __construct() {
        $this->db = Factory::create('Bean\\DB');
        $this->logger = Factory::create('Bean\\Logger');
    }

    public function store(Request $request) {
        
    }

    public function tracks(Request $request) {
        $adsbBO = Factory::create('Adsb\\BO\\AdsbBO', $this->db, $this->logger);
        $adsbBO->store($request);

        $response = array();
        return response()->json($response, 200);
    }

}
