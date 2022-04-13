<?php

namespace Panamax\Adapters;

use Panamax\Contracts\ContainerAdapterInterface;
use Psr\Container\ContainerInterface;

abstract class AbstractContainerAdapter implements ContainerAdapterInterface
{
    protected ContainerInterface $container;

    public function get(string $id)
    {
        return $this->container->get($id);
    }

    public function has(string $id): bool
    {
        return $this->container->has($id);
    }

    public function getAdaptedContainer(): ContainerInterface
    {
        return $this->container;
    }
}
