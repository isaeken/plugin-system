<?php
/**
 * Plugin System
 * @version v1.0
 * @author İsa Eken
 * @license MIT
 */

namespace IsaEken\PluginSystem;

use IsaEken\PluginSystem\Exceptions\AttributeNotExistsException;
use IsaEken\PluginSystem\Traits\PluginManageableTrait;
use stdClass;

/**
 * Class Plugin
 * @package IsaEken\PluginSystem
 */
abstract class Plugin
{
    use PluginManageableTrait;

    /**
     * Your plugins name
     *
     * @var string $name
     */
    protected string $name;

    /**
     * Your plugins description
     *
     * @var string $description
     */
    protected string $description = '';

    /**
     * Your plugins version
     *
     * @var string $version
     */
    protected string $version = 'v1.0';

    /**
     * Your plugins author
     *
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
     * Fill attributes from array in plugin
     *
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
     * Set attribute in plugin
     *
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
     * Get attribute from plugin
     *
     * @param string $key
     * @return mixed
     */
    public function getAttribute(string $key)
    {
        return $this->{$key};
    }

    /**
     * Execute method in plugin
     *
     * @param string $name
     * @param array $arguments
     * @return object
     * @throws Exceptions\PluginNotFoundException
     */
    public function execute(string $name, array $arguments = []) : object
    {
        // each all methods in plugin
        foreach (get_class_methods($this) as $index => $method)
        {
            // check if method is requested
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

        // requested method is not found
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