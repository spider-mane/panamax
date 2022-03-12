<?php

namespace Panamax\Contracts;

interface ProviderLauncherInterface extends ProviderProviderInterface
{
    public function bootServiceProviders();
}
