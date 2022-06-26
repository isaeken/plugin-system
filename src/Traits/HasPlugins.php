<?php

namespace IsaEken\PluginSystem\Traits;

use IsaEken\PluginSystem\Collections\PluginCollection;

trait HasPlugins
{
    public function bootHasPlugins(): void
    {
        if (empty($this->plugins)) {
            $this->plugins = new PluginCollection();
        }
    }

    /**
     * @return PluginCollection
     */
    public function getPlugins(): PluginCollection
    {
        return $this->plugins;
    }

    /**
     * @param  PluginCollection  $plugins
     * @return self
     */
    public function setPlugins(PluginCollection $plugins): self
    {
        $this->plugins = $plugins;

        return $this;
    }

    /**
     * @param  PluginCollection  $plugins
     * @return self
     */
    public static function usePlugins(PluginCollection $plugins): self
    {
        return (new static())->setPlugins($plugins);
    }
}
