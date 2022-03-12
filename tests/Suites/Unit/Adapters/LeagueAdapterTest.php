<?php

namespace Tests\Suites\Unit\Adapters;

use League\Container\DefinitionContainerInterface;
use Panamax\Adapters\League\LeagueAdapter;
use PHPUnit\Framework\MockObject\MockObject;
use stdClass;
use Tests\Support\TestCase;

class LeagueAdapterTest extends TestCase
{
    protected LeagueAdapter $adapter;

    protected MockObject $container;

    protected function setUp(): void
    {
        $containerStub = $this->createStub(DefinitionContainerInterface::class);

        $this->container = $containerStub;
        $this->adapter = new LeagueAdapter($containerStub);
    }

    /**
     * @test
     */
    public function it_adds_the_provided_id_and_concretion_to_the_container()
    {
        $id = 'service';
        $concrete = fn () => new stdClass();
        $resolved = $concrete();

        $this->container->method('get')->willReturn($resolved);
        $this->adapter->bind($id, $concrete);

        $this->assertSame($resolved, $this->adapter->get($id));
    }
}
