<?php

require_once __DIR__.'/helpers.php';

class PluginPack extends IsaEken\PluginSystem\Plugin
{
    protected string $name = 'plugin pack';

    /**
     * @inheritDoc
     */
    public function handle(...$arguments): mixed
    {
        return subtotal([
            1.4,
            3.5,
            0.1,
        ]);
    }
}
