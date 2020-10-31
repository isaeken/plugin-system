<?php


namespace IsaEken\PluginSystem;


use IsaEken\PluginSystem\Exceptions\AttributeNotExistsException;
use IsaEken\PluginSystem\Traits\PluginManageableTrait;
use stdClass;

abstract class Plugin
{
    use PluginManageableTrait;

    /**
     * @var string $name
     */
    protected string $name;

    /**
     * @var string $description
     */
    protected string $description = '';

    /**
     * @var string $version
     */
    protected string $version = 'v1.0';

    /**
     * @var string $author
     */
    protected string $author = '';

    /**
     * Plugin constructor.
     * @param array $attributes
     * @throws AttributeNotExistsException
     */
    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }

    /**
     * @param array $attributes
     * @return Plugin
     * @throws AttributeNotExistsException
     */
    public function fill(array $attributes) : Plugin
    {
        foreach ($attributes as $key => $value) $this->setAttribute($key, $value);
        return $this;
    }

    /**
     * @param string $key
     * @param $value
     * @return Plugin
     * @throws AttributeNotExistsException
     */
    public function setAttribute(string $key, $value) : Plugin
    {
        if (!isset($this->{$key})) throw new AttributeNotExistsException;
        $this->{$key} = $value;
        return $this;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getAttribute(string $key)
    {
        return $this->{$key};
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return object
     * @throws Exceptions\PluginNotFoundException
     */
    public function execute(string $name, array $arguments = []) : object
    {
        foreach (get_class_methods($this) as $index => $method)
        {
            if ($method === $name)
            {
                $starts_at = microtime(true);

                $result = new stdClass;
                $result->enabled = $this->isEnabled();
                $result->success = true;
                $result->class = $this;
                $result->function = $name;
                $result->arguments = $arguments;
                $result->return = call_user_func_array(array($this, $name), $arguments);

                $ends_at = microtime(true);
                $result->executed_seconds = ($ends_at - $starts_at);
                return $result;
            }
        }
        return (object) [
            'enabled' => $this->isEnabled(),
            'success' => false,
            'class' => $this,
            'function' => $name,
            'arguments' => $arguments,
            'return' => null,
            'executed_seconds' => 0,
        ];
    }
}