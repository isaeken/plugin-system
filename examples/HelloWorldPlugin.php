<?php

use IsaEken\PluginSystem\Plugin;

class HelloWorldPlugin extends Plugin
{
    /**
     * @var string $name
     */
    public string $name = 'isaeken/hello_world_plugin';

    /**
     * @return string
     */
    public function helloWorld(): string
    {
        return 'Hello world from: ' . __CLASS__;
    }
}
