<?php
namespace Nested;

class ExamplePlugin extends \IsaEken\PluginSystem\Plugin
{
    /**
     * Your plugin unique name.
     *
     * @var string $name
     */
    public string $name = 'isaeken/example_plugin2';

    /**
     * Your plugin readable name.
     *
     * @var string $title
     */
    public string $title = 'Example Plugin 2';

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
}