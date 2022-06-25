<?php

use IsaEken\PluginSystem\Plugin;

class PluginWithFolder extends Plugin
{
    /**
     * Your plugin name.
     *
     * @var string
     */
    public string $name = 'isaeken/plugin_with_folder';

    /**
     * Your plugin description
     *
     * @var string
     */
    protected string $description = 'This is a example plugin description for you';

    /**
     * Plugin author name
     *
     * @var string
     */
    protected string $author = 'İsa Eken';

    /**
     * Your plugin version
     * Semantic version recommended
     *
     * @var string
     */
    protected string $version = 'v1.0';

    /**
     * example function
     *
     * @return string
     */
    public function helloWorld()
    {
        return 'Hello world from: '.__CLASS__;
    }
}

// optional
return PluginWithFolder::class;
