<?php


namespace IsaEken\PluginSystem\Traits;


use IsaEken\PluginSystem\Helpers\Str;
use IsaEken\PluginSystem\Plugin;
use IsaEken\PluginSystem\PluginSystem;

trait PluginsTrait
{
    /**
     * @var string $directory
     */
    public string $directory;

    /**
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
     * @param Plugin $plugin
     * @return $this
     */
    public function add(Plugin $plugin)
    {
        array_push($this->plugins, $plugin);
        return $this;
    }

    /**
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
     * @param string|null $directory
     * @return $this
     */
    public function autoload(?string $directory = null)
    {
        if ($directory != null) $this->directory = $directory;
        foreach (scandir($this->directory) as $plugin)
            if (Str::endsWith($plugin, '.php'))
            {
                $filename = realpath($this->directory.DIRECTORY_SEPARATOR.$plugin);
                $plugin = $this->load($filename);
                $plugin->filename = $filename;
                $plugin->enabled = $plugin->isEnabled();
                $this->add($plugin);
            }
        return $this;
    }
}