# Basic Usage

````php
use IsaEken\PluginSystem\Interfaces\PluginInterface;
use IsaEken\PluginSystem\PluginSystem;

// create a instance
$pluginSystem = new PluginSystem(__DIR__ . '/your/plugins/path');

// load all plugins in plugins directory
$pluginSystem->autoload();

// call in all loaded and enabled plugins
$pluginSystem->execute('boot');

// each all plugins
$pluginSystem->plugins()->each(function (PluginInterface $plugin) {

    // check plugin is enabled
    if ($plugin->isEnabled()) {
    
        // execute `booted` method in plugin
        $plugin->execute('booted');
        
        // disable the plugin
        $plugin->disable();
    }
});
````
