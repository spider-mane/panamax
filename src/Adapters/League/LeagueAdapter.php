<?php

namespace Panamax\Adapters\League;

use League\Container\DefinitionContainerInterface;
use League\Container\ServiceProvider\ServiceProviderInterface;
use Panamax\Adapters\AbstractContainerAdapter;
use Panamax\Contracts\ContainerAdapterInterface;
use Panamax\Contracts\ProviderContainerInterface;
use Panamax\Contracts\ServiceCreatorInterface;
use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Exceptions\InvalidServiceProviderException;
use Panamax\Traits\ServiceCreatorTrait;
use Traversable;
use TypeError;

class LeagueAdapter extends AbstractContainerAdapter implements ContainerAdapterInterface, ProviderContainerInterface, ServiceCreatorInterface
{
    use ServiceCreatorTrait;

    /**
     * @var DefinitionContainerInterface
     */
    protected $container;

    public function __construct(DefinitionContainerInterface $container)
    {
        $this->container = $container;
    }

    public function bind(string $id, $concrete = null, ?bool $shared = null)
    {
        $definition = $this->container->add($id, $concrete);

        if (isset($shared)) {
            $definition->setShared($shared);
        }
    }

    public function share(string $id, $concrete = null)
    {
        $this->container->addShared($id, $concrete);
    }

    public function addServiceProvider($provider)
    {
        try {
            $this->container->addServiceProvider($provider);
        } catch (TypeError $e) {
            throw new InvalidServiceProviderException(
                __METHOD__,
                ServiceProviderInterface::class
            );
        }
    }

    public function createServices(Traversable $services)
    {
        foreach ($services as $service) {
            $id = $service['id'];
            $factory = $service['factory'];
            $args = $service['args'] ?? [];

            unset($service['id'], $service['factory'], $service['args']);

            if ($this->isValidFactory($factory)) {
                $factory = $this->getResolvedFactory($factory);
            } else {
                throw $this->invalidFactoryException($id);
            }

            $this->createService($id, $factory, $args, $service);
        }
    }

    public function createService(string $id, ServiceFactoryInterface $factory, array $args = [], $options = [])
    {
        $definition = $this->container->add(
            $id,
            $factory->pledge($this->container, $args)
        );

        if ($shared = $options['shared'] ?? null) {
            $definition->setShared($shared);
        }

        array_map([$definition, 'addTag'], $options['tags'] ?? []);
    }
}
