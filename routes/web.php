<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('backend', function () {
    return view('default');
});

Route::get('login', function () {
    return view('login.login');
});

Route::middleware('auth:api')->group(function () {
    Route::get('admin', function () {
        return view('layout.admin');
    });


    Route::prefix('ship')->group(function () {
        Route::get('/', function () {
            return view('ship.ship');
        });
        Route::get('/add', function () {
            return view('ship.shipAdd');
        });
        Route::get('/edit', function () {
            return view('ship.shipEdit');
        });
    });


    Route::prefix('home')->group(function () {
        Route::get('dashboard', function () {
            return view('home.dashboard');
        });
    });

    Route::prefix('recipient')->group(function () {
        Route::get('/', function () {
            return view('recipient.recipient');
        });
        Route::get('/add', function () {
            return view('recipient.recipientAdd');
        });
        Route::get('/edit', function () {
            return view('recipient.recipientEdit');
        });
    });
});
