<?php

namespace Kluverp\Pcmn\Providers;

use Illuminate\Support\ServiceProvider;
use Kluverp\Pcmn\Commands\TableConfig;
use Kluverp\Pcmn\Lib\TableConfig\TableConfigRepository;

class PcmnServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $srcPath = realpath(__DIR__ . '/../');

        // publish the config file and assets
        $this->publishes([
            $srcPath . '/config'  => config_path('pcmn'),
            $srcPath . '/Assets/' => public_path('vendor/pcmn'),
        ], 'public');

        // load the routes
        $this->loadRoutesFrom($srcPath . '/routes.php');

        // load the migrations
        $this->loadMigrationsFrom($srcPath . '/Migrations');

        // load views
        $this->loadViewsFrom($srcPath . '/Views', 'pcmn');

        // load translations
        $this->loadTranslationsFrom($srcPath . '/Translations', 'pcmn');

        // load commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                TableConfig::class,
            ]);
        }

        // create a table config repository instance
        $this->app->singleton(TableConfigRepository::class, function ($app) {
            return new TableConfigRepository();
        });
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
            __DIR__ . '/../config/config.php', 'pcmn/config'
        );
    }
}
