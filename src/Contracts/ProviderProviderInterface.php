<?php

namespace Panamax\Contracts;

interface ProviderProviderInterface
{
    /**
     * @throws InvalidServiceProviderExceptionInterface
     */
    public function addServiceProvider($provider);
}
