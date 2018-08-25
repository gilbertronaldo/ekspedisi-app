<?php

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login')->name('login');
    Route::get('logout', 'AuthController@logout')->name('logout');
    Route::get('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
});

Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('site', 'SettingController@siteInfo');

    Route::get('home', 'HomeController@home');
});
