<?php

namespace Panamax\Contracts;

interface InjectorInterface
{
    public function bind(string $id, $concrete = null, bool $shared = false);

    public function share(string $id, $concrete = null);
}
