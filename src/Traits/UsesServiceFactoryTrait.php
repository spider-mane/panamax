<?php

namespace Panamax\Traits;

use Panamax\Contracts\ServiceFactoryInterface;
use Psr\Container\ContainerInterface;

trait UsesServiceFactoryTrait
{
    protected function service(ContainerInterface $container)
    {
        return $this->factory()->create($container, $this->args() ?? []);
    }

    protected function args(): ?array
    {
        return [];
    }

    abstract protected function factory(): ServiceFactoryInterface;
}
