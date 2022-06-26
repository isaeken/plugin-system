<?php

namespace IsaEken\PluginSystem\Traits;

trait HasNamespace
{
    public function bootHasNamespace(): void
    {
        if (empty($this->namespace)) {
            $this->namespace = '';
        }
    }

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * @param  string  $namespace
     * @return self
     */
    public function setNamespace(string $namespace): self
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * @param  string  $namespace
     * @return static
     */
    public static function useNamespace(string $namespace): static
    {
        return (new self())->setNamespace($namespace);
    }
}
