<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:api'], function () {
    Route::prefix('ship')->group(function () {
        Route::get('/', 'ShipController@get');
        Route::post('/', 'ShipController@store');
        Route::delete('/{shipId}', 'ShipController@destroy');
    });

    Route::prefix('sender')->group(function () {
        Route::get('/', 'SenderController@get');
        Route::post('/', 'SenderController@store');
        Route::delete('/{shipId}', 'SenderController@destroy');
    });

    Route::prefix('recipient')->group(function () {
        Route::get('/', 'RecipientController@get');
        Route::post('/', 'RecipientController@store');
        Route::delete('/{shipId}', 'RecipientController@destroy');
    });

    Route::prefix('bapb')->group(function () {
        Route::get('/', 'BapbController@get');
        Route::post('/', 'BapbController@store');
    });
});
