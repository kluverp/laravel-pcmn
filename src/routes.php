<?php

Route::group([
    'prefix' => config('pcmn.route_prefix') . '/login',
    'as' => 'pcmn.',
    'middleware' => 'web'
], function () {

    // login
    Route::get('/', 'Kluverp\Pcmn\LoginController@index')->name('login');
    Route::post('/', 'Kluverp\Pcmn\LoginController@post')->name('login');
});


Route::group([
    'prefix' => config('pcmn.route_prefix'),
    'as' => 'pcmn.',
    'middleware' => 'pcmn'
], function () {

    // dashboard
    Route::get('/', 'Kluverp\Pcmn\DashboardController@index')->name('dashboard');
});
