<?php

namespace Panamax\Contracts;

interface ServiceContainerLauncherInterface
{
    public function maybeAddServices(iterable $services);

    public function maybeAddProviders(iterable $providers);

    public function maybeBootProviders();
}
