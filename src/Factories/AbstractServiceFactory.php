<?php

namespace Panamax\Factories;

use Closure;
use Panamax\Contracts\ServiceFactoryInterface;
use Psr\Container\ContainerInterface;

abstract class AbstractServiceFactory implements ServiceFactoryInterface
{
    public function pledge(ContainerInterface $container, array $args = []): Closure
    {
        return fn () => $this->create($container, $args);
    }

    public static function instance(): ServiceFactoryInterface
    {
        return new static();
    }
}
