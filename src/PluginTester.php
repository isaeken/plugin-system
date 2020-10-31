<?php


namespace IsaEken\PluginSystem;


class PluginTester
{
    /**
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
     * @return bool
     */
    public function exists() : bool
    {
        return file_exists($this->plugin);
    }

    /**
     * @return bool
     */
    public function className() : bool
    {
        $class = include_once $this->plugin;
        if (!(is_string($class) && strlen($class) > 0)) $class = explode('.', pathinfo($this->plugin)['filename'])[0];
        return preg_match('/^[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*$/', $class);
    }

    /**
     * @return bool
     */
    public function validate() : bool
    {
        return $this->exists() && $this->className();
    }
}