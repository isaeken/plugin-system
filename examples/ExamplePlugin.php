<?php

class ExamplePlugin extends IsaEken\PluginSystem\Plugin
{
    protected string $name = 'example plugin';

    /**
     * @inheritDoc
     */
    public function handle(...$arguments): mixed
    {
        return true;
    }

    public function test(...$arguments)
    {
        dump($arguments);
    }
}
