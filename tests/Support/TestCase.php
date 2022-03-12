<?php

declare(strict_types=1);

namespace Tests\Support;

use Mockery;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class TestCase extends PHPUnitTestCase
{
    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }
}
