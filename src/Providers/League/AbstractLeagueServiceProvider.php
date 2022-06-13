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
        return in_array($id, [
            $this->id(),
            ...$this->combinedAliases(),
            ...$this->combinedTags()
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $container = $this->getContainer();
        $definition = $container->add(
            $id = $this->id(),
            fn () => $this->service($container)
        );

        if (null !== $shared = $this->shared()) {
            $definition->setShared($shared);
        }

        foreach ($this->combinedAliases() as $alias) {
            $container->add($alias, $id);
        }

        foreach ($this->combinedTags() as $tag) {
            $definition->addTag($tag);
        }
    }

    protected function combinedAliases(): array
    {
        return [...$this->types(), ...$this->aliases()];
    }

    protected function combinedTags(): array
    {
        return $this->tags();
    }

    protected function shared(): ?bool
    {
        return true;
    }

    /**
     * @return array<string>
     */
    protected function types(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function aliases(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function tags(): array
    {
        return [];
    }

    abstract protected function service(ContainerInterface $container);

    abstract protected function id(): string;
}
