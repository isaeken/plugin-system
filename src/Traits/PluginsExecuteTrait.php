<?php


namespace IsaEken\PluginSystem\Traits;


trait PluginsExecuteTrait
{
    /**
     * @param string $name
     * @param mixed ...$arguments
     * @return bool
     */
    public function execute(string $name, ...$arguments) : bool
    {
        $success = true;
        foreach ($this->plugins as $plugin)
            if ($this->isEnabled($plugin))
                $success = $plugin->execute($name, $arguments)->success == false ? false : $success;
        return $success;
    }
}
