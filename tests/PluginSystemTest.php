<?php

use IsaEken\PluginSystem\PluginSystem;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;

it('is loading tests', function () {
    $pluginSystem = new PluginSystem();
    $pluginSystem->load(__DIR__.'/../examples');
    assertCount(2, $pluginSystem->getPlugins());
});


it('is executing custom methods', function () {
    $results = ['example plugin' => true, 'plugin pack' => 5];

    $pluginSystem = new PluginSystem();
    $pluginSystem->load(__DIR__.'/../examples');
    $executions = $pluginSystem->execute('handle');

    foreach ($executions as $execution) {
        assertEquals($results[$execution['plugin']->getName()], $execution['data']);
    }
});

it('is executing handle method', function () {
    $results = ['example plugin' => true, 'plugin pack' => 5];

    $pluginSystem = new PluginSystem();
    $pluginSystem->load(__DIR__.'/../examples');
    $executions = $pluginSystem->handle();

    foreach ($executions as $execution) {
        assertEquals($results[$execution['plugin']->getName()], $execution['data']);
    }
});