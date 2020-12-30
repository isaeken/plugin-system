<?php


use IsaEken\PluginSystem\Helpers\Str;
use IsaEken\PluginSystem\PluginSystem;
use IsaEken\PluginSystem\PluginTester;
use PHPUnit\Framework\TestCase;

class Test extends TestCase
{
    public PluginSystem $pluginSystem;
    public PluginTester $pluginTester;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->pluginTester = new PluginTester;
        $this->pluginSystem = new PluginSystem;
        $this->pluginSystem->directory = __DIR__.'/../examples';
        $this->pluginSystem->autoload();
    }

    public function testValidate()
    {
        $success = false;
        foreach (scandir(__DIR__.'/../examples') as $plugin)
        {
            if (Str::endsWith($plugin, '.php'))
            {
                $this->pluginTester->plugin = __DIR__.'/../examples/'.$plugin;
                $success = $this->pluginTester->validate();
            }
        }
        $this->assertTrue($success);
    }

    public function testExecute()
    {
        $success = $this->pluginSystem->execute('helloWorld');
        $this->assertTrue($success);
    }

    public function testEnableDisable()
    {
        $successDisable = false;
        $successEnable = false;

        foreach ($this->pluginSystem->plugins as $plugin) $plugin->disable();
        foreach ($this->pluginSystem->plugins as $plugin) $successDisable = Str::endsWith($plugin->filename, '.disabled.php');
        foreach ($this->pluginSystem->plugins as $plugin) $plugin->enable();
        foreach ($this->pluginSystem->plugins as $plugin) $successEnable = !Str::endsWith($plugin->filename, '.disabled.php');

        $this->assertTrue($successDisable && $successEnable);
    }

    public function testHasMethods()
    {
        foreach ($this->pluginSystem->plugins as $plugin) {
            $result = $plugin->hasMethod('helloWorld');
            $this->assertTrue($result);
            $this->assertEquals($plugin->hasFunction('helloWorld'), $result);
        }
    }

    public function testCallMethod()
    {
        foreach ($this->pluginSystem->plugins as $plugin) {
            try {
                $plugin->helloWorld();
                $this->assertTrue(true);
            } catch (Exception $exception) {
                $this->assertTrue(false);
            }
        }
    }
}
