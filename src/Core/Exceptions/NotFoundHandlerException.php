<?php

namespace Tenqz\Lingua\Core\Exceptions;

/**
 * Exception thrown when a text processing handler is not found
 */
class NotFoundHandlerException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Handler not found');
    }
}
