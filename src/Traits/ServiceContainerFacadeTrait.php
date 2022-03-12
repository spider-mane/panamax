<?php

namespace Panamax\Traits;

use Panamax\Contracts\ServiceContainerInterface;

trait ServiceContainerFacadeTrait
{
    /**
     * @var ServiceContainerInterface
     */
    protected static $container;

    protected static function _updateContainer(string $name, object $instance): void
    {
        static::$container->share($name, $instance);
    }
}
