<?php

namespace Tests\Suites\Unit\Adapters;

use League\Container\DefinitionContainerInterface;
use Panamax\Adapters\League\LeagueAdapter;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\Support\TestCase;

class LeagueAdapterTest extends TestCase
{
    protected LeagueAdapter $sut;

    /**
     * @var DefinitionContainerInterface&MockObject
     */
    protected DefinitionContainerInterface $mockContainer;

    protected function setUp(): void
    {
        parent::setUp();

        $container = $this->createMock(DefinitionContainerInterface::class);

        $this->mockContainer = $container;
        $this->sut = new LeagueAdapter($container);
    }

    /**
     * @test
     */
    public function it_adds_the_provided_id_and_concretion_to_the_container()
    {
        $id = $this->fake->slug;
        $concrete = fn () => $this->fake->dateTime;
        $resolved = $concrete();

        $this->mockContainer->method('get')->willReturn($resolved);
        $this->sut->bind($id, $concrete, false);

        $this->assertNotSame($concrete(), $this->sut->get($id)); // smoke test
        $this->assertSame($resolved, $this->sut->get($id));
    }
}
