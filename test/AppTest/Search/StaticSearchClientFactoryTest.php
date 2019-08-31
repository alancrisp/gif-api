<?php
declare(strict_types=1);

namespace AppTest\Search;

use App\Search\StaticSearchClient;
use App\Search\StaticSearchClientFactory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class StaticSearchClientFactoryTest extends TestCase
{
    private $factory;
    private $container;

    protected function setUp()
    {
        $this->factory = new StaticSearchClientFactory();
        $this->container = $this->prophesize(ContainerInterface::class);
    }

    public function testCreatesStaticSearchClient(): void
    {
        $factory = $this->factory;
        $this->assertInstanceOf(StaticSearchClient::class, $factory($this->container->reveal()));
    }
}
