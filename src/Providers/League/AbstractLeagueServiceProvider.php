<?php

namespace Panamax\Providers\League;

use League\Container\Definition\DefinitionInterface;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Psr\Container\ContainerInterface;

abstract class AbstractLeagueServiceProvider extends AbstractServiceProvider
{
    private readonly array $references;

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

    /**
     * @return list<string|class-string>
     */
    protected function combinedReferences(): array
    {
        return $this->references ??= [
            $this->id(),
            ...$this->combinedAliases(),
            ...$this->combinedTags()
        ];
    }

    /**
     * @return list<string|class-string>
     */
    protected function combinedAliases(): array
    {
        return [...$this->aliases(), ...$this->types()];
    }

    /**
     * @return list<string|class-string>
     */
    protected function combinedTags(): array
    {
        return [...$this->tags(), ...$this->fulfillments()];
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
     * @return list<string>
     */
    protected function aliases(): array
    {
        return [];
    }

    /**
     * @return list<class-string>
     */
    protected function types(): array
    {
        return [];
    }

    /**
     * @return list<string>
     */
    protected function tags(): array
    {
        return [];
    }

    /**
     * @return list<class-string>
     */
    protected function fulfillments(): array
    {
        return [];
    }

    abstract protected function service(ContainerInterface $container);

    abstract protected function id(): string;
}
