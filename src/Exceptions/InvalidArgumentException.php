<?php

    namespace Eskirex\Component\Console\Exceptions;

    use Throwable;

    class InvalidArgumentException extends \Exception
    {
        public function __construct($message = "", $code = 0, Throwable $previous = null)
        {
            parent::__construct($message, $code, $previous);
        }
    }