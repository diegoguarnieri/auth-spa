<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::group(['middleware' => 'auth:sanctum'], function() {

    Route::post('login', [LoginController::class, 'login']);
    Route::get('test', [LoginController::class, 'test']);

});
