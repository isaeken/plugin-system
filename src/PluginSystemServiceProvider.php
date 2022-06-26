<?php

namespace IsaEken\PluginSystem;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use IsaEken\PluginSystem\Collections\PluginCollection;

class PluginSystemServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $pluginSystem = new PluginSystem();

        $pluginSystem->setFilesystem(Storage::build(config('plugins.filesystem', [
            'driver' => 'local',
            'root' => base_path('plugins'),
        ])));
        $pluginSystem->setNamespace(config('plugins.namespace', ''));
        $pluginSystem->setPlugins(new PluginCollection());
        $pluginSystem->setLogger(Log::channel('single'));
        $pluginSystem->load(config('plugins.directory'));
        $this->app->singleton('plugins', $pluginSystem);

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
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/plugins.php', 'plugins');
    }
}
