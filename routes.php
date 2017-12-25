<?php

Route::prefix(config('pcmn.route_prefix'))
    ->middleware('pcmn')
    ->namespace('Kluverp\Pcmn')
    ->group(function () {

    // dashboard
    Route::get('/', 'DashboardController@index');
});
