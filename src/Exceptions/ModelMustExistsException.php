<?php

namespace Maize\Cache\Exceptions;

use Exception;

class ModelMustExistsException extends Exception
{
    public function __construct(string $message = 'Model must exists')
    {
        parent::__construct($message);
    }
}
