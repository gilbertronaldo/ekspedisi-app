<?php

use Illuminate\Support\Facades\Route;

Route::group(
  [],
  function ()
  {

      Route::prefix('my')->group(
        function ()
        {
            Route::get('/init', 'UserController@init');
        }
      );

      Route::prefix('home')->group(
        function ()
        {
            Route::get('/header', 'DashboardController@header');
        }
      );

      Route::prefix('user')->group(
        function ()
        {
            Route::get('/', 'UserController@all');
            Route::post('/', 'UserController@save');
            Route::post('/change-password', 'UserController@changePassword');
            Route::get('/{id}', 'UserController@get')->where('id', '[0-9]+');
            Route::get('/{id}/roles', 'UserController@roles')->where(
              'id',
              '[0-9]+'
            );
            Route::post('/{id}/roles', 'UserController@saveRoles')->where(
              'id',
              '[0-9]+'
            );
            Route::delete('/{id}', 'UserController@destroy')->where(
              'id',
              '[0-9]+'
            );
        }
      );

      Route::prefix('role')->group(
        function ()
        {
            Route::get('/', 'RoleController@all');
            Route::post('/', 'RoleController@save');
            Route::get('/{id}', 'RoleController@get')->where('id', '[0-9]+');
            Route::get('/{id}/tasks', 'RoleController@tasks')->where(
              'id',
              '[0-9]+'
            );
            Route::post('/{id}/tasks', 'RoleController@saveTasks')->where(
              'id',
              '[0-9]+'
            );
            Route::delete('/{id}', 'RoleController@destroy')->where(
              'id',
              '[0-9]+'
            );
        }
      );


      Route::prefix('master')->group(
        function ()
        {
            Route::get('/city', 'MasterController@cityList');
            Route::get('/country', 'MasterController@countryList');
        }
      );

      Route::prefix('ship')->group(
        function ()
        {
            Route::get('/', 'ShipController@all');
            Route::get('/search', 'ShipController@search');
            Route::get('/{id}', 'ShipController@get')->where('id', '[0-9]+');
            Route::post('/', 'ShipController@store');
            Route::post('/containers', 'ShipController@searchContainer');
            Route::delete('/{id}', 'ShipController@destroy')->where(
              'id',
              '[0-9]+'
            );
            Route::get('/export/{id}', 'ShipController@exportExcelLangsungTagih');
        }
      );

      Route::prefix('sender')->group(
        function ()
        {
            Route::get('/', 'SenderController@all');
            Route::get('/search', 'SenderController@search');
            Route::get('/{id}', 'SenderController@get')->where('id', '[0-9]+');
            Route::post('/', 'SenderController@store');
            Route::delete('/{id}', 'SenderController@destroy')->where(
              'id',
              '[0-9]+'
            );
        }
      );

      Route::prefix('recipient')->group(
        function ()
        {
            Route::get('/', 'RecipientController@all');
            Route::get('/search', 'RecipientController@search');
            Route::get('/{id}', 'RecipientController@get')->where(
              'id',
              '[0-9]+'
            );
            Route::post('/', 'RecipientController@store');
            Route::delete('/{id}', 'RecipientController@destroy')->where(
              'id',
              '[0-9]+'
            );
        }
      );

      Route::prefix('bapb')->group(
        function ()
        {
            Route::get('/next', 'BapbController@nextId');
            Route::get('/no/{code}', 'BapbController@no');
            Route::get('/', 'BapbController@all');
            Route::get('/{id}', 'BapbController@get')->where('id', '[0-9]+');
            Route::post('/', 'BapbController@store');
            Route::get('/latest/{code?}', 'BapbController@latestBapb');
            Route::delete('/{id}', 'BapbController@destroy')->where(
              'id',
              '[0-9]+'
            );
            Route::post('/verify/{id}', 'BapbController@verify')->where(
              'id',
              '[0-9]+'
            );
            Route::post('/payment-list', 'BapbController@paymentList');
            Route::post('/payment-save', 'BapbController@paymentSave');

            Route::get('/generate/{id}', 'BapbController@generatePrint')->where(
              'id',
              '[0-9]+'
            );
            Route::get('/export/{noContainer}', 'BapbController@exportExcel');
        }
      );

      Route::prefix('invoice')->group(
        function ()
        {
            Route::get('/next', 'InvoiceController@nextId');
            Route::post('/bapb-list', 'InvoiceController@bapbList');
            Route::get('/no', 'InvoiceController@no');
            Route::post('/', 'InvoiceController@store');
            Route::get('/', 'InvoiceController@all');
            Route::get(
              '/generate/{invoiceId}',
              'InvoiceController@generatePrint'
            );
            Route::get(
              '/kwitansi/{invoiceId}',
              'InvoiceController@generateKwitansi'
            );
            Route::delete('/{id}', 'InvoiceController@destroy')->where(
              'id',
              '[0-9]+'
            );
        }
      );


      Route::get('/container', 'BapbController@container');
      Route::get('/ppn', 'BapbController@ppn');
  }
);
