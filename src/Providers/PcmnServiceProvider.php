<?php

namespace Kluverp\Pcmn\Providers;

use Illuminate\Support\ServiceProvider;

class PcmnServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // publish the config file and assets
        $this->publishes([
            __DIR__ . '/../config.php' => config_path('pcmn.php'),
            __DIR__ . '/../Assets/' => public_path('vendor/pcmn'),
        ], 'public');

        // load the routes
        $this->loadRoutesFrom(__DIR__ . '/../routes.php');

        // load the migrations
        $this->loadMigrationsFrom(__DIR__ . '/../Migrations');

        // load views
        $this->loadViewsFrom(__DIR__ . '/../Views', 'pcmn');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // merge the default config with published one
        $this->mergeConfigFrom(
            __DIR__ . '/../config.php', 'pcmn'
        );
    }
}
