<?php

namespace IsaEken\PluginSystem\Tests;

use IsaEken\PluginSystem\PluginSystem;
use PHPUnit\Framework\TestCase;

class LoaderTest extends TestCase
{
    public function testManualLoader()
    {
        $pluginSystem = new PluginSystem(__DIR__ . '/../examples');

        $this->assertCount(0, $pluginSystem->plugins());
        $pluginSystem->load(__DIR__ . '/../examples/ExamplePlugin.php');
        $this->assertCount(1, $pluginSystem->plugins());
    }

    public function testNestedLoader()
    {
        $pluginSystem = new PluginSystem(__DIR__ . '/../examples');

        $this->assertCount(0, $pluginSystem->plugins());
        $pluginSystem->autoload(nested: true);
        $this->assertCount(4, $pluginSystem->plugins());
    }

    public function testFolderLoader()
    {
        $pluginSystem = new PluginSystem(__DIR__ . '/../examples');

        $this->assertCount(0, $pluginSystem->plugins());
        $pluginSystem->autoload(folders: true);
        $this->assertCount(1, $pluginSystem->plugins());
    }
}
