<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdsbController;
use App\Http\Controllers\TestController;

/**
 * No Auth
 */
Route::group(['middleware' => 'no.auth'], function() {
    Route::post('login', [LoginController::class, 'login']);

    Route::post('adsb', [AdsbController::class, 'store']);
    Route::post('tracks', [AdsbController::class, 'tracks']);

    Route::get('lead', [TestController::class, 'lead']);
    Route::post('power-meter', [TestController::class, 'powerMeter']);
});

/**
 * Sanctum
 */
Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::get('logout', [LoginController::class, 'logout']);

    Route::get('session-key', [LoginController::class, 'sessionKey']);
});
