<?php

namespace Panamax\Contracts;

use Closure;

interface ServiceEnclosureInterface
{
    public function reveal(): Closure;
}
