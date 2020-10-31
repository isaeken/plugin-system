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
     * Load all plugins in a directory
     *
     * @param string|null $directory
     * @return $this
     */
    public function autoload(?string $directory = null)
    {
        if ($directory != null) $this->directory = $directory;

        // all all files in directory
        foreach (scandir($this->directory) as $plugin)
            // check file is a php file
            if (Str::endsWith($plugin, '.php'))
            {
                $filename = realpath($this->directory.DIRECTORY_SEPARATOR.$plugin);

                // load plugin from filename
                $plugin = $this->load($filename);

                // set plugin variables
                $plugin->filename = $filename;
                $plugin->enabled = $plugin->isEnabled();

                // add plugin to memory
                $this->add($plugin);
            }

        // return $this for chained functions
        return $this;
    }
}