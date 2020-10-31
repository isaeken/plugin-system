<?php
/**
 * Plugin System
 * @version v1.0
 * @author İsa Eken
 * @license MIT
 */

namespace IsaEken\PluginSystem\Traits;

/**
 * Trait PluginManageableTrait
 * @package IsaEken\PluginSystem\Traits
 */
trait PluginManageableTrait
{
    /**
     * Check plugin is enabled
     *
     * @return bool
     */
    public function isEnabled() : bool
    {
        // get filename of plugin without extension and disable parameters
        $filename = pathinfo($this->filename)['dirname'].DIRECTORY_SEPARATOR.explode('.', pathinfo($this->filename)['filename'])[0];

        // check file is exists
        return (file_exists($filename.'.php'));
    }

    /**
     * Check plugin is disabled
     *
     * @return bool
     */
    public function isDisabled() : bool
    {
        // reverse isEnabled method
        return !$this->isEnabled();
    }

    /**
     * Enable plugin
     *
     * @return $this
     */
    public function enable()
    {
        // get filename of plugin without extension and disable parameters
        $filename = pathinfo($this->filename)['dirname'].DIRECTORY_SEPARATOR.explode('.', pathinfo($this->filename)['filename'])[0];

        // remove disabled state if is disabled
        if ($this->isDisabled()) rename($filename.'.disabled.php', $filename.'.php');

        // set filename of plugin in memory
        $this->filename = $filename.'.php';

        // return this for chain functions
        return $this;
    }

    /**
     * Disable plugin
     *
     * @return $this
     */
    public function disable()
    {
        // get filename of plugin without extension and disable parameters
        $filename = pathinfo($this->filename)['dirname'].DIRECTORY_SEPARATOR.pathinfo($this->filename)['filename'];

        // add disabled state if is enabled
        if ($this->isEnabled()) rename($filename.'.php', $filename.'.disabled.php');

        // set filename of plugin in memory
        $this->filename = $filename.'.disabled.php';

        // return this for chain functions
        return $this;
    }

    /**
     * Toggle enabled state of plugin
     *
     * @return $this
     */
    public function toggle()
    {
        return $this->isEnabled() ? $this->disable() : $this->enable();
    }
}