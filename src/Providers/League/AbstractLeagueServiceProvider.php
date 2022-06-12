<?php

namespace Panamax\Providers\League;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Psr\Container\ContainerInterface;

abstract class AbstractLeagueServiceProvider extends AbstractServiceProvider
{
    /**
     * {@inheritDoc}
     */
    public function provides(string $id): bool
    {
        return in_array($id, [$this->serviceId(), ...$this->serviceTags()]);
    }

    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $container = $this->getContainer();
        $definition = $container->add(
            $id = $this->serviceId(),
            fn () => $this->service($container)
        );

        if (null !== $shared = $this->shared()) {
            $definition->setShared($shared);
        }

        foreach ($this->serviceAliases() as $alias) {
            $container->add($alias, $id);
        }

        foreach ($this->serviceTags() as $tag) {
            $definition->addTag($tag);
        }
    }

    protected function shared(): ?bool
    {
        return true;
    }

    /**
     * @return array<string>
     */
    protected function serviceAliases(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function serviceTags(): array
    {
        return [];
    }

    abstract protected function service(ContainerInterface $container);

    abstract protected function serviceId(): string;
}
