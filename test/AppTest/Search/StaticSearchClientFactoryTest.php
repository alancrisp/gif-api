<?php
declare(strict_types=1);

namespace AppTest\Search;

use App\Search\StaticSearchClient;
use App\Search\StaticSearchClientFactory;
use Exception;
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

    public function testThrowsExceptionOnMissingBaseUrl(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Base URL is not configured');
        $factory = $this->factory;
        $factory($this->container->reveal());
    }

    public function testCreatesStaticSearchClient(): void
    {
        $this->container->get('config')->willReturn([
            'urls' => [
                'base' => 'img.allthegifs.com',
            ],
        ]);
        $factory = $this->factory;
        $this->assertInstanceOf(StaticSearchClient::class, $factory($this->container->reveal()));
    }
}
