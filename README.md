
# Plugin System

![Plugin System](https://banners.beyondco.de/Plugin%20System.png?theme=light&packageManager=composer+require&packageName=isaeken%2Fplugin-system&pattern=architect&style=style_1&description=Make+plugins+to+your+script+and+make+it+flexible.&md=1&showWatermark=1&fontSize=100px&images=puzzle)

Make and add own plugins to your script and make it flexible

![CircleCI](https://img.shields.io/circleci/build/github/isaeken/plugin-system)
![Libraries.io dependency status for latest release](https://img.shields.io/librariesio/release/github/isaeken/plugin-system)
![GitHub](https://img.shields.io/github/license/isaeken/plugin-system)
![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/isaeken/plugin-system)
![Packagist Version](https://img.shields.io/packagist/v/isaeken/plugin-system)

## Features

- Execute specific function for plugin(s) at the synchronously
- Execute methods using arguments
- Enable, disable or load plugins in runtime
- Track method execution times

## Installation

Install plugin-system with composer

```bash 
  composer require isaeken/plugin-system
```

### Publish service provider and configs (Laravel)

```bash
php artisan vendor:publish --provider="IsaEken\PluginSystem\PluginSystemServiceProvider"
```

Set your configuration

```php
// config/plugins.php
<?php

return [
    'directory' => base_path('plugins'),
    'namespace' => '',
];
```

Add service provider to ``config/app.php``
```php
\IsaEken\PluginSystem\PluginSystemServiceProvider::class
```

## Usage

```php
$pluginSystem = new \IsaEken\PluginSystem\PluginSystem();
$pluginSystem->load(__DIR__ . '/plugins');
$pluginSystem->handle();
```

### Laravel

```php
app('plugins')->handle();
```

## Running Tests

To run tests, run the following command

```bash
  composer run test
```


## Documentation

[Documentation](https://isaeken.github.io/plugin-system)


## Feedback & Support

If you have any feedback, please reach out to us at hello@isaeken.com.tr


## Authors

- [@isaeken](https://www.github.com/isaeken)


## License

[MIT](LICENSE.md)

