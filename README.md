
# Plugin System

Make and add own plugins to your script and make it flexible

![CircleCI](https://img.shields.io/circleci/build/github/isaeken/plugin-system)
![Libraries.io dependency status for latest release](https://img.shields.io/librariesio/release/github/isaeken/plugin-system)
![GitHub](https://img.shields.io/github/license/isaeken/plugin-system)
![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/isaeken/plugin-system)
![Packagist Version](https://img.shields.io/packagist/v/isaeken/plugin-system)

## Features

- Execute specific function for plugin or multiple plugins at the same time
- Execute function with/without arguments
- Enable, disable or load plugins in runtime
- Detailed execution info like extension function executed seconds


## Roadmap

- Static autoloader generator like composer

- Laravel integration


## Installation

Install plugin-system with composer

```bash 
  composer require isaeken/plugin-system
```

## Example

```php
$pluginSystem = new PluginSystem('/your/plugins/path');
$pluginSystem->autoload();
if (! $pluginSystem->execute('hello_world')) {
    echo 'some plugins given an error.';
}
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

