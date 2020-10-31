<?php

namespace IsaEken\PluginSystem\Exceptions;

use Exception;
use Throwable;

class AttributeNotExistsException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}