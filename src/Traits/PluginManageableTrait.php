<?php
/**
 * Plugin System
 * @version v1.0
 * @author İsa Eken
 * @license MIT
 */

namespace IsaEken\PluginSystem\Traits;

use IsaEken\PluginSystem\Exceptions\PluginNotFoundException;
use IsaEken\PluginSystem\Helpers\Str;

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
        return (file_exists($filename.'.php'));
//        if (!file_exists($filename.'.php') && !file_exists($filename.'.disabled.php')) throw new PluginNotFoundException;
//        return !Str::endsWith($this->filename, '.disabled.php');
    }

    /**
     * Check plugin is disabled
     *
     * @return bool
     * @throws PluginNotFoundException
     */
    public function isDisabled() : bool
    {
        return !$this->isEnabled();
    }

    /**
     * Enable plugin
     *
     * @return $this
     * @throws PluginNotFoundException
     */
    public function enable()
    {
        // get filename of plugin without extension and disable parameters
        $filename = pathinfo($this->filename)['dirname'].DIRECTORY_SEPARATOR.explode('.', pathinfo($this->filename)['filename'])[0];
        if ($this->isDisabled()) rename($filename.'.disabled.php', $filename.'.php');
        $this->filename = $filename.'.php';
        return $this;
    }

    /**
     * Disable plugin
     *
     * @return $this
     * @throws PluginNotFoundException
     */
    public function disable()
    {
        // get filename of plugin without extension and disable parameters
        $filename = pathinfo($this->filename)['dirname'].DIRECTORY_SEPARATOR.pathinfo($this->filename)['filename'];
        if ($this->isEnabled()) rename($filename.'.php', $filename.'.disabled.php');
        $this->filename = $filename.'.disabled.php';
        return $this;
    }

    /**
     * Toggle enabled state of plugin
     *
     * @return $this
     * @throws PluginNotFoundException
     */
    public function toggle()
    {
        if ($this->isEnabled()) $this->disable();
        else $this->enable();
        return $this;
    }
}