<?php
/**
 * Plugin System
 * @version v1.0
 * @author İsa Eken
 * @license MIT
 */

namespace IsaEken\PluginSystem;

use IsaEken\PluginSystem\Helpers\Str;
use IsaEken\PluginSystem\Traits\PluginsExecuteTrait;
use IsaEken\PluginSystem\Traits\PluginsManager;
use IsaEken\PluginSystem\Traits\PluginsTrait;

/**
 * Class PluginSystem
 * @package IsaEken\PluginSystem
 */
class PluginSystem
{
    use PluginsTrait;
    use PluginsExecuteTrait;
    use PluginsManager;

    /**
     * Load a plugin file
     *
     * @param string $pluginPath
     * @param mixed ...$attributes
     * @return Plugin
     */
    public function load(string $pluginPath, ...$attributes) : Plugin
    {
        // include once plugin file with return
        $classname = include_once $pluginPath;

        // if class name is not string then sets as filename
        if (!(is_string($classname) && strlen($classname) > 0)) $classname = pathinfo($pluginPath)['filename'];

        // if extension is disabled extension then remove disabled parameter in filename
        if (Str::endsWith($pluginPath, '.disabled.php')) $classname = explode('.', $classname)[0];

        // return plugin as class
        return new $classname($attributes);
    }
}