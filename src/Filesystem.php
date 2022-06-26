<?php

namespace IsaEken\PluginSystem;

class Filesystem implements \Illuminate\Contracts\Filesystem\Filesystem
{
    private \Illuminate\Contracts\Filesystem\Filesystem|null $filesystem = null;

    public static function use(\Illuminate\Contracts\Filesystem\Filesystem $filesystem): static
    {
        $instance = new static();
        $instance->filesystem = $filesystem;

        return $instance;
    }

    public function exists($path)
    {
        if (is_null($this->filesystem)) {
            return file_exists($path);
        }

        return $this->filesystem->{__FUNCTION__}(...func_get_args());
    }

    public function get($path)
    {
        if (is_null($this->filesystem)) {
            return file_get_contents($path);
        }

        return $this->filesystem->{__FUNCTION__}(...func_get_args());
    }

    public function readStream($path)
    {
        if (is_null($this->filesystem)) {
            return fopen($path, 'r');
        }

        return $this->filesystem->{__FUNCTION__}(...func_get_args());
    }

    public function put($path, $contents, $options = [])
    {
        if (is_null($this->filesystem)) {
            return file_put_contents($path, $contents, $options) !== false;
        }

        return $this->filesystem->{__FUNCTION__}(...func_get_args());
    }

    public function writeStream($path, $resource, array $options = [])
    {
        if (is_null($this->filesystem)) {
            return fopen($path, $resource, $options);
        }

        return $this->filesystem->{__FUNCTION__}(...func_get_args());
    }

    public function getVisibility($path)
    {
        return $this->filesystem->{__FUNCTION__}(...func_get_args());
    }

    public function setVisibility($path, $visibility)
    {
        return $this->filesystem->{__FUNCTION__}(...func_get_args());
    }

    public function prepend($path, $data)
    {
        if (is_null($this->filesystem)) {
            $contents = $this->get($path);

            return $this->put($path, $data.$contents);
        }

        return $this->filesystem->{__FUNCTION__}(...func_get_args());
    }

    public function append($path, $data)
    {
        if (is_null($this->filesystem)) {
            $contents = $this->get($path);

            return $this->put($path, $contents.$data);
        }

        return $this->filesystem->{__FUNCTION__}(...func_get_args());
    }

    public function delete($paths)
    {
        if (is_null($this->filesystem)) {
            if (is_array($paths)) {
                $success = true;
                foreach ($paths as $path) {
                    if (unlink($path) === false) {
                        $success = false;
                    }
                }

                return $success;
            }

            return unlink($paths);
        }

        return $this->filesystem->{__FUNCTION__}(...func_get_args());
    }

    public function copy($from, $to)
    {
        if (is_null($this->filesystem)) {
            return copy($from, $to);
        }

        return $this->filesystem->{__FUNCTION__}(...func_get_args());
    }

    public function move($from, $to)
    {
        if (is_null($this->filesystem)) {
            $success = $this->copy($from, $to);
            if ($success) {
                $success = $this->delete($from);

                if (! $success) {
                    $this->delete($to);
                }
            }

            return $success;
        }

        return $this->filesystem->{__FUNCTION__}(...func_get_args());
    }

    public function size($path)
    {
        if (is_null($this->filesystem)) {
            return filesize($path);
        }

        return $this->filesystem->{__FUNCTION__}(...func_get_args());
    }

    public function lastModified($path)
    {
        if (is_null($this->filesystem)) {
            return filemtime($path);
        }

        return $this->filesystem->{__FUNCTION__}(...func_get_args());
    }

    public function files($directory = null, $recursive = false)
    {
        if (is_null($this->filesystem)) {
            $files = [];

            foreach (glob($directory.'/*') as $path) {
                if (is_dir($path) && $recursive === false || ($path == '.' || $path == '..')) {
                    continue;
                }

                if (is_dir($path)) {
                    $files = [...$files, $this->files($path, $recursive)];
                }

                $files[] = $path;
            }

            return $files;
        }

        return $this->filesystem->{__FUNCTION__}(...func_get_args());
    }

    public function allFiles($directory = null)
    {
        if (is_null($this->filesystem)) {
            return $this->files($directory, true);
        }

        return $this->filesystem->{__FUNCTION__}(...func_get_args());
    }

    public function directories($directory = null, $recursive = false)
    {
        if (is_null($this->filesystem)) {
            $directories = [];

            foreach (glob("$directory/*") as $path) {
                if (! is_dir($path) || ($path == '.' || $path == '..')) {
                    continue;
                }
                $directories[] = $path;

                if ($recursive) {
                    $directories[] = [...$directories, $this->directories($path, $recursive)];
                }
            }

            return $directories;
        }

        return $this->filesystem->{__FUNCTION__}(...func_get_args());
    }

    public function allDirectories($directory = null)
    {
        if (is_null($this->filesystem)) {
            return $this->directories($directory, true);
        }

        return $this->filesystem->{__FUNCTION__}(...func_get_args());
    }

    public function makeDirectory($path)
    {
        if (is_null($this->filesystem)) {
            return mkdir($path, recursive: true);
        }

        return $this->filesystem->{__FUNCTION__}(...func_get_args());
    }

    public function deleteDirectory($directory)
    {
        if (is_null($this->filesystem)) {
            if ($this->delete($this->allFiles($directory)) === false) {
                return false;
            }

            if ($this->delete($this->allDirectories($directory)) === false) {
                return false;
            }

            return $this->delete($directory);
        }

        return $this->filesystem->{__FUNCTION__}(...func_get_args());
    }
}
