<?php

namespace IsaEken\PluginSystem\Tests;

use IsaEken\PluginSystem\Interfaces\PluginInterface;
use IsaEken\PluginSystem\PluginSystem;
use PHPUnit\Framework\TestCase;

class GeneralTest extends TestCase
{
    private static PluginSystem|null $pluginSystem = null;

    public static function pluginSystem(): PluginSystem
    {
        if (static::$pluginSystem === null) {
            static::$pluginSystem = new PluginSystem(__DIR__ . '/../examples');
        }

        return static::$pluginSystem;
    }

    public function testAutoloader()
    {
        static::pluginSystem()->autoload(
            nested: false,
        );

        $this->assertCount(2, static::pluginSystem()->plugins());
    }

    public function testStatic()
    {
        static::pluginSystem()->makeStatic();
        $this->assertEquals(static::pluginSystem(), PluginSystem::getInstance());
    }

    public function testDisable()
    {
        static::pluginSystem()->plugins()->each(function (PluginInterface $plugin) {
            $plugin->disable();
            $this->assertTrue($plugin->isDisabled());
            $this->assertFalse($plugin->isEnabled());
        });

        $this->assertCount(2, static::pluginSystem()->disabledPlugins());
    }

    public function testEnable()
    {
        static::pluginSystem()->plugins()->each(function (PluginInterface $plugin) {
            $plugin->enable();
            $this->assertTrue($plugin->isEnabled());
            $this->assertFalse($plugin->isDisabled());
        });

        $this->assertCount(2, static::pluginSystem()->enabledPlugins());
    }

    public function testToggle()
    {
        static::pluginSystem()->plugins()->each(function (PluginInterface $plugin) {
            $isEnabled = $plugin->isEnabled();

            $plugin->toggle();
            $this->assertEquals($isEnabled, ! $plugin->isEnabled());

            $plugin->toggle();
            $this->assertEquals($isEnabled, $plugin->isEnabled());
        });
    }

    public function testAddRemove()
    {
        $plugin = static::pluginSystem()->plugins()->first();
        $count = static::pluginSystem()->plugins()->count();
        static::pluginSystem()->remove($plugin);
        $this->assertEquals($count - 1, static::pluginSystem()->plugins()->count());
        static::pluginSystem()->add($plugin);
        $this->assertEquals($count, static::pluginSystem()->plugins()->count());
    }

    public function testExecute()
    {
        $method = 'helloWorld';

        $this->assertTrue(static::pluginSystem()->execute($method));

        static::pluginSystem()->plugins()->each(function (PluginInterface $plugin) use ($method) {
            $executionData = $plugin->execute($method);
            $this->assertEquals($plugin, $executionData->plugin);
            $this->assertEquals($method, $executionData->method);
            $this->assertEquals([], $executionData->arguments);
            $this->assertNotEquals(null, $executionData->return);
            $this->assertTrue($executionData->success);
            $this->assertIsFloat($executionData->execution_time);
        });
    }
}
