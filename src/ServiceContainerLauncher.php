<?php

namespace Panamax;

use Panamax\Contracts\BootableProviderContainerInterface;
use Panamax\Contracts\ServiceContainerLauncherInterface;
use Panamax\Contracts\ProviderContainerInterface;
use Panamax\Contracts\ServiceCreatorInterface;
use Panamax\Contracts\ServiceContainerInterface;

class ServiceContainerLauncher implements ServiceContainerLauncherInterface
{
    protected ServiceContainerInterface $container;

    public function __construct(ServiceContainerInterface $container)
    {
        $this->container = $container;
    }

    public function maybeAddServices(iterable $services)
    {
        if ($this->container instanceof ServiceCreatorInterface) {
            $this->container->createServices($services);
        }
    }

    public function maybeAddProviders(iterable $providers)
    {
        if ($this->container instanceof ProviderContainerInterface) {
            foreach ($providers as $provider) {
                $this->container->addServiceProvider($provider);
            }
        }
    }

    public function maybeBootProviders()
    {
        if ($this->container instanceof BootableProviderContainerInterface) {
            $this->container->bootServiceProviders();
        }
    }
}
