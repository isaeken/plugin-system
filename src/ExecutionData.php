<?php

namespace IsaEken\PluginSystem;

use Exception;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use IsaEken\PluginSystem\Interfaces\PluginInterface;

/**
 * Class ExecutionData
 *
 * @property PluginInterface $plugin
 * @property bool $success
 * @property Exception|null $exception
 * @property float $execution_time
 * @property string $method
 * @property array $arguments
 * @property mixed $return
 */
class ExecutionData implements Arrayable, Jsonable
{
    /**
     * @var object
     */
    private object $attributes;

    /**
     * ExecutionData constructor.
     *
     * @param  array|object  $attributes
     */
    public function __construct(array|object $attributes = [])
    {
        $this->attributes = (object) $attributes;
    }

    /**
     * @param  string  $name
     * @param  mixed  $value
     * @return $this
     */
    public function setAttribute(string $name, mixed $value): static
    {
        $this->attributes->$name = $value;

        return $this;
    }

    /**
     * @param  string  $name
     * @return mixed
     */
    public function getAttribute(string $name): mixed
    {
        if (! isset($this->attributes->$name)) {
            return null;
        }

        return $this->attributes->$name;
    }

    /**
     * @return object
     */
    public function getAttributes(): object
    {
        return $this->attributes;
    }

    /**
     * @param  string  $name
     * @return mixed
     */
    public function __get(string $name)
    {
        return $this->getAttribute($name);
    }

    /**
     * @param  string  $name
     * @param $value
     */
    public function __set(string $name, $value): void
    {
        $this->setAttribute($name, $value);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return json_decode(json_encode($this->attributes), true);
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return count($this->toArray());
    }

    /**
     * @inheritDoc
     */
    public function toJson($options = 0): bool|string
    {
        return json_encode($this->attributes, $options);
    }
}
