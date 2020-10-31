<?php
class ExamplePlugin extends \IsaEken\PluginSystem\Plugin
{
    /**
     * Your plugin name.
     *
     * @var string $name
     */
    protected string $name = 'Example Plugin';

    /**
     * Your plugin description
     *
     * @var string $description
     */
    protected string $description = 'This is a example plugin description for you';

    /**
     * Plugin author name
     *
     * @var string $author
     */
    protected string $author = 'İsa Eken';

    /**
     * Your plugin version
     * Semantic version recommended
     *
     * @var string $version
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
return ExamplePlugin::class;