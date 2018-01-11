<?php

/**
 * Authentication
 */
Route::group([
    'prefix' => config('pcmn.route_prefix') . '/login',
    'as' => 'pcmn.',
    'middleware' => 'web',
    'namespace' => 'Kluverp\Pcmn'
], function () {

    // login
    Route::get('/', 'Auth\LoginController@index')->name('login');
    Route::post('/', 'Auth\LoginController@post')->name('login');

    // password forgotten
    Route::get('/forgotten', 'Auth\ForgottenController@index')->name('login.forgotten');
    Route::post('/forgotten', 'Auth\ForgottenController@post')->name('login.forgotten');

    // reset
    Route::get('/reset/{token}', 'Auth\ResetController@index')->name('login.reset');
    Route::post('/reset/{token}', 'Auth\ResetController@post')->name('login.reset');
});

/**
 * Application
 */
Route::group([
    'prefix' => config('pcmn.route_prefix'),
    'as' => 'pcmn.',
    'middleware' => ['web', 'pcmn'],
    'namespace' => 'Kluverp\Pcmn'
], function () {

    // dashboard
    Route::get('/', 'DashboardController@index')->name('dashboard');

    // entity list
    Route::get('content/{table}', 'ContentController@index')->name('content.index');
    Route::get('content/{table}/create', 'ContentController@create')->name('content.create');
    Route::post('content/{table}', 'ContentController@store')->name('content.store');

    // settings

    // profile

    // logout
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

});
