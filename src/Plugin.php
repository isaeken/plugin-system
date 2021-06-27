<?php


namespace IsaEken\PluginSystem;


use Exception;
use IsaEken\PluginSystem\Interfaces\PluginInterface;

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
    protected string $version = 'v1.0.0';

    /**
     * Your plugins author
     *
     * @var string $author
     */
    protected string $author = 'Unknown Author';

    /**
     * @inheritDoc
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @inheritDoc
     */
    public function setFilename(string $filename): static
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @inheritDoc
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @inheritDoc
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @inheritDoc
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
     * @inheritDoc
     */
    public function isEnabled(): bool
    {
        $filename = pathinfo($this->getFilename())['dirname'] . DIRECTORY_SEPARATOR . explode('.', pathinfo($this->getFilename())['filename'])[0];
        return file_exists($filename . '.php');
    }

    /**
     * @inheritDoc
     */
    public function isDisabled(): bool
    {
        return ! $this->isEnabled();
    }

    /**
     * @inheritDoc
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
     * @inheritDoc
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
     * @inheritDoc
     */
    public function toggle(): static
    {
        return $this->isEnabled() ? $this->disable() : $this->enable();
    }

    /**
     * @inheritDoc
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
