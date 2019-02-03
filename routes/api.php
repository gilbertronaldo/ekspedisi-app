<?php

use Illuminate\Support\Facades\Route;

Route::group([], function () {
    Route::prefix('master')->group(function () {
        Route::get('/city', 'MasterController@cityList');
        Route::get('/country', 'MasterController@countryList');
    });

    Route::prefix('ship')->group(function () {
        Route::get('/', 'ShipController@all');
        Route::get('/search', 'ShipController@search');
        Route::get('/{id}', 'ShipController@get')->where('id', '[0-9]+');
        Route::post('/', 'ShipController@store');
        Route::delete('/{id}', 'ShipController@destroy')->where('id', '[0-9]+');
    });

    Route::prefix('sender')->group(function () {
        Route::get('/', 'SenderController@all');
        Route::get('/search', 'SenderController@search');
        Route::get('/{id}', 'SenderController@get')->where('id', '[0-9]+');
        Route::post('/', 'SenderController@store');
        Route::delete('/{id}', 'SenderController@destroy')->where('id', '[0-9]+');
    });

    Route::prefix('recipient')->group(function () {
        Route::get('/', 'RecipientController@all');
        Route::get('/search', 'RecipientController@search');
        Route::get('/{id}', 'RecipientController@get')->where('id', '[0-9]+');
        Route::post('/', 'RecipientController@store');
        Route::delete('/{id}', 'RecipientController@destroy')->where('id', '[0-9]+');
    });

    Route::prefix('bapb')->group(function () {
        Route::get('/no/{code}', 'BapbController@no');
        Route::get('/', 'BapbController@all');
        Route::get('/{id}', 'BapbController@get')->where('id', '[0-9]+');
        Route::post('/', 'BapbController@store');
        Route::get('/latest/{code?}', 'BapbController@latestBapb');
        Route::delete('/{id}', 'BapbController@destroy')->where('id', '[0-9]+');

        Route::get('/generate/{id}', 'BapbController@generatePrint')->where('id', '[0-9]+');
        Route::get('/export/{noContainer}', 'BapbController@exportExcel');
    });

    Route::prefix('invoice')->group(function () {
        Route::post('/bapb-list', 'InvoiceController@bapbList');
        Route::get('/no', 'InvoiceController@no');
        Route::post('/', 'InvoiceController@store');
        Route::get('/generate/{invoiceId}', 'InvoiceController@generatePrint');
    });


    Route::get('/container', 'BapbController@container');
});
