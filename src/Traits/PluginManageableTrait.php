<?php


namespace IsaEken\PluginSystem\Traits;


use IsaEken\PluginSystem\Exceptions\PluginNotFoundException;
use IsaEken\PluginSystem\Helpers\Str;

trait PluginManageableTrait
{
    /**
     * @return bool
     * @throws PluginNotFoundException
     */
    public function isEnabled() : bool
    {
        $filename = pathinfo($this->filename)['dirname'].DIRECTORY_SEPARATOR.explode('.', pathinfo($this->filename)['filename'])[0];
        return (file_exists($filename.'.php'));
//        if (!file_exists($filename.'.php') && !file_exists($filename.'.disabled.php')) throw new PluginNotFoundException;
//        return !Str::endsWith($this->filename, '.disabled.php');
    }

    /**
     * @return bool
     * @throws PluginNotFoundException
     */
    public function isDisabled() : bool
    {
        return !$this->isEnabled();
    }

    /**
     * @return $this
     * @throws PluginNotFoundException
     */
    public function enable()
    {
        $filename = pathinfo($this->filename)['dirname'].DIRECTORY_SEPARATOR.explode('.', pathinfo($this->filename)['filename'])[0];
        if (!$this->isEnabled()) rename($filename.'.disabled.php', $filename.'.php');
        $this->filename = $filename.'.php';
        return $this;
    }

    /**
     * @return $this
     * @throws PluginNotFoundException
     */
    public function disable()
    {
        $filename = pathinfo($this->filename)['dirname'].DIRECTORY_SEPARATOR.pathinfo($this->filename)['filename'];
        if ($this->isEnabled()) rename($filename.'.php', $filename.'.disabled.php');
        $this->filename = $filename.'.disabled.php';
        return $this;
    }

    /**
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