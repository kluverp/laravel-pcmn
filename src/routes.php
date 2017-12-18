<?php

Route::prefix(config('pcmn.route_prefix'))->group(function () {

    // dashboard
    Route::get('/', 'Kluverp\Pcmn\DashboardController@index');

});
