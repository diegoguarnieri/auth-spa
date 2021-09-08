<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdsbController;

Route::post('login', [LoginController::class, 'login']);

//Route::get('test', [LoginController::class, 'test']);

Route::group(['middleware' => 'auth:sanctum'], function() {

    Route::get('test', [LoginController::class, 'test']);

});


Route::group(['middleware' => 'no.auth'], function() {

    Route::post('adsb', [AdsbController::class, 'store']);
    Route::post('tracks', [AdsbController::class, 'tracks']);

});