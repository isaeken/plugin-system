<?php
/**
 * Plugin System
 * @version v1.0
 * @author İsa Eken
 * @license MIT
 */

namespace IsaEken\PluginSystem\Traits;

use IsaEken\PluginSystem\Helpers\Str;
use IsaEken\PluginSystem\Plugin;

/**
 * Trait PluginsTrait
 *
 * @property $enabledPlugins
 * @property $disabledPlugins
 * @package IsaEken\PluginSystem\Traits
 */
trait PluginsTrait
{
    /**
     * Plugins directory
     *
     * @var string $directory
     */
    public string $directory;

    /**
     * Plugins
     *
     * @var array $plugins
     */
    public array $plugins = [];

    /**
     * Plugins constructor.
     * @param string|null $directory
     * @param array|null $plugins
     */
    public function __construct(?string $directory = null, ?array $plugins = null)
    {
        if ($directory != null) $this->directory = $directory;
        if ($plugins != null) $this->plugins = $plugins;
    }

    /**
     * Add plugin to memory
     *
     * @param Plugin $plugin
     * @return $this
     */
    public function add(Plugin $plugin)
    {
        array_push($this->plugins, $plugin);
        return $this;
    }

    /**
     * Remove plugin from memory
     *
     * @param Plugin $plugin
     * @return $this
     */
    public function remove(Plugin $plugin)
    {
        $this->plugins = array_filter($this->plugins, function (Plugin $_plugin) use ($plugin) {
            return $_plugin != $plugin;
        });
        return $this;
    }

    /**
     * @param $name
     * @return array
     */
    public function __get($name)
    {
        if ($name === 'enabledPlugins' || $name === 'disabledPlugins') {
            $enabledPlugins = [];
            $disabledPlugins = [];

            foreach ($this->plugins as $plugin) {
                if ($plugin->isEnabled()) {
                    array_push($enabledPlugins, $plugin);
                }
                else {
                    array_push($disabledPlugins, $plugin);
                }
            }

            if ($name === 'disabledPlugins') {
                return $disabledPlugins;
            }

            return $enabledPlugins;
        }
        return $this->$name;
    }

    /**
     * Load all plugins in a directory
     *
     * @param string|null $directory
     * @param bool $nested
     * @return $this
     */
    public function autoload(?string $directory = null, bool $nested = true)
    {
        if ($directory != null) $this->directory = $directory;

        // load plugins
        $this->autoloadDirectory($this->directory, $nested, '');

        // return $this for chained functions
        return $this;
    }

    public function autoloadDirectory(string $directory, bool $nested = true, string $prefix = '')
    {
        foreach (scandir($directory) as $path) {
            if ($path == '.' || $path == '..') {
                continue;
            }

            $path = implode(DIRECTORY_SEPARATOR, [$directory, $path]);

            if (is_file($path)) {
                $this->autoloadPlugin($path);
            }
            else if (is_dir($path)) {
                $prefix = $prefix.Str::afterLast($path, DIRECTORY_SEPARATOR);
                $this->autoloadDirectory($path, $nested, $prefix);
            }
        }
    }

    private function autoloadPlugin(string $plugin)
    {
        // check file is a php file
        if (Str::endsWith($plugin, '.php'))
        {
            $filename = $plugin;

            // load plugin from filename
            $plugin = $this->load($filename);

            // set plugin variables
            $plugin->filename = $filename;
            $plugin->enabled = $plugin->isEnabled();

            // add plugin to memory
            $this->add($plugin);
        }
    }
}