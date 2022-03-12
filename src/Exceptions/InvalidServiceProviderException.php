<?php

namespace Panamax\Exceptions;

use InvalidArgumentException;
use Panamax\Contracts\InvalidServiceProviderExceptionInterface;
use Throwable;

class InvalidServiceProviderException extends InvalidArgumentException implements InvalidServiceProviderExceptionInterface
{
    public function __construct(string $method, string $providerInterface, $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            "Service provider passed to {$method} must be instance of {$providerInterface}",
            $code,
            $previous
        );
    }
}
