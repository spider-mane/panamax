<?php

namespace Panamax\Traits;

use Panamax\Contracts\ServiceFactoryInterface;
use RuntimeException;
use UnexpectedValueException;

trait ServiceCreatorTrait
{
    protected function isValidFactory($factory): bool
    {
        return in_array(
            ServiceFactoryInterface::class,
            class_implements($factory)
        );
    }

    protected function getResolvedFactory($factory): ServiceFactoryInterface
    {
        return $factory instanceof ServiceFactoryInterface
            ? $factory
            : $factory::instance();
    }

    protected function invalidFactoryException(string $serviceId): RuntimeException
    {
        $interface = ServiceFactoryInterface::class;

        return new UnexpectedValueException(
            "Value of \"factory\" for service \"{$serviceId}\" must implement \"{$interface}\""
        );
    }
}
