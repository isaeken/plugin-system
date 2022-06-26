<?php

namespace IsaEken\PluginSystem\Collections;

use Illuminate\Support\Collection;
use IsaEken\PluginSystem\Contracts\Plugin;
use IsaEken\PluginSystem\Enums\PluginState;

class PluginCollection extends Collection
{
    public function find(string $name): Plugin|null
    {
        return $this->filter(function (Plugin $plugin) use ($name) {
            return $plugin->getName() === $name;
        })->first();
    }

    public function state(PluginState $state): static
    {
        return $this->filter(function (Plugin $plugin) use ($state) {
            return $plugin->getState() === $state;
        });
    }

    public function enabled(): static
    {
        return $this->state(PluginState::Enabled);
    }

    public function disabled(): static
    {
        return $this->state(PluginState::Disabled);
    }

    public function outdated(): static
    {
        return $this->state(PluginState::Outdated);
    }
}
