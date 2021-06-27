# Enable or Disable Plugins

````php
use IsaEken\PluginSystem\Interfaces\PluginInterface;
use IsaEken\PluginSystem\PluginSystem;

// create a instance
$pluginSystem = new PluginSystem(__DIR__ . '/your/plugins/path');

// load all plugins in plugins directory
$pluginSystem->autoload();

// each all plugins
$pluginSystem->plugins()->each(function (PluginInterface $plugin) {

    // check plugin is enabled
    if ($plugin->isEnabled()) {
        // disable the plugin
        $plugin->disable();
    }
    
    // check plugin is disabled
    if ($plugin->isDisabled()) {
        // enable the plugin
        $plugin->enable();
    }
    
    // toggle plugin enable/disable state
    $plugin->toggle();
});

// disable the plugin
$pluginSystem->disable('plugin-name');
$pluginSystem->disable($plugin);

// enable the plugin
$pluginSystem->enable('plugin-name');
$pluginSystem->enable($plugin);

// toggle plugin enable/disable state
$pluginSystem->toggle('plugin-name');
$pluginSystem->toggle($plugin);

// check plugin is enabled
$pluginSystem->isEnabled('plugin-name');
$pluginSystem->isEnabled($plugin);

// check plugin is disabled
$pluginSystem->isDisabled('plugin-name');
$pluginSystem->isDisabled($plugin);
````
