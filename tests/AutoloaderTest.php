<?php

use IsaEken\PluginSystem\Autoloader;
use function PHPUnit\Framework\assertArrayHasKey;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertNotFalse;

it('is loading all plugins', function () {
    $plugins = [
        \ExamplePlugin::class => 'example plugin',
        \PluginPack::class => 'plugin pack',
    ];

    $autoloader = new Autoloader();
    $autoloader->load(__DIR__.'/../examples/');

    assertCount(count($plugins), $autoloader->getPlugins());

    foreach ($autoloader->getPlugins() as $plugin) {
        assertArrayHasKey($plugin::class, $plugins);
        assertNotFalse(array_search($plugin->getName(), $plugins));
    }
});
