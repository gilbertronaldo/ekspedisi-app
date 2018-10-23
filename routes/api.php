<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:api'], function () {
    Route::prefix('master')->group(function () {
        Route::get('/city', 'MasterController@cityList');
        Route::get('/country', 'MasterController@countryList');
    });

    Route::prefix('ship')->group(function () {
        Route::get('/', 'ShipController@all');
        Route::get('/search', 'ShipController@search');
        Route::get('/{id}', 'ShipController@get');
        Route::post('/', 'ShipController@store');
        Route::delete('/{id}', 'ShipController@destroy');
    });

    Route::prefix('sender')->group(function () {
        Route::get('/', 'SenderController@all');
        Route::get('/search', 'SenderController@search');
        Route::get('/{id}', 'SenderController@get');
        Route::post('/', 'SenderController@store');
        Route::delete('/{id}', 'SenderController@destroy');
    });

    Route::prefix('recipient')->group(function () {
        Route::get('/', 'RecipientController@all');
        Route::get('/search', 'RecipientController@search');
        Route::get('/{id}', 'RecipientController@get');
        Route::post('/', 'RecipientController@store');
        Route::delete('/{id}', 'RecipientController@destroy');
    });

    Route::prefix('bapb')->group(function () {
        Route::get('/no/{code}', 'BapbController@no');
        Route::get('/', 'BapbController@all');
        Route::get('/{id}', 'BapbController@get');
        Route::post('/', 'BapbController@store');
        Route::delete('/{id}', 'BapbController@destroy');

        Route::get('/generate/{id}', 'BapbController@generatePrint');
    });
});
