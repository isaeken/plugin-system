<?php

namespace IsaEken\PluginSystem\Traits;

use IsaEken\PluginSystem\Autoloader;

trait HasAutoloader
{
    /**
     * @return Autoloader
     */
    public function getAutoloader(): Autoloader
    {
        return $this->autoloader;
    }

    /**
     * @param  Autoloader  $autoloader
     * @return self
     */
    public function setAutoloader(Autoloader $autoloader): self
    {
        $this->autoloader = $autoloader;

        return $this;
    }

    /**
     * @param  Autoloader  $autoloader
     * @return self
     */
    public static function useAutoloader(Autoloader $autoloader): self
    {
        return (new static())->setAutoloader($autoloader);
    }
}
