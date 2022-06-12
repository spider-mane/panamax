<?php

namespace Panamax;

use Closure;
use Panamax\Contracts\ServiceEnclosureInterface;

class ServiceEnclosure implements ServiceEnclosureInterface
{
    protected object $saved;

    protected Closure $enclosure;

    public function __construct(callable $factory)
    {
        $this->enclosure = $this->buildEnclosure($factory);
    }

    public function reveal(): Closure
    {
        return $this->enclosure;
    }

    protected function buildEnclosure(callable $factory): Closure
    {
        return fn () => $this->saved ??= ($factory)(...func_get_args());
    }

    public static function enclose(callable $factory): Closure
    {
        $enclosure = new static($factory);

        return $enclosure->reveal();
    }
}
