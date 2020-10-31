<?php


namespace IsaEken\PluginSystem\Traits;


use IsaEken\PluginSystem\Exceptions\PluginNotFoundException;
use IsaEken\PluginSystem\Plugin;

trait PluginsManager
{
    /**
     * @param Plugin $plugin
     * @return Plugin
     * @throws PluginNotFoundException
     */
    public function enable(Plugin $plugin)
    {
        return $plugin->enable();
    }

    /**
     * @param Plugin $plugin
     * @return Plugin
     * @throws PluginNotFoundException
     */
    public function disable(Plugin $plugin)
    {
        return $plugin->disable();
    }

    /**
     * @param Plugin $plugin
     * @return Plugin
     * @throws PluginNotFoundException
     */
    public function toggle(Plugin $plugin)
    {
        return $plugin->toggle();
    }

    /**
     * @param Plugin $plugin
     * @return bool
     * @throws PluginNotFoundException
     */
    public function isEnabled(Plugin $plugin) : bool
    {
        return $plugin->isEnabled();
    }

    /**
     * @param Plugin $plugin
     * @return bool
     * @throws PluginNotFoundException
     */
    public function isDisabled(Plugin $plugin) : bool
    {
        return $plugin->isDisabled();
    }
}