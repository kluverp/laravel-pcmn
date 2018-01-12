<?php

/**
 * Authentication
 */
Route::group([
    'prefix' => config('pcmn.config.route_prefix') . '/login',
    'as' => 'pcmn.auth.',
    'middleware' => 'web',
    'namespace' => 'Kluverp\Pcmn\Auth'
], function () {

    // login
    Route::get('/', 'LoginController@index')->name('login');
    Route::post('/', 'LoginController@post')->name('login');

    // password forgotten
    Route::get('/forgotten', 'ForgottenController@index')->name('forgotten');
    Route::post('/forgotten', 'ForgottenController@post')->name('forgotten');

    // reset
    Route::get('/reset/{token}', 'ResetController@index')->name('reset');
    Route::post('/reset/{token}', 'ResetController@post')->name('reset');
});

/**
 * Application
 */
Route::group([
    'prefix' => config('pcmn.config.route_prefix'),
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

    // datatable
    Route::get('datatable/{table}', 'DatatableController@index')->name('datatable.index');

    // settings

    // profile

    // logout
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

});
