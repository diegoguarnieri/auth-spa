<?php

namespace App\Apps\Adsb\BO;

use DateTime;
use DateInterval;
use App\Apps\Bean\IDB;
use App\Apps\Bean\ILogger;
use App\Apps\Factory\Factory;
use App\Models\Track;
use App\Models\Flight;

class AdsbBO {

    private $db;
    private $logger;

    public function __construct(IDB $db, ILogger $logger) {
        $this->db = $db;
        $this->logger = $logger;
        
    }

    public function store($request) {

        if(isset($request->data) && !is_null($request->data)) {
            $data = explode(',', $request->data);

            if($data[0] == 'MSG') {
                $icao = $data[4];
                $callsign = $data[10];
                $latitude = $data[14];
                $longitude = $data[15];
                $track = $data[13];
                $altitude = $data[11];
                $groundSpeed = $data[12];
                $verticalSpeed = $data[16];
                $squawk = $data[17];
                $date = str_replace('/','-',$data[6]);
                $time = $data[7];
                $timestamp = DateTime::createFromFormat('Y-m-d H:i:s.u', $date .' ' . $time);
                //$this->logger->info('-->',[$timestamp->format('Y-m-d H:i:s.u')]);

                if(
                    $callsign != '' || $latitude != '' ||
                    $longitude != '' || $track != '' ||
                    $altitude != '' || $groundSpeed != '' ||
                    $verticalSpeed != '' || $squawk != ''
                ) {
                    $fields = array(
                        'icao' => $icao,
                        'callsign' => $callsign,
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'track' => $track,
                        'altitude' => $altitude,
                        'groundSpeed' => $groundSpeed,
                        'verticalSpeed' => $verticalSpeed,
                        'squawk' => $squawk,
                        'timestamp' => $timestamp
                    );

                    $this->storeTrack($fields);
                }

            }
        }

    }

    public function storeTrack($fields) {

        //icao and (updatedAt >= now -10m or (updatedAt >= now -20h and callsign))
        $flight = Flight::query()
        ->where('icao', $fields['icao'])
        ->where(function ($query) use ($fields) {
            $query->where('updated_at', '>=', (new DateTime())->sub(new DateInterval('PT10M')))
            ->orWhere(function ($query) use ($fields) {
                $query->where('updated_at', '>=', (new DateTime())->sub(new DateInterval('PT20H')))
                ->where('callsign', $fields['callsign']);
            });
        })
        ->orderBy('updated_at', 'desc')
        ->first();

        if($flight) {
            if(!is_null($fields['callsign'])      && !empty($fields['callsign']) && is_null($flight->callsign)) $flight->callsign = $fields['callsign'];
            if(!is_null($fields['latitude'])      && !empty($fields['latitude']))      $flight->latitude = $fields['latitude'];
            if(!is_null($fields['longitude'])     && !empty($fields['longitude']))     $flight->longitude = $fields['longitude'];
            if(!is_null($fields['track'])         && !empty($fields['track']))         $flight->track = $fields['track'];
            if(!is_null($fields['altitude'])      && !empty($fields['altitude']))      $flight->altitude = $fields['altitude'];
            if(!is_null($fields['groundSpeed'])   && !empty($fields['groundSpeed']))   $flight->ground_speed = $fields['groundSpeed'];
            if(!is_null($fields['verticalSpeed']) && !empty($fields['verticalSpeed'])) $flight->vertical_speed = $fields['verticalSpeed'];
            if(!is_null($fields['squawk'])) $flight->squawk = $fields['squawk'];
            $flight->save();
        } else {
            $flight = new Flight();
            $flight->icao = $fields['icao'];
            $flight->callsign       = is_null($fields['callsign'])      || empty($fields['callsign'])      ? null : $fields['callsign'];
            $flight->latitude       = is_null($fields['latitude'])      || empty($fields['latitude'])      ? null : $fields['latitude'];
            $flight->longitude      = is_null($fields['longitude'])     || empty($fields['longitude'])     ? null : $fields['longitude'];
            $flight->track          = is_null($fields['track'])         || empty($fields['track'])         ? null : $fields['track'];
            $flight->altitude       = is_null($fields['altitude'])      || empty($fields['altitude'])      ? null : $fields['altitude'];
            $flight->ground_speed   = is_null($fields['groundSpeed'])   || empty($fields['groundSpeed'])   ? null : $fields['groundSpeed'];
            $flight->vertical_speed = is_null($fields['verticalSpeed']) || empty($fields['verticalSpeed']) ? null : $fields['verticalSpeed'];
            $flight->squawk = $fields['squawk'];
            $flight->timestamp = $fields['timestamp'];
            $flight->save();
        }

        $track = new Track();
        $track->flight_id = $flight->id;
        $track->icao = $fields['icao'];
        $track->callsign       = is_null($fields['callsign'])      || empty($fields['callsign'])      ? null : $fields['callsign'];
        $track->latitude       = is_null($fields['latitude'])      || empty($fields['latitude'])      ? null : $fields['latitude'];
        $track->longitude      = is_null($fields['longitude'])     || empty($fields['longitude'])     ? null : $fields['longitude'];
        $track->track          = is_null($fields['track'])         || empty($fields['track'])         ? null : $fields['track'];
        $track->altitude       = is_null($fields['altitude'])      || empty($fields['altitude'])      ? null : $fields['altitude'];
        $track->ground_speed   = is_null($fields['groundSpeed'])   || empty($fields['groundSpeed'])   ? null : $fields['groundSpeed'];
        $track->vertical_speed = is_null($fields['verticalSpeed']) || empty($fields['verticalSpeed']) ? null : $fields['verticalSpeed'];
        $track->squawk = $fields['squawk'];
        $track->timestamp = $fields['timestamp'];
        $track->save();
    }
}