<?php

namespace IsaEken\PluginSystem\Exceptions;

use IsaEken\PluginSystem\Contracts\Plugin;

class PluginMethodNotExistsException extends \Exception
{
    public function __construct(Plugin $plugin, string $method)
    {
        parent::__construct("Plugin method \"{$method}\" not exists in \"{$plugin->getName()}\"");
    }
}
