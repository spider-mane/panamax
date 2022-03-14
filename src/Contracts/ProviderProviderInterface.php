<?php

namespace Panamax\Contracts;

interface ProviderProviderInterface
{
    /**
     * @throws InvalidServiceProviderExceptionInterface
     */
    public function addServiceProvider(string $provider, ?array $args = null);

    /**
     * @param string[] $providers
     */
    public function addServiceProviders(iterable $providers);
}
