<?php

namespace Panamax\Contracts;

use Traversable;

interface ServiceCreatorInterface
{
    public function createService(string $id, ServiceFactoryInterface $factory, array $args = [], array $options = []);

    public function createServices(Traversable $services);
}
