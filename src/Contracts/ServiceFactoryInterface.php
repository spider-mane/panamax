<?php

namespace Panamax\Contracts;

use Closure;
use Psr\Container\ContainerInterface;

interface ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = []);

    public function pledge(ContainerInterface $container, array $args = []): Closure;

    public function commit(ContainerInterface $container, array $args = []): Closure;

    /**
     * @return static
     */
    public static function instance(): ServiceFactoryInterface;
}
