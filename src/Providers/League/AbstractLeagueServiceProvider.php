<?php

namespace Panamax\Providers\League;

use League\Container\Definition\DefinitionInterface;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Psr\Container\ContainerInterface;

abstract class AbstractLeagueServiceProvider extends AbstractServiceProvider
{
    /**
     * {@inheritDoc}
     */
    public function provides(string $id): bool
    {
        return in_array($id, $this->combinedReferences());
    }

    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $id = $this->id();
        $definition = $this->define($id, $this->concrete());

        foreach ($this->combinedAliases() as $alias) {
            $this->define($alias, $id);
        }

        foreach ($this->combinedTags() as $tag) {
            $definition->addTag($tag);
        }
    }

    protected function combinedReferences(): array
    {
        return [
            $this->id(),
            ...$this->combinedAliases(),
            ...$this->combinedTags()
        ];
    }

    protected function combinedAliases(): array
    {
        return [...$this->aliases(), ...$this->types()];
    }

    protected function combinedTags(): array
    {
        return $this->tags();
    }

    protected function define(string $id, mixed $concrete): DefinitionInterface
    {
        $definition = $this->getContainer()->add($id, $concrete);

        $shared = $this->shared();

        if (isset($shared)) {
            $definition->setShared($shared);
        }

        return $definition;
    }

    protected function concrete(): mixed
    {
        return $this->service($this->getContainer());
    }

    protected function shared(): ?bool
    {
        return true;
    }

    /**
     * @return array<string>
     */
    protected function aliases(): array
    {
        return [];
    }

    /**
     * @return array<class-string>
     */
    protected function types(): array
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
