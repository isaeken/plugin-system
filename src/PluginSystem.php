<?php

namespace IsaEken\PluginSystem;

use Exception;
use Illuminate\Contracts\Filesystem\Filesystem;
use IsaEken\PluginSystem\Collections\PluginCollection;
use IsaEken\PluginSystem\Enums\PluginState;
use IsaEken\PluginSystem\Traits\HasAutoloader;
use IsaEken\PluginSystem\Traits\HasFilesystem;
use IsaEken\PluginSystem\Traits\HasNamespace;
use IsaEken\PluginSystem\Traits\HasPlugins;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class PluginSystem
{
    use HasPlugins;
    use HasFilesystem;
    use HasNamespace;
    use HasAutoloader;

    protected PluginCollection $plugins;

    protected string $namespace;

    protected Filesystem $filesystem;

    protected Autoloader $autoloader;

    protected LoggerInterface $logger;

    /**
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    /**
     * @param  LoggerInterface  $logger
     * @return PluginSystem
     */
    public function setLogger(LoggerInterface $logger): self
    {
        $this->logger = $logger;

        return $this;
    }

    public function __construct()
    {
        if (empty($this->logger)) {
            $this->logger = new NullLogger();
        }

        foreach (class_uses($this) as $trait) {
            $method = str($trait)->afterLast('\\')->prepend('boot')->value();
            if (method_exists($trait, $method)) {
                $this->{$method}();
            }
        }

        if (empty($this->autoloader)) {
            $this->setAutoloader((new Autoloader())->setPluginSystem($this));
        }
    }

    public function load(string $directory): self
    {
        $this
            ->getAutoloader()
            ->setPluginSystem($this)
            ->load($directory);

        return $this;
    }

    public function handle(...$arguments): array
    {
        return $this->execute('handle', ...$arguments);
    }

    /**
     * @param  string  $method
     * @param ...$arguments
     * @return array<array{success: bool, plugin: \IsaEken\PluginSystem\Contracts\Plugin, data: mixed, time: float, exception: null|Exception}>
     */
    public function execute(string $method, ...$arguments): array
    {
        $results = [];

        /** @var \IsaEken\PluginSystem\Contracts\Plugin $plugin */
        foreach ($this->getPlugins() as $plugin) {
            if ($plugin->getState() === PluginState::Enabled) {
                $startTime = microtime(true);

                if (! method_exists($plugin, $method)) {
                    continue;
                }

                try {
                    $data = $plugin->{$method}(...$arguments);
                    $results[] = [
                        'success' => true,
                        'plugin' => $plugin,
                        'data' => $data,
                        'time' => microtime(true) - $startTime,
                        'exception' => null,
                    ];
                } catch (Exception $exception) {
                    $results[] = [
                        'success' => false,
                        'plugin' => $plugin,
                        'data' => null,
                        'time' => microtime(true) - $startTime,
                        'exception' => $exception,
                    ];

                    $this->getLogger()->error('Plugin error occurred', [
                        'plugin' => $plugin::class,
                        'exception' => $exception,
                    ]);
                }
            }
        }

        return $results;
    }
}
