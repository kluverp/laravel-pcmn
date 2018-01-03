<?php

Route::group([
    'prefix' => config('pcmn.route_prefix') . '/login',
    'as' => 'pcmn.',
    'middleware' => 'web',
    'namespace' => 'Kluverp\Pcmn'
], function () {

    // login
    Route::get('/', 'LoginController@index')->name('login');
    Route::post('/', 'LoginController@post')->name('login');

    // password forgotten
    Route::get('/forgotten', 'LoginController@forgotten')->name('login.forgotten');
    Route::post('/forgotten', 'LoginController@postForgotten')->name('login.forgotten');
});


Route::group([
    'prefix' => config('pcmn.route_prefix'),
    'as' => 'pcmn.',
    'middleware' => 'pcmn',
    'namespace' => 'Kluverp\Pcmn'
], function () {

    // dashboard
    Route::get('/', 'Kluverp\Pcmn\DashboardController@index')->name('dashboard');
});
