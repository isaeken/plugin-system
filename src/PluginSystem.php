<?php


namespace IsaEken\PluginSystem;


use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use InvalidArgumentException;
use IsaEken\PluginSystem\Exceptions\PluginNotFoundException;
use IsaEken\PluginSystem\Interfaces\PluginInterface;

/**
 * Class PluginSystem
 *
 * @package IsaEken\PluginSystem
 * @property Collection $plugins
 * @property Collection $enabledPlugins
 * @property Collection $disabledPlugins
 */
class PluginSystem
{
    /**
     * Plugins memory cache.
     *
     * @var Collection $plugins
     */
    private Collection $plugins;

    /**
     * Static plugin system.
     *
     * @var PluginSystem $system
     */
    private static PluginSystem $system;

    /**
     * Find plugin in loaded plugins.
     *
     * @param PluginInterface|string $plugin
     * @return PluginInterface
     * @throws PluginNotFoundException
     */
    private function findPlugin(PluginInterface|string $plugin): PluginInterface
    {
        if ($plugin instanceof PluginInterface) {
            return $plugin;
        }

        if ($this->plugins->has($plugin)) {
            return $this->plugins->get($plugin);
        }

        throw new PluginNotFoundException;
    }

    /**
     * @return static
     */
    public function makeStatic(): static
    {
        static::$system = $this;
        return $this;
    }

    /**
     * @return static
     */
    public static function getInstance(): static
    {
        return static::$system;
    }

