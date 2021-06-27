<?php
/**
 * Plugin System
 * @version v1.0
 * @author İsa Eken
 * @license MIT
 */

namespace IsaEken\PluginSystem;

use Exception;
use IsaEken\PluginSystem\Exceptions\AttributeNotExistsException;
use IsaEken\PluginSystem\Helpers\Str;
use IsaEken\PluginSystem\Interfaces\PluginInterface;
use IsaEken\PluginSystem\Traits\PluginManageableTrait;
use stdClass;

/**
 * Class Plugin
 * @package IsaEken\PluginSystem
 */
abstract class Plugin implements PluginInterface
{
    /**
     * @var string $filename
     */
    protected string $filename;

    /**
     * Your plugins unique name
     *
     * @var string $name
     */
    protected string $name;

    /**
     * Your plugins description
     *
     * @var string $description
     */
    protected string $description = '';

    /**
     * Your plugins version
     *
     * @var string $version
     */
    protected string $version = 'v1.0';

    /**
     * Your plugins author
     *
     * @var string $author
     */
    protected string $author = '';

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     * @return $this
     */
    public function setFilename(string $filename): static
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @return string
     */
    public function getUid(): string
    {
        return sprintf(
            '%s/%s:%s',
            $this->getAuthor(),
            $this->getName(),
            $this->getVersion(),
        );
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        $filename = pathinfo($this->getFilename())['dirname'] . DIRECTORY_SEPARATOR . explode('.', pathinfo($this->getFilename())['filename'])[0];
        return file_exists($filename . '.php');
    }

    /**
     * @return bool
     */
    public function isDisabled(): bool
    {
        return ! $this->isEnabled();
    }

    /**
     * @return $this
     */
    public function enable(): static
    {
        $filename = pathinfo($this->getFilename())['dirname'] . DIRECTORY_SEPARATOR . explode('.', pathinfo($this->getFilename())['filename'])[0];

        if ($this->isDisabled()) {
            rename($filename . '.disabled.php', $filename . '.php');
        }

        return $this->setFilename($filename . '.php');
    }

    /**
     * @return $this
     */
    public function disable(): static
    {
        $filename = pathinfo($this->getFilename())['dirname'] . DIRECTORY_SEPARATOR . pathinfo($this->getFilename())['filename'];

        if ($this->isEnabled()) {
            rename($filename . '.php', $filename . '.disabled.php');
        }

        return $this->setFilename($filename . '.disabled.php');
    }

    /**
     * @return $this
     */
    public function toggle(): static
    {
        return $this->isEnabled() ? $this->disable() : $this->enable();
    }

    /**
     * Execute method in plugin
     *
     * @param string $name
     * @param array $arguments
     * @return ExecutionData
     */
    public function execute(string $name, ...$arguments): ExecutionData
    {
        $arguments = func_get_args();
        unset($arguments[0]);

        // each all methods in plugin
        foreach (get_class_methods($this) as $index => $method)
        {
            // check if method is requested
            if ($method === $name)
            {
                $started_at = microtime(true);

                $data = new ExecutionData;
                $data->plugin = $this;
                $data->method = $name;
                $data->arguments = $arguments;

                try {
                    $data->return = call_user_func_array(array($this, $name), $arguments);
                    $data->success = true;
                }
                catch (Exception $exception) {
                    $data->exception = $exception;
                    $data->success = false;
                }

                $data->execution_time = (microtime(true) - $started_at);
                return $data;
            }
        }

        // requested method is not found
        return new ExecutionData;
    }
}
