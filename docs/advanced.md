# Advanced

````php
use IsaEken\PluginSystem\Interfaces\PluginInterface;
use IsaEken\PluginSystem\PluginSystem;

// create a instance
$pluginSystem = new PluginSystem(__DIR__ . '/your/plugins/path');

// load all plugins in plugins directory
$pluginSystem->autoload();

// execute `foo('bar')` in all loaded and enabled plugins
// returns true if all methods are executed successfully
$pluginSystem->execute('foo', 'bar');

// each all plugins
$pluginSystem->plugins()->each(function (PluginInterface $plugin) {
    // execute `foo('bar')` in a specific plugin
    // returns ExecutionData class
    $executionData = $plugin->execute('foo', 'bar');
    
    // returns the execution plugin
    $executionData->plugin;
    
    // get the method result
    $executionData->return;
    
    // get the executed arguments
    $executionData->arguments;
    
    // get the exception if has exists
    $executionData->exception;
    
    // get execution time of the method
    $executionData->execution_time;
    
    // get executed method name
    $executionData->method;
    
    // check if method execution success.
    $executionData->success;
});
````
