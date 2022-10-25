<?php

namespace Arubacao\AssetCdn;

use Illuminate\Support\ServiceProvider;
use Arubacao\AssetCdn\Commands\PushCommand;

class AssetCdnServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/asset-cdn.php' => config_path('asset-cdn.php'),
        ], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/asset-cdn.php', 'asset-cdn');

        $this->app->singleton(Finder::class, function ($app) {
            return new Finder(new Config($app->make('config'), $app->make('path.public')));
        });

        $this->commands(PushCommand::class);
    }
}
