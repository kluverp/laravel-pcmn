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

    // content
    Route::get('content/{table}', 'ContentController@index')->name('content.index');
    Route::get('content/{table}/create/{parent_id?}/{parent_table?}', 'ContentController@create')->name('content.create');
    Route::post('content/{table}/{parent_id?}/{parent_table?}', 'ContentController@store')->name('content.store');
    Route::get('content/{table}/{id}', 'ContentController@show')->name('content.show');
    Route::get('content/{table}/{id}/edit/{parent_id?}/{parent_table?}', 'ContentController@edit')->name('content.edit');
    Route::put('content/{table}/{id}/edit', 'ContentController@update')->name('content.update');
    Route::delete('content/{table}/{id}/destroy', 'ContentController@destroy')->name('content.destroy');

    // datatable
    Route::get('datatable/{table}/{parent_id?}/{parent_table?}', 'DatatableController@index')->name('datatable.index');

    // settings

    // profile

    // logout
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

});
