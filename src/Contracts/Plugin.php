<?php

namespace IsaEken\PluginSystem\Contracts;

use IsaEken\PluginSystem\Enums\PluginState;

interface Plugin
{
    /**
     * Get the plugin name.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Set the plugin name.
     *
     * @param  string  $name
     * @return $this
     */
    public function setName(string $name): self;

    /**
     * Get the plugin author.
     *
     * @return string|array<array{name: string, email?: string, homepage?: string, role?: string}>
     */
    public function getAuthor(): string|array;

    /**
     * Set the plugin author.
     *
     * @param  string|array<array{name: string, email?: string, homepage?: string, role?: string}>  $author
     * @return $this
     */
    public function setAuthor(string|array $author): self;

    /**
     * Get the plugin version.
     *
     * @return string
     */
    public function getVersion(): string;

    /**
     * Set the plugin version.
     *
     * @param  string  $version
     * @return $this
     */
    public function setVersion(string $version): self;

    /**
     * Get the plugin state.
     *
     * @return PluginState
     */
    public function getState(): PluginState;

    /**
     * Set the plugin state.
     *
     * @param  PluginState  $state
     * @return $this
     */
    public function setState(PluginState $state): self;

    /**
     * Handle the plugin.
     *
     * @param ...$arguments
     * @return mixed
     */
    public function handle(...$arguments): mixed;
}