    /**
     * PluginSystem constructor.
     *
     * @param string $directory
     * @param array $plugins
     */
    public function __construct(public string $directory, array $plugins = [])
    {
        $this->plugins = collect($plugins);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get(string $name)
    {
        $methods = [
            'plugins',
            'enabledPlugins',
            'disabledPlugins',
        ];

        if (in_array($name, $methods)) {
            return $this->$name();
        }

        return $this->$name;
    }

    /**
     * Get the plugins base directory.
     *
     * @return string
     */
    public function getDirectory(): string
    {
        return $this->directory;
    }

    /**
     * Set the plugins base directory.
     *
     * @param string $directory
     * @return PluginSystem
     */
    public function setDirectory(string $directory): static
    {
        $this->directory = $directory;
        return $this;
    }

    /**
     * Get all plugins.
     *
     * @return Collection
     */
    public function plugins(): Collection
    {
        return $this->plugins;
    }

    /**
     * Get enabled plugins.
     *
     * @return Collection
     */
    public function enabledPlugins(): Collection
    {
        $plugins = collect();

        /** @var PluginInterface $plugin */
        foreach ($this->plugins as $plugin) {
            if ($plugin->isEnabled()) {
                $plugins->add($plugin);
            }
        }

        return $plugins;
    }

    /**
     * Get disabled plugins.
     *
     * @return Collection
     */
    public function disabledPlugins(): Collection
    {
        $plugins = collect();

        /** @var PluginInterface $plugin */
        foreach ($this->plugins as $plugin) {
            if ($plugin->isDisabled()) {
                $plugins->add($plugin);
            }
        }

        return $plugins;
    }

    /**
     * Add a plugin.
     *
     * @param PluginInterface $plugin
     * @return $this
     */
    public function add(PluginInterface $plugin): static
    {
        $this->plugins->add($plugin);
        return $this;
    }

    /**
     * Remove a specific plugin.
     *
     * @param PluginInterface $plugin
     * @return static
     */
    public function remove(PluginInterface $plugin): static
    {
        $this->plugins = $this->plugins->filter(function (PluginInterface $item) use ($plugin) {
            return $item->getUid() !== $plugin->getUid();
        });

        return $this;
    }

    /**
     * Load a plugin file
     *
     * @param string $filename
     * @param mixed ...$attributes
     * @return PluginSystem
     * @throws PluginNotFoundException
     */
    public function load(string $filename, ...$attributes): static
    {
        if (Str::endsWith($filename, '.php')) {
            // include once plugin file with return
            $classname = @include_once $filename;

            // if class name is not string then sets as filename
            if (! (is_string($classname) && strlen($classname) > 0)) {
                $classname = (string) pathinfo($filename)['filename'];
            }

            // if extension is disabled extension then remove disabled parameter in filename
            if (Str::endsWith($filename, '.disabled.php')) {
                $classname = explode('.', $classname)[0];
            }

            // create plugin instance
            /** @var PluginInterface $plugin */
            $plugin = new $classname($attributes);
            $plugin->setFilename($filename);
            return $this->add($plugin);
        }

        throw new PluginNotFoundException;
    }

    /**
     * Autoload all plugins in a directory.
     *
     * @param string|null $directory
     * @param bool $nested
     * @param bool $folders
     * @return static
     * @throws PluginNotFoundException
     */
    public function autoload(string $directory = null, bool $nested = false, bool $folders = false): static
    {
        if ($directory === null) {
            $directory = $this->directory;
        }

        if ($nested && $folders) {
            throw new InvalidArgumentException('You can use only one of the "nested" and "folders" variables.');
        }

        foreach (scandir($directory) as $path) {
            if ($path === '.' || $path === '..') {
                continue;
            }

            $path = implode(DIRECTORY_SEPARATOR, [$directory, $path]);

            if ($folders) {
                if (is_dir($path)) {
                    $plugin = Str::of($path)->afterLast(DIRECTORY_SEPARATOR);
                    $plugin = Str::of($path)->append(DIRECTORY_SEPARATOR, $plugin)->append('.php')->__toString();

                    if (file_exists($plugin)) {
                        $this->load($plugin);
                    }
                }

                continue;
            }

            if (Str::of($path)->endsWith('.php') && file_exists($path)) {
                $this->load($path);
                continue;
            }

            if ($nested && is_dir($path)) {
                $this->autoload($path, $nested, $folders);
            }
        }

        return $this;
    }

    /**
     * Enable the specific plugin.
     *
     * @param PluginInterface|string $plugin
     * @return static
     * @throws PluginNotFoundException
     */
    public function enable(PluginInterface|string $plugin): static
    {
        $this->findPlugin($plugin)->enable();
        return $this;
    }

    /**
     * Disable the specific plugin.
     *
     * @param PluginInterface|string $plugin
     * @return static
     * @throws PluginNotFoundException
     */
    public function disable(PluginInterface|string $plugin): static
    {
        $this->findPlugin($plugin)->disable();
        return $this;
    }

    /**
     * Toggle plugin enable/disable state.
     *
     * @param PluginInterface|string $plugin
     * @return static
     * @throws PluginNotFoundException
     */
    public function toggle(PluginInterface|string $plugin): static
    {
        $this->findPlugin($plugin)->toggle();
        return $this;
    }

    /**
     * Check the plugin is enabled.
     *
     * @param PluginInterface|string $plugin
     * @return bool
     * @throws PluginNotFoundException
     */
    public function isEnabled(PluginInterface|string $plugin): bool
    {
        return $this->findPlugin($plugin)->isEnabled();
    }

    /**
     * Check the plugin is disabled.
     *
     * @param PluginInterface|string $plugin
     * @return bool
     * @throws PluginNotFoundException
     */
    public function isDisabled(PluginInterface|string $plugin): bool
    {
        return $this->findPlugin($plugin)->isDisabled();
    }

    /**
     * Execute methods in loaded and enabled plugins.
     *
     * @param string $name
     * @param ...$arguments
     * @return bool
     */
    public function execute(string $name, ...$arguments): bool
    {
        $success = true;
        $arguments = func_get_args();
        unset($arguments[0]);

        /** @var PluginInterface $plugin */
        foreach ($this->enabledPlugins() as $plugin) {
            if (! $plugin->execute($name, ...$arguments)->success) {
                $success = false;
            }
        }

        return $success;
    }
}
