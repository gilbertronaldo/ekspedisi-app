<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:api'], function () {
    Route::prefix('ship')->group(function () {
        Route::get('/', 'ShipController@get');
        Route::post('/', 'ShipController@store');
    });
});
