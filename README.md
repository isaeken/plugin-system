
# Plugin System
![CircleCI](https://img.shields.io/circleci/build/github/isaeken/plugin-system?label=CircleCI) ![Libraries.io dependency status for latest release](https://img.shields.io/librariesio/release/github/isaeken/plugin-system) ![Packagist License](https://img.shields.io/packagist/l/isaeken/plugin-system) ![Packagist Version](https://img.shields.io/packagist/v/isaeken/plugin-system)

Plugin system and management package for your projects.  
  
- Execute specific function for plugin or plugins  
- Execute function with/without arguments  
- Enable, disable, check plugin outside or inside plugin  
- Test plugin before load  
- Detailed execution info like extension function executed seconds  

````php
$pluginSystem = new IsaEken\PluginSystem\PluginSystem;

// set your plugins directory
$pluginSystem->directory = '/your/plugins/directory';

// load all enabled plugins in your plugins directory
$pluginSystem->autoload();

// execute foo function in all enabled plugins
$success = $pluginSystem->execute('foo');

// execute bar function with arguments in all enabled plugins
$success = $pluginSystem->execute('bar', 'baz');
````
  
## Help and docs  
Please report bugs from issues tab
- [Documentation](https://isaeken.github.io/plugin-system/)

## Installing plugin system
The recommended way to install plugin system is through [Composer](https://getcomposer.org/)
````bash
composer require isaeken/plugin-system
````
