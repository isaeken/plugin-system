# Autoloaders

## Load Plugins Manually

````php
use IsaEken\PluginSystem\PluginSystem;

// create a instance
$pluginSystem = new PluginSystem(__DIR__ . '/your/plugins/path');

// get a plugin path
$pluginFilePath = $pluginSystem->getDirectory() . '/ExamplePlugin.php';

// load the plugin
$pluginSystem->load($pluginFilePath);

var_dump($pluginSystem->plugins());
````

## Load Plugins with Autoloader

````php
use IsaEken\PluginSystem\PluginSystem;

// create a instance
$pluginSystem = new PluginSystem(__DIR__ . '/your/plugins/path');

// load the plugins with autoloader
$pluginSystem->autoload();

// or a specific path
$pluginSystem->autoload(__DIR__ . '/another/plugins/path');

var_dump($pluginSystem->plugins());
````

## Load Plugins with Autoloader in Nested Folders

````php
use IsaEken\PluginSystem\PluginSystem;

// create a instance
$pluginSystem = new PluginSystem(__DIR__ . '/your/plugins/path');

// load the plugins with autoloader
$pluginSystem->autoload(nested: true);

var_dump($pluginSystem->plugins());
````

## Load Plugins with Autoloader in Foldered Plugins

````
Plugins Directory:
|
`- /your/plugins/path
    `
    |- ExamplePlugin
    |   `
    |   |- ExamplePlugin.php
    |   `- Other files that do not affect the system.
    |
    `- AnotherPlugin
        `
        |- AnotherPlugin.php
        `- plugin.yaml
````

````php
use IsaEken\PluginSystem\PluginSystem;

// create a instance
$pluginSystem = new PluginSystem(__DIR__ . '/your/plugins/path');

// load the plugins with autoloader
$pluginSystem->autoload(folders: true);

var_dump($pluginSystem->plugins());
````
