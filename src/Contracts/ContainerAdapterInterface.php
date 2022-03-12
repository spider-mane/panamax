<?php

namespace Panamax\Contracts;

use Psr\Container\ContainerInterface;

interface ContainerAdapterInterface extends ServiceContainerInterface
{
    public function getAdaptedContainer(): ContainerInterface;
}
