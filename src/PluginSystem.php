<?php


namespace IsaEken\PluginSystem;



use IsaEken\PluginSystem\Helpers\Str;
use IsaEken\PluginSystem\Traits\PluginsExecuteTrait;
use IsaEken\PluginSystem\Traits\PluginsManager;
use IsaEken\PluginSystem\Traits\PluginsTrait;

class PluginSystem
{
    use PluginsTrait;
    use PluginsExecuteTrait;
    use PluginsManager;

    /**
     * @param string $pluginPath
     * @param mixed ...$attributes
     * @return Plugin
     */
    public function load(string $pluginPath, ...$attributes) : Plugin
    {
        $classname = include_once $pluginPath;
        if (!(is_string($classname) && strlen($classname) > 0)) $classname = pathinfo($pluginPath)['filename'];
        if (Str::endsWith($pluginPath, '.disabled.php')) $classname = explode('.', $classname)[0];
        return new $classname($attributes);
    }
}