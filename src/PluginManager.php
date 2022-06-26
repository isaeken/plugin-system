<?php

namespace IsaEken\PluginSystem;

use IsaEken\PluginSystem\Enums\PluginState;

class PluginManager
{
    /**
     * @return array<string, PluginState>
     */
    public function getPluginStates(): array
    {
        // @todo

        return [];
    }

    public function updatePluginState(Contracts\Plugin $plugin, PluginState $state): void
    {
        // @todo
    }

    /**
     * @return array<\IsaEken\PluginSystem\Contracts\Plugin>
     */
    public function availablePlugins(): array
    {
        // @todo

        return [];
    }
}
