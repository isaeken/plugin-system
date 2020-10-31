<?php
/**
 * Plugin Tester
 * @version v1.0
 * @author İsa Eken
 * @license MIT
 */

namespace IsaEken\PluginSystem;

/**
 * Class PluginTester
 * @package IsaEken\PluginSystem
 */
class PluginTester
{
    /**
     * Plugin file path
     *
     * @var string|null
     */
    public ?string $plugin = null;

    /**
     * PluginTester constructor.
     * @param string|null $plugin
     */
    public function __construct(?string $plugin = null)
    {
        $this->plugin = $plugin;
    }

    /**
     * Check plugin file is exists
     *
     * @return bool
     */
    public function exists() : bool
    {
        return file_exists($this->plugin);
    }

    /**
     * Check plugin class name is valid
     *
     * @return bool
     */
    public function className() : bool
    {
        $class = include_once $this->plugin;
        if (!(is_string($class) && strlen($class) > 0)) $class = explode('.', pathinfo($this->plugin)['filename'])[0];
        return preg_match('/^[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*$/', $class);
    }

    /**
     * Validate the plugin with everything
     *
     * @return bool
     */
    public function validate() : bool
    {
        return $this->exists() && $this->className();
    }
}