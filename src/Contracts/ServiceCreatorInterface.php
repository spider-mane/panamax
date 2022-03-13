<?php

namespace Panamax\Contracts;

interface ServiceCreatorInterface
{
    public function createService(string $id, ServiceFactoryInterface $factory, array $args = [], array $options = []);

    public function createServices(iterable $services);
}
