<?php


namespace IsaEken\PluginSystem\Interfaces;


use IsaEken\PluginSystem\ExecutionData;

interface PluginInterface
{
    /**
     * Get the filename of the plugin.
     *
     * @return string
     */
    public function getFilename(): string;

    /**
     * Get the plugin name.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get the plugin description.
     *
     * @return string
     */
    public function getDescription(): string;

    /**
     * Get the plugin author.
     *
     * @return string
     */
    public function getAuthor(): string;

    /**
     * Get the plugin version.
     *
     * @return string
     */
    public function getVersion(): string;

    /**
     * Set filename of the plugin.
     *
     * @param string $filename
     * @return static
     */
    public function setFilename(string $filename): static;

    /**
     * Get unique id of the plugin.
     *
     * @return string
     */
    public function getUid(): string;

    /**
     * Check if is enabled the plugin.
     *
     * @return bool
     */
    public function isEnabled(): bool;

    /**
     * Check if is disabled the plugin.
     *
     * @return bool
     */
    public function isDisabled(): bool;

    /**
     * Enable the plugin.
     *
     * @return static
     */
    public function enable(): static;

    /**
     * Disable the plugin.
     *
     * @return static
     */
    public function disable(): static;

    /**
     * Toggle the plugin's enable/disable state.
     *
     * @return static
     */
    public function toggle(): static;

    /**
     * Execute method with arguments in the plugin.
     *
     * @param string $name
     * @param ...$arguments
     * @return ExecutionData
     */
    public function execute(string $name, ...$arguments): ExecutionData;
}
