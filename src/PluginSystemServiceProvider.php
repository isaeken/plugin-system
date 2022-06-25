<?php

namespace IsaEken\PluginSystem;

use Illuminate\Support\ServiceProvider;

class PluginSystemServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('plugins', function ($app) {
            if (! is_dir(config('plugins.directory'))) {
                mkdir(config('plugins.directory'));
            }

            return (new PluginSystem(config('plugins.directory')))->autoload(
                null,
                config('plugins.nested'),
                config('plugins.folders'),
            );
        });

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/plugins.php' => config_path('plugins.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/plugins.php', 'plugins');
    }
}
