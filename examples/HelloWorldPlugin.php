<?php
class HelloWorldPlugin extends \IsaEken\PluginSystem\Plugin
{
    public function helloWorld()
    {
        return 'Hello world from: '.__CLASS__;
    }
}