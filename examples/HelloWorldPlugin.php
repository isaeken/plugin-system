<?php
class HelloWorldPlugin extends \IsaEken\PluginSystem\Plugin
{
    public string $name = 'isaeken/hello_world_plugin';

    public function helloWorld()
    {
        return 'Hello world from: '.__CLASS__;
    }
}