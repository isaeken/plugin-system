<?php

namespace IsaEken\PluginSystem;

use Exception;
use IsaEken\PluginSystem\Traits\HasFilesystem;
use IsaEken\PluginSystem\Traits\HasNamespace;
use IsaEken\PluginSystem\Traits\HasPlugins;

class Autoloader
{
    use HasPlugins;
    use HasFilesystem;
    use HasNamespace;

    public PluginSystem|null $pluginSystem = null;

    public function getPluginSystem(): PluginSystem|null
    {
        return $this->pluginSystem;
    }

    public function setPluginSystem(PluginSystem|null $pluginSystem): self
    {
        $this->pluginSystem = $pluginSystem;
        $this->setPlugins($pluginSystem->getPlugins());
        $this->setNamespace($pluginSystem->getNamespace());
        $this->setFilesystem($pluginSystem->getFilesystem());

        return $this;
    }

    /**
     * Load plugins from directory.
     *
     * @param  string  $directory
     * @return $this
     */
    public function load(string $directory): self
    {
        $plugins = collect();

        $includePlugin = function ($file) {
            $file = str($file);

            try {
                require_once $file;
                $pluginName = $file->afterLast('/')->afterLast('\\')->beforeLast('.')->camel()->ucfirst();

                return [
                    $file->value() => new ($this->getNamespace().'\\'.$pluginName->value())(),
                ];
            } catch (Exception $exception) {
                $this->getPluginSystem()?->getLogger()->notice('Failed to load plugin', [
                    'plugin' => $file,
                    'exception' => $exception,
                ]);
            }

            return null;
        };

        foreach ($this->getFilesystem()->files($directory, false) as $file) {
            $file = str($file);
            if ($file->startsWith(['.'])) {
                continue;
            }

            if ($file->endsWith('.php') && is_file($file)) {
                if (($include = $includePlugin($file)) !== null) {
                    $plugins = $plugins->merge($include);
                }
            }
        }

        foreach ($this->getFilesystem()->directories($directory, false) as $directory) {
            $directory = str($directory);
            if ($directory->startsWith(['.'])) {
                continue;
            }

            $className = $directory->afterLast('/')->afterLast('\\')->camel()->ucfirst();
            if (file_exists($directory = $directory->append("/$className.php"))) {
                if (($include = $includePlugin($directory)) !== null) {
                    $plugins = $plugins->merge($include);
                }
            }
        }

        $this->setPlugins($this->getPlugins()->merge($plugins)->unique());
        $this->getPluginSystem()?->setPlugins($this->getPlugins());

        return $this;
    }
}
