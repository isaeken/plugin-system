<?php

namespace IsaEken\PluginSystem\Traits;

use Illuminate\Contracts\Filesystem\Filesystem;

trait HasFilesystem
{
    public function bootHasFilesystem(): void
    {
        if (empty($this->filesystem)) {
            $this->filesystem = new \IsaEken\PluginSystem\Filesystem();
        }
    }

    /**
     * @return Filesystem
     */
    public function getFilesystem(): Filesystem
    {
        return $this->filesystem;
    }

    /**
     * @param  Filesystem  $filesystem
     * @return self
     */
    public function setFilesystem(Filesystem $filesystem): self
    {
        $this->filesystem = $filesystem;

        return $this;
    }

    /**
     * @param  Filesystem  $filesystem
     * @return self
     */
    public static function useFilesystem(Filesystem $filesystem): self
    {
        return (new static())->setFilesystem($filesystem);
    }
}
