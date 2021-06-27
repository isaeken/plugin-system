<?php


namespace IsaEken\PluginSystem\Interfaces;


use IsaEken\PluginSystem\ExecutionData;

interface PluginInterface
{
    public function getFilename(): string;

    public function getName(): string;

    public function getDescription(): string;

    public function getAuthor(): string;

    public function getVersion(): string;

    public function setFilename(string $filename): static;

    public function getUid(): string;

    public function isEnabled(): bool;

    public function isDisabled(): bool;

    public function enable(): static;

    public function disable(): static;

    public function toggle(): static;

    public function execute(string $name, ...$arguments): ExecutionData;
}
