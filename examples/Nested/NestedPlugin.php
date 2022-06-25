<?php

namespace Nested;

use IsaEken\PluginSystem\Plugin;

class NestedPlugin extends Plugin
{
    /**
     * Your plugin unique name.
     *
     * @var string
     */
    public string $name = 'isaeken/nested_plugin';

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
}

return NestedPlugin::class;
