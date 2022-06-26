<?php

namespace IsaEken\PluginSystem;

use InvalidArgumentException;
use IsaEken\PluginSystem\Enums\PluginState;

abstract class Plugin implements Contracts\Plugin
{
    protected string $name;

    protected string|array $author = 'Unknown';

    protected string $version = '0.0.1';

    protected PluginState $state = PluginState::Enabled;

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function setName(string $name): Contracts\Plugin
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getAuthor(): string|array
    {
        return $this->author;
    }

    /**
     * @inheritDoc
     */
    public function setAuthor(array|string $author): Contracts\Plugin
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @inheritDoc
     */
    public function setVersion(string $version): Contracts\Plugin
    {
        throw_unless(
            version_compare($version, '0.0.1', '>=') >= 0,
            InvalidArgumentException::class,
        );

        $this->version = $version;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getState(): PluginState
    {
        return $this->state;
    }

    /**
     * @inheritDoc
     */
    public function setState(PluginState $state): Contracts\Plugin
    {
        $this->state = $state;

        return $this;
    }
}
