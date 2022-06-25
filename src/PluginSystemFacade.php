<?php

namespace IsaEken\PluginSystem;

use Illuminate\Support\Facades\Facade;

class PluginSystemFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'plugins';
    }
}
