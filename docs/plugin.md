# Creating a Plugin

## Basic Plugin

````php
// YourPlugin.php
class YourPlugin extends \IsaEken\PluginSystem\Plugin
{
    public string $name = 'plugin-name';
    
    public function yourMethod() {
        
    }
}
````

## Plugin with Namespace

````php
// YourPlugin.php
namespace PluginNamespace;

use IsaEken\PluginSystem\Plugin;

class YourPlugin extends Plugin {
    public string $name = 'plugin-name';
}

// this line is required for plugins with namespace.
return YourPlugin::class;
````

## Plugin with Details

````php
// YourPlugin.php
use IsaEken\PluginSystem\Plugin;

class YourPlugin extends Plugin
{
    public string $name = 'plugin-name';
    public string $author = 'your name';
    public string $description = 'the plugins description';
    public string $version = 'v1.0.0-dev';
}
````
