<?php
/**
 * Plugin System
 * @version v1.0
 * @author İsa Eken
 * @license MIT
 */

namespace IsaEken\PluginSystem\Traits;

use IsaEken\PluginSystem\Exceptions\PluginNotFoundException;
use IsaEken\PluginSystem\Plugin;

/**
 * Trait PluginsManager
 * @package IsaEken\PluginSystem\Traits
 */
trait PluginsManager
{
    /**
     * Enable a specific plugin
     *
     * @param Plugin $plugin
     * @return Plugin
     */
    public function enable(Plugin $plugin)
    {
        return $plugin->enable();
    }

    /**
     * Disable a specific plugin
     *
     * @param Plugin $plugin
     * @return Plugin
     * @throws PluginNotFoundException
     */
    public function disable(Plugin $plugin)
    {
        return $plugin->disable();
    }

    /**
     * Toggle a specific plugin
     *
     * @param Plugin $plugin
     * @return Plugin
     */
    public function toggle(Plugin $plugin)
    {
        return $plugin->toggle();
    }

    /**
     * Check plugin is enabled
     *
     * @param Plugin $plugin
     * @return bool
     */
    public function isEnabled(Plugin $plugin) : bool
    {
        return $plugin->isEnabled();
    }

    /**
     * Check plugin is disabled
     *
     * @param Plugin $plugin
     * @return bool
     */
    public function isDisabled(Plugin $plugin) : bool
    {
        return $plugin->isDisabled();
    }
}