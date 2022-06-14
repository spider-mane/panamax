<?php

namespace Panamax\Factories;

use Closure;
use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\ServiceEnclosure;
use Psr\Container\ContainerInterface;

abstract class AbstractServiceFactory implements ServiceFactoryInterface
{
    public function pledge(ContainerInterface $container, array $args = []): Closure
    {
        return fn () => $this->create($container, $args);
    }

    public function commit(ContainerInterface $container, array $args = []): Closure
    {
        return ServiceEnclosure::enclose($this->pledge($container, $args));
    }

    protected function fetch(string $service, ContainerInterface $container)
    {
        return $container->has($service) ? $container->get($service) : null;
    }

    public static function instance(): ServiceFactoryInterface
    {
        return new static();
    }
}
