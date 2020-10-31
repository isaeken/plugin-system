<?php
/**
 * Plugin System
 * @version v1.0
 * @author İsa Eken
 * @license MIT
 */

namespace IsaEken\PluginSystem\Traits;

/**
 * Trait PluginsExecuteTrait
 * @package IsaEken\PluginSystem\Traits
 */
trait PluginsExecuteTrait
{
    /**
     * Execute method of all plugins
     *
     * @param string $name
     * @param mixed ...$arguments
     * @return bool
     */
    public function execute(string $name, ...$arguments) : bool
    {
        $success = true;
        foreach ($this->plugins as $plugin)
            if ($this->isEnabled($plugin))
                $success = $plugin->execute($name, $arguments)->success == false ? false : $success;
        return $success;
    }
}
